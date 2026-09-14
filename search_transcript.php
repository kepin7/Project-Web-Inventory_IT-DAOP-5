<?php
$lines = file('C:\Users\Kepin\.gemini\antigravity-ide\brain\e620e16f-cbc5-4d7c-a457-1f6fa882b5d7\.system_generated\logs\transcript_full.jsonl');
foreach ($lines as $line) {
    if (strpos($line, 'INSERT INTO `categories`') !== false) {
        $data = json_decode($line, true);
        if (isset($data['content'])) {
            $content = $data['content'];
            if (strpos($content, 'INSERT INTO `categories`') !== false) {
                // Find the lines containing the insert
                $parts = explode("\n", $content);
                for ($i=0; $i < count($parts); $i++) {
                    if (strpos($parts[$i], 'INSERT INTO `categories`') !== false) {
                        echo $parts[$i] . "\n";
                        if (isset($parts[$i+1])) echo $parts[$i+1] . "\n";
                        if (isset($parts[$i+2])) echo $parts[$i+2] . "\n";
                        if (isset($parts[$i+3])) echo $parts[$i+3] . "\n";
                    }
                }
            }
        }
    }
}
