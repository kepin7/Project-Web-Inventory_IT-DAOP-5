<?php

namespace App\Http\Controllers;

use App\Services\GeminiAiService;
use Illuminate\Http\Request;

class AiExtractController extends Controller
{
    public function extract(Request $request, GeminiAiService $geminiAiService)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // Maks 10MB
        ]);

        $image = $request->file('image');
        $base64Image = base64_encode(file_get_contents($image->getRealPath()));
        $mimeType = $image->getMimeType();

        $extractedData = $geminiAiService->extractFromImage($base64Image, $mimeType);

        if (!$extractedData) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekstrak data dari gambar atau API Key belum diset.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $extractedData
        ]);
    }
}
