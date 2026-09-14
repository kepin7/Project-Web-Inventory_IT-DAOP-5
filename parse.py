import sys
import json
import re

def main():
    with open('storage/app/raw_data.txt', 'r', encoding='utf-8') as f:
        content = f.read()

    blocks = content.split('---')
    
    categories = ['CPU', 'MONITOR', 'PRINTER', 'SWITCH', 'UPS', 'AIO', 'DRIVE']
    
    data = []

    for i, block in enumerate(blocks):
        lines = [line.strip() for line in block.strip().split('\n') if line.strip()]
        if not lines:
            continue
            
        category = categories[i] if i < len(categories) else 'OTHER'
        
        # skip header
        if lines[0].startswith('NO'):
            lines = lines[1:]
            
        for line in lines:
            if category == 'DRIVE':
                # No Merk Type SN Kapasitas
                parts = line.split()
                if len(parts) >= 5:
                    capacity = parts[-1]
                    sn = parts[-2]
                    type_ = parts[-3]
                    merk = " ".join(parts[1:-3])
                    data.append({
                        'brand': merk,
                        'type': type_,
                        'serial_number': sn if sn != '-' else None,
                        'inventory_number': None,
                        'description': f"Kapasitas: {capacity}",
                        'condition': 'Normal',
                        'location': 'GUDANG IT',
                        'category': category
                    })
                continue

            # Default logic for other categories
            parts = line.split()
            if not parts[0].isdigit():
                continue # skip if doesn't start with number
                
            parts = parts[1:] # remove number
            
            # extract condition from the end
            condition = 'Normal'
            last = parts[-1].upper()
            if last in ['RUSAK', 'NORMAL', 'BAIK']:
                if last == 'BAIK':
                    condition = 'Normal'
                else:
                    condition = last.capitalize()
                parts.pop()
                
            # extract location
            location = 'GUDANG IT'
            if len(parts) >= 2 and parts[-2].upper() == 'GUDANG' and parts[-1].upper() == 'IT':
                location = 'GUDANG IT'
                parts.pop()
                parts.pop()

            # extract inventory number
            inv_no = None
            for idx, p in enumerate(parts):
                if p.upper().startswith('IT.'):
                    inv_no = p
                    parts.pop(idx)
                    break
                    
            # determine brand (handle 'TP LINK', 'Western Digital')
            brand = '-'
            if len(parts) > 0:
                if parts[0].upper() == 'TP' and len(parts) > 1 and parts[1].upper() == 'LINK':
                    brand = 'TP-LINK'
                    parts = parts[2:]
                elif parts[0].upper() == 'WESTERN' and len(parts) > 1 and parts[1].upper() == 'DIGITAL':
                    brand = 'Western Digital'
                    parts = parts[2:]
                elif parts[0].upper() == 'ALLIED' and len(parts) > 1 and parts[1].upper() == 'TELESIS':
                    brand = 'ALLIED TELESIS'
                    parts = parts[2:]
                else:
                    brand = parts[0]
                    parts = parts[1:]
                    
            type_ = '-'
            if len(parts) > 0:
                type_ = parts.pop(0)
                
            # try to get SN
            sn = None
            for idx, p in enumerate(parts):
                # SN usually is long and has numbers
                if any(c.isdigit() for c in p) and len(p) >= 5:
                    sn = p
                    parts.pop(idx)
                    break
                    
            description = " ".join(parts) if parts else None
            
            data.append({
                'brand': brand,
                'type': type_,
                'serial_number': sn if sn != '-' else None,
                'inventory_number': inv_no if inv_no != '-' else None,
                'description': description,
                'condition': condition,
                'location': location,
                'category': category
            })
            
    with open('storage/app/parsed_data.json', 'w', encoding='utf-8') as f:
        json.dump(data, f, indent=4)

if __name__ == '__main__':
    main()
