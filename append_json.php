<?php

$jsonData = json_decode(file_get_contents('extracted_data.json'), true);

$page_idx = -1;

$page_categories = [
    0 => 'CPU', 1 => 'CPU',
    2 => 'MONITOR', 3 => 'MONITOR',
    4 => 'PRINTER', 5 => 'PRINTER',
    6 => 'SWITCH', 7 => 'SWITCH', 8 => 'SWITCH', 9 => 'SWITCH',
    10 => 'UPS',
    11 => 'AIO', 12 => 'AIO',
    13 => 'DRIVE'
];

$sqlAppend = "\n\n-- Data Diimpor dari PDF oleh AI --\n";
$sqlAppend .= "INSERT INTO `spare_parts` (`category_id`, `location_id`, `brand`, `type`, `serial_number`, `inventory_number`, `description`, `condition`, `created_at`, `updated_at`) VALUES \n";

$values = [];

// Create default categories mapping
// In a static dump, we might just assume category IDs:
// CPU=1, MONITOR=2, PRINTER=3, SWITCH=4, UPS=5, AIO=6, DRIVE=7
$categoryIds = [
    'CPU' => 1, 'MONITOR' => 2, 'PRINTER' => 3, 'SWITCH' => 4, 'UPS' => 5, 'AIO' => 6, 'DRIVE' => 7
];

foreach ($jsonData as $row) {
    if (count($row) < 4) continue;
    
    // Check if header
    if (strtoupper($row[0]) === 'NO' && strtoupper($row[1]) === 'MERK') {
        $page_idx++;
        continue;
    }
    
    // Sometimes 'NO' column is missing or offset
    if (!is_numeric($row[0]) && !is_numeric($row[1])) continue; // Not a valid row
    
    $category_name = $page_categories[$page_idx] ?? 'CPU';
    $cat_id = $categoryIds[$category_name];
    $loc_id = 1; // Default to 1 (Gudang IT)

    // For DRIVE (Page 13), format is different:
    // No, Merk, Type, SN, Kapasitas
    if ($category_name === 'DRIVE') {
        $merk = addslashes(trim($row[1]));
        $type = addslashes(trim($row[2]));
        $sn = trim($row[3]) ? "'" . addslashes(trim($row[3])) . "'" : "NULL";
        $no_inv = "NULL";
        $ket = trim($row[4]) ? "'" . addslashes(trim($row[4])) . "'" : "NULL";
        $cond = 'Normal';
    } else {
        $merk = addslashes(trim($row[1]));
        $type = addslashes(trim($row[2]));
        $sn = trim($row[3]) ? "'" . addslashes(trim($row[3])) . "'" : "NULL";
        $no_inv = isset($row[4]) && trim($row[4]) ? "'" . addslashes(trim($row[4])) . "'" : "NULL";
        $ket = isset($row[5]) && trim($row[5]) ? "'" . addslashes(trim($row[5])) . "'" : "NULL";
        $kondisi = isset($row[7]) ? strtoupper(trim($row[7])) : '';
        
        $cond = 'Normal';
        if (strpos($kondisi, 'RUSAK') !== false || strpos($kondisi, 'MATI') !== false) {
            $cond = 'Rusak';
        } elseif ($kondisi !== '' && $kondisi !== 'NORMAL' && $kondisi !== 'BAIK') {
            $cond = 'Perbaikan';
        }
    }
    
    $values[] = "($cat_id, $loc_id, '$merk', '$type', $sn, $no_inv, $ket, '$cond', NOW(), NOW())";
}

$sqlAppend .= implode(",\n", $values) . ";\n";

file_put_contents('inventory_daop5.sql', $sqlAppend, FILE_APPEND);
echo "Berhasil menambahkan " . count($values) . " perintah INSERT ke dalam inventory_daop5.sql!\n";
