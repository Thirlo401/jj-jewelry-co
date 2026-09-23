#!/usr/bin/env python3
"""
BYL Jewellery Import Script

Reads the BYL jewellery CSV, downloads images, and generates SQL import file
with 15% markup on ZAR prices.

Usage: python3 scripts/import-byl-jewellery.py /path/to/byl-jewellery-sample.csv
"""

import csv
import sys
import os
import re
import urllib.request
from datetime import datetime
from pathlib import Path

def slugify(text):
    """Convert text to URL-friendly slug"""
    text = text.lower().strip()
    text = re.sub(r'[^a-z0-9-]', '-', text)
    text = re.sub(r'-+', '-', text)
    return text.strip('-')

def sql_escape(text):
    """Escape text for SQL"""
    if text is None:
        return ''
    return text.replace("'", "''").replace('\\', '\\\\')

def main():
    if len(sys.argv) < 2:
        print("Usage: python3 scripts/import-byl-jewellery.py /path/to/byl-jewellery-sample.csv")
        sys.exit(1)
    
    csv_file = sys.argv[1]
    if not os.path.exists(csv_file):
        print(f"Error: CSV file not found: {csv_file}")
        sys.exit(1)
    
    # Configuration
    markup = 1.15  # 15% markup
    script_dir = Path(__file__).parent
    image_dir = script_dir.parent / 'assets' / 'uploads' / 'products'
    sql_output_file = script_dir.parent / 'sql' / 'import-byl-jewellery.sql'
    price_sheet_file = script_dir / 'byl-jewellery-price-sheet.txt'
    
    # Create image directory if it doesn't exist
    image_dir.mkdir(parents=True, exist_ok=True)
    print(f"Image directory: {image_dir}")
    
    # Category mapping
    category_map = {
        'white-diamond-rings': 'rings',
        'diamond-earrings': 'earrings',
        'diamond-bracelets': 'bracelets',
        'diamond-pendants': 'pendants',
        'diamond-necklaces': 'necklaces',
    }
    
    # Read CSV - handle both standard format and quoted format
    products = []
    price_sheet = []
    
    with open(csv_file, 'r', encoding='utf-8') as f:
        # Read first line to detect format
        first_line = f.readline().strip()
        f.seek(0)
        
        # If the CSV is wrapped in quotes (entire row as one field), parse manually
        if first_line.startswith('"') and ',' in first_line and first_line.count(',') > 5:
            # Manually parse quoted CSV format
            all_lines = f.readlines()
            headers = all_lines[0].strip().strip('"').split(',')
            rows = []
            for line in all_lines[1:]:
                line = line.strip()
                if line and line.startswith('"'):
                    # Remove outer quotes and split
                    line = line.strip('"')
                    fields = line.split(',')
                    if len(fields) == len(headers):
                        rows.append(dict(zip(headers, fields)))
        else:
            # Standard CSV format
            reader = csv.DictReader(f)
            rows = list(reader)
    
    print(f"Processing {len(rows)} products from CSV...\n")
    
    for index, row in enumerate(rows):
        # Map category
        collection_handle = row.get('collectionHandle', '')
        category = category_map.get(collection_handle)
        
        if not category:
            print(f"Warning: Unknown collection handle '{collection_handle}', skipping row {index + 2}")
            continue
        
        # Calculate retail price (15% markup)
        wholesale_price = float(row.get('price', 0))
        retail_price = round(wholesale_price * markup, 2)
        
        # Generate SKU
        original_sku = row.get('sku', '')
        sku = f'BYL-JW-{original_sku}'
        
        # Generate slug
        title = row.get('title', '')
        slug = slugify(title) + '-' + original_sku.lower()
        
        # Build name with metal variant
        variant_title = row.get('variantTitle', '')
        name = title
        if variant_title and variant_title.lower() not in name.lower():
            name += f' - {variant_title}'
        
        # Build description
        product_type = row.get('productType', '')
        description = product_type
        if variant_title:
            description += f' in {variant_title}'
        description += '. SS Jewellery reseller stock from BYL Diamonds collection.'
        
        # Download image
        image_url = row.get('imageUrl', '')
        image_name = None
        
        if image_url:
            # Get file extension
            image_ext = os.path.splitext(urllib.parse.urlparse(image_url).path)[1]
            if not image_ext:
                image_ext = '.jpg'
            
            image_name = f'byl_{original_sku}_{index}{image_ext}'
            image_path = image_dir / image_name
            
            print(f"Downloading image for {sku}... ", end='', flush=True)
            try:
                urllib.request.urlretrieve(image_url, image_path)
                print("✓")
            except Exception as e:
                print(f"✗ (failed: {e})")
                image_name = None
        
        # Store product data
        product = {
            'sku': sku,
            'name': name,
            'slug': slug,
            'category': category,
            'description': description,
            'wholesale_price': wholesale_price,
            'retail_price': retail_price,
            'image': image_name,
            'product_url': row.get('productUrl', '')
        }
        
        products.append(product)
        
        # Add to price sheet
        price_sheet.append(
            f"{sku:15s} | {name[:50]:50s} | R {wholesale_price:10,.2f} | R {retail_price:10,.2f} | {category.capitalize()}"
        )
    
    print("\nGenerating SQL import file...")
    
    # Generate SQL
    sql_header = f"""-- BYL Jewellery Import
-- Generated: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}
-- Total Products: {len(products)}
-- Pricing: BYL wholesale + 15% markup (ZAR)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Import BYL Jewellery products
-- Uses INSERT ... ON DUPLICATE KEY UPDATE to handle re-imports safely

"""
    
    sql_statements = [sql_header]
    
    for product in products:
        image_value = f"'{sql_escape(product['image'])}'" if product['image'] else 'NULL'
        
        sql = f"""INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('{sql_escape(product['sku'])}', '{sql_escape(product['name'])}', '{sql_escape(product['slug'])}', '{product['category']}', '{sql_escape(product['description'])}', {product['retail_price']:.2f}, {image_value}, 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

"""
        sql_statements.append(sql)
    
    sql_statements.append("COMMIT;\n")
    sql_statements.append("-- Import completed. Check the price sheet for reference.\n")
    
    # Write SQL file
    with open(sql_output_file, 'w', encoding='utf-8') as f:
        f.write(''.join(sql_statements))
    print(f"SQL file created: {sql_output_file}")
    
    # Write price sheet
    price_sheet_header = f"""BYL JEWELLERY PRICE SHEET
SS Jewellery (ssjewellery.store)
Generated: {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}
Total Products: {len(products)}

Pricing: BYL Wholesale + 15% Markup (ZAR)
All prices are in South African Rand (ZAR)

================================================================================
SKU             | Product Name                                       | Wholesale  | Retail     | Category
================================================================================

"""
    
    price_sheet_content = price_sheet_header + '\n'.join(price_sheet) + '\n\n'
    
    # Add summary by category
    price_sheet_content += "================================================================================\n"
    price_sheet_content += "SUMMARY BY CATEGORY\n"
    price_sheet_content += "================================================================================\n\n"
    
    category_stats = {}
    for product in products:
        cat = product['category']
        if cat not in category_stats:
            category_stats[cat] = {'count': 0, 'total': 0}
        category_stats[cat]['count'] += 1
        category_stats[cat]['total'] += product['retail_price']
    
    for cat, stats in category_stats.items():
        price_sheet_content += f"{cat.capitalize():15s}: {stats['count']:2d} products | Total Retail Value: R {stats['total']:,.2f}\n"
    
    with open(price_sheet_file, 'w', encoding='utf-8') as f:
        f.write(price_sheet_content)
    print(f"Price sheet created: {price_sheet_file}")
    
    print("\n✓ Import completed successfully!")
    print("\nNext steps:")
    print(f"1. Review the price sheet: {price_sheet_file}")
    print(f"2. Upload images from: {image_dir}")
    print(f"3. Import SQL on cPanel: {sql_output_file}")
    print("4. Verify products in admin panel")

if __name__ == '__main__':
    main()
