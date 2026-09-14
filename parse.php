<?php
$content = file_get_contents('storage/app/raw_data.txt');
$blocks = explode('---', $content);
$categories = ['CPU', 'MONITOR', 'PRINTER', 'SWITCH', 'UPS', 'AIO', 'DRIVE'];
$data = [];

foreach ($blocks as $i => $block) {
    $lines = array_filter(array_map('trim', explode("\n", $block)));
    if (empty($lines)) continue;
    $lines = array_values($lines);
    
    $category = $i < count($categories) ? $categories[$i] : 'OTHER';
    
    if (strpos($lines[0], 'NO') === 0 || strpos($lines[0], 'No') === 0) {
        array_shift($lines);
    }
    
    foreach ($lines as $line) {
        $parts = preg_split('/\s+/', $line);
        if (empty($parts) || !is_numeric($parts[0])) continue;
        
        array_shift($parts); // remove number
        
        if ($category === 'DRIVE') {
            if (count($parts) >= 4) {
                $capacity = array_pop($parts);
                $sn = array_pop($parts);
                $type = array_pop($parts);
                $merk = implode(' ', $parts);
                $data[] = [
                    'brand' => $merk,
                    'type' => $type,
                    'serial_number' => $sn !== '-' ? $sn : null,
                    'inventory_number' => null,
                    'description' => "Kapasitas: " . $capacity,
                    'condition' => 'Normal',
                    'location' => 'GUDANG IT',
                    'category' => $category
                ];
            }
            continue;
        }
        
        $condition = 'Normal';
        $last = strtoupper(end($parts));
        if (in_array($last, ['RUSAK', 'NORMAL', 'BAIK'])) {
            if ($last === 'BAIK') $condition = 'Normal';
            else $condition = ucfirst(strtolower($last));
            array_pop($parts);
        }
        
        $location = 'GUDANG IT';
        $count = count($parts);
        if ($count >= 2 && strtoupper($parts[$count-2]) === 'GUDANG' && strtoupper($parts[$count-1]) === 'IT') {
            array_pop($parts);
            array_pop($parts);
        }
        
        $inv_no = null;
        foreach ($parts as $idx => $p) {
            if (strpos(strtoupper($p), 'IT.') === 0) {
                $inv_no = $p;
                unset($parts[$idx]);
                break;
            }
        }
        $parts = array_values($parts);
        
        $brand = '-';
        if (!empty($parts)) {
            if (strtoupper($parts[0]) === 'TP' && count($parts) > 1 && strtoupper($parts[1]) === 'LINK') {
                $brand = 'TP-LINK';
                array_shift($parts); array_shift($parts);
            } elseif (strtoupper($parts[0]) === 'WESTERN' && count($parts) > 1 && strtoupper($parts[1]) === 'DIGITAL') {
                $brand = 'Western Digital';
                array_shift($parts); array_shift($parts);
            } elseif (strtoupper($parts[0]) === 'ALLIED' && count($parts) > 1 && strtoupper($parts[1]) === 'TELESIS') {
                $brand = 'ALLIED TELESIS';
                array_shift($parts); array_shift($parts);
            } else {
                $brand = array_shift($parts);
            }
        }
        
        $type = '-';
        if (!empty($parts)) {
            $type = array_shift($parts);
        }
        
        $sn = null;
        foreach ($parts as $idx => $p) {
            if (preg_match('/\d/', $p) && strlen($p) >= 5) {
                $sn = $p;
                unset($parts[$idx]);
                break;
            }
        }
        $parts = array_values($parts);
        
        $description = !empty($parts) ? implode(' ', $parts) : null;
        
        $data[] = [
            'brand' => $brand,
            'type' => $type,
            'serial_number' => $sn !== '-' ? $sn : null,
            'inventory_number' => $inv_no !== '-' ? $inv_no : null,
            'description' => $description,
            'condition' => $condition,
            'location' => $location,
            'category' => $category
        ];
    }
}

file_put_contents('storage/app/parsed_data.json', json_encode($data, JSON_PRETTY_PRINT));
echo "Parsed " . count($data) . " items.\n";
