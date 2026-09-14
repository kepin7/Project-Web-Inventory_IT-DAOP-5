import pdfplumber
import json
import sys

pdf_path = r'C:\Users\Kepin\.gemini\antigravity-ide\brain\e620e16f-cbc5-4d7c-a457-1f6fa882b5d7\.user_uploaded\media_1789041572807.pdf'

all_data = []

try:
    with pdfplumber.open(pdf_path) as pdf:
        for page_num, page in enumerate(pdf.pages):
            tables = page.extract_tables()
            for table in tables:
                for row in table:
                    clean_row = [str(cell).replace('\n', ' ').strip() if cell is not None else '' for cell in row]
                    # Append page_num to the row
                    clean_row.append(page_num)
                    all_data.append(clean_row)
                    
    with open('database/data/extracted_data.json', 'w') as f:
        json.dump(all_data, f, indent=4)
    print("Success")
except Exception as e:
    print(f"Error: {e}")
