<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY', '');
    }

    /**
     * Mengekstrak data dari gambar base64
     */
    public function extractFromImage(string $base64Image, string $mimeType = 'image/jpeg'): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API Key is not set.');
            return null;
        }

        // Prompt spesifik agar AI mengembalikan JSON saja
        $prompt = "Tolong analisis gambar/foto komponen atau perangkat IT berikut ini. " .
                  "Ekstrak teks di dalamnya dan tebak nilai-nilai berikut: brand (merk), type (tipe model), serial_number (jika ada), " .
                  "dan inventory_number (jika ada stiker/label inventaris). " .
                  "KEMBALIKAN HANYA dalam format JSON valid seperti ini: " .
                  '{"brand": "HP", "type": "PRO 3330", "serial_number": "SGH123", "inventory_number": "IT.001"} ' .
                  "Jangan tambahkan teks markdown seperti ```json atau penjelasan apapun, cukup JSON mentahnya saja.";

        $response = Http::post($this->baseUrl . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                        [
                            'inlineData' => [
                                'mimeType' => $mimeType,
                                'data' => $base64Image
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // Bersihkan teks jika ada sisa markdown ```json
            $text = trim(str_replace(['```json', '```'], '', $text));
            
            $result = json_decode($text, true);
            
            return $result;
        }

        Log::error('Gemini API Error: ' . $response->body());
        return null;
    }
}
