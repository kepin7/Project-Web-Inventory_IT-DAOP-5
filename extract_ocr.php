<?php
$transcriptPath = 'C:\Users\Kepin\.gemini\antigravity-ide\brain\e620e16f-cbc5-4d7c-a457-1f6fa882b5d7\.system_generated\logs\transcript_full.jsonl';
$lines = file($transcriptPath);

$ocrText = "";
$isOcr = false;

// Process backwards to find the last user message with OCR
foreach (array_reverse($lines) as $line) {
    $data = json_decode($line, true);
    if ($data && $data['type'] === 'USER_INPUT') {
        $content = $data['content'];
        $contentLines = explode("\n", $content);
        foreach ($contentLines as $cLine) {
            if (strpos($cLine, '==Start of OCR') !== false) {
                $isOcr = true;
                continue;
            }
            if (strpos($cLine, '==End of OCR') !== false) {
                $isOcr = false;
                continue;
            }
            if ($isOcr) {
                $ocrText .= $cLine . "\n";
            }
        }
        if (strlen($ocrText) > 0) {
            break; // found it
        }
    }
}

file_put_contents('ocr_extracted.txt', $ocrText);
echo "OCR Extracted! Length: " . strlen($ocrText) . "\n";
