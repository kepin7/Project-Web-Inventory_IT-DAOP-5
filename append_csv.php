<?php

$csvFile = 'C:\Users\Kepin\.gemini\antigravity-ide\brain\e620e16f-cbc5-4d7c-a457-1f6fa882b5d7\.user_uploaded\media_1789041572765.csv';
$csvData = file($csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$sqlAppend = "\n\n-- Data Diimpor dari CSV oleh AI --\n";
$sqlAppend .= "INSERT INTO `spare_parts` (`category_id`, `location_id`, `brand`, `type`, `serial_number`, `inventory_number`, `description`, `condition`, `created_at`, `updated_at`) VALUES \n";

$values = [];
$monitorCat = 2; // Monitor is 2 based on my earlier DatabaseSeeder logic

foreach ($csvData as $idx => $line) {
    if ($idx === 0) continue; // skip header
    
    $row = explode(';', $line);
    if (count($row) < 7) continue;
    
    $merk = addslashes(trim($row[1]));
    $type = addslashes(trim($row[2]));
    $sn = trim($row[3]) ? "'" . addslashes(trim($row[3])) . "'" : "NULL";
    $no_inv = trim($row[4]) ? "'" . addslashes(trim($row[4])) . "'" : "NULL";
    $ket = trim($row[5]) ? "'" . addslashes(trim($row[5])) . "'" : "NULL";
    $kondisi = isset($row[7]) ? strtoupper(trim($row[7])) : '';
    
    $cond = 'Normal';
    if (strpos($kondisi, 'RUSAK') !== false || strpos($kondisi, 'MATI') !== false || strpos($kondisi, 'KUNING') !== false || strpos($kondisi, 'BERGARIS') !== false || strpos($kondisi, 'KURANG CERAH') !== false) {
        $cond = 'Perbaikan';
    }
    if (strpos($kondisi, 'RUSAK PARAH') !== false) {
        $cond = 'Rusak';
    }
    if ($kondisi === 'NORMAL' || $kondisi === 'BAIK') {
        $cond = 'Normal';
    }
    
    // Asumsi Gudang IT adalah location_id = 1
    $lokasi_id = 1;

    $values[] = "($monitorCat, $lokasi_id, '$merk', '$type', $sn, $no_inv, $ket, '$cond', NOW(), NOW())";
}

$sqlAppend .= implode(",\n", $values) . ";\n";

file_put_contents('inventory_daop5.sql', $sqlAppend, FILE_APPEND);
echo "Berhasil menambahkan " . count($values) . " perintah INSERT dari CSV ke dalam inventory_daop5.sql!\n";
