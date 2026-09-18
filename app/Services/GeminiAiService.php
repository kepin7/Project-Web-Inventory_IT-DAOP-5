<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiService
{
    protected array $apiKeys;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $keysString = env('GEMINI_API_KEYS', '');
        $this->apiKeys = array_filter(array_map('trim', explode(',', $keysString)));
        
        // Fallback ke single key jika GEMINI_API_KEYS tidak ada
        if (empty($this->apiKeys) && env('GEMINI_API_KEY')) {
            $this->apiKeys[] = env('GEMINI_API_KEY');
        }
    }

    protected function getRandomKey(): ?string
    {
        if (empty($this->apiKeys)) {
            return null;
        }
        return $this->apiKeys[array_rand($this->apiKeys)];
    }

    /**
     * Mengekstrak data dari gambar base64
     */
    public function extractFromImage(string $base64Image, string $mimeType = 'image/jpeg'): ?array
    {
        $apiKey = $this->getRandomKey();
        
        if (!$apiKey) {
            Log::error('Gemini API Keys are not set.');
            return null;
        }

        // Prompt spesifik agar AI mengembalikan JSON saja
        $prompt = "Tolong analisis gambar/foto komponen atau perangkat IT berikut ini. " .
                  "Ekstrak teks di dalamnya dan tebak nilai-nilai berikut: brand (merk), type (tipe model), serial_number (jika ada), " .
                  "dan inventory_number (jika ada stiker/label inventaris). " .
                  "KEMBALIKAN HANYA dalam format JSON valid seperti ini: " .
                  '{"brand": "HP", "type": "PRO 3330", "serial_number": "SGH123", "inventory_number": "IT.001"} ' .
                  "Jangan tambahkan teks markdown seperti ```json atau penjelasan apapun, cukup JSON mentahnya saja.";

        $response = Http::post($this->baseUrl . '?key=' . $apiKey, [
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
