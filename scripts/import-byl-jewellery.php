<?php
/**
 * BYL Jewellery Import Script
 * 
 * Reads the BYL jewellery CSV, downloads images, and generates SQL import file
 * with 15% markup on ZAR prices.
 * 
 * Usage: php scripts/import-byl-jewellery.php /path/to/byl-jewellery-sample.csv
 */

if (php_sapi_name() !== 'cli') {
    die('This script must be run from the command line');
}

if ($argc < 2) {
    echo "Usage: php scripts/import-byl-jewellery.php /path/to/byl-jewellery-sample.csv\n";
    exit(1);
}

$csvFile = $argv[1];
if (!file_exists($csvFile)) {
    echo "Error: CSV file not found: $csvFile\n";
    exit(1);
}

// Configuration
$markup = 1.15; // 15% markup
$imageDir = __DIR__ . '/../assets/uploads/products/';
$sqlOutputFile = __DIR__ . '/../sql/import-byl-jewellery.sql';
$priceSheetFile = __DIR__ . '/../scripts/byl-jewellery-price-sheet.txt';

// Create image directory if it doesn't exist
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
    echo "Created directory: $imageDir\n";
}

// Category mapping
$categoryMap = [
    'white-diamond-rings' => 'rings',
    'diamond-earrings' => 'earrings',
    'diamond-bracelets' => 'bracelets',
    'diamond-pendants' => 'pendants',
    'diamond-necklaces' => 'necklaces',
];

// Read CSV
$csv = array_map('str_getcsv', file($csvFile));
$headers = array_shift($csv);

$products = [];
$priceSheet = [];
$sqlStatements = [];

echo "Processing " . count($csv) . " products from CSV...\n\n";

foreach ($csv as $index => $row) {
    if (count($row) < count($headers)) {
        continue; // Skip incomplete rows
    }
    
    $data = array_combine($headers, $row);
    
    // Map category
    $collectionHandle = $data['collectionHandle'];
    $category = $categoryMap[$collectionHandle] ?? null;
    
    if (!$category) {
        echo "Warning: Unknown collection handle '$collectionHandle', skipping row " . ($index + 2) . "\n";
        continue;
    }
    
    // Calculate retail price (15% markup)
    $wholesalePrice = floatval($data['price']);
    $retailPrice = round($wholesalePrice * $markup, 2);
    
    // Generate SKU
    $originalSku = $data['sku'];
    $sku = 'BYL-JW-' . $originalSku;
    
    // Generate slug
    $slug = strtolower(trim($data['title']));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
    
    // Build name with metal variant
    $name = $data['title'];
    $variantTitle = $data['variantTitle'];
    if ($variantTitle && stripos($name, $variantTitle) === false) {
        $name .= ' - ' . $variantTitle;
    }
    
    // Build description
    $description = $data['productType'];
    if ($variantTitle) {
        $description .= ' in ' . $variantTitle;
    }
    $description .= '. SS Jewellery reseller stock from BYL Diamonds collection.';
    
    // Download image
    $imageUrl = $data['imageUrl'];
    $imageName = null;
    
    if ($imageUrl) {
        $imageExt = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!$imageExt) {
            $imageExt = 'jpg';
        }
        $imageName = 'byl_' . $originalSku . '_' . uniqid() . '.' . $imageExt;
        $imagePath = $imageDir . $imageName;
        
        echo "Downloading image for $sku... ";
        $imageData = @file_get_contents($imageUrl);
        if ($imageData) {
            file_put_contents($imagePath, $imageData);
            echo "✓\n";
        } else {
            echo "✗ (failed)\n";
            $imageName = null;
        }
    }
    
    // Store product data
    $product = [
        'sku' => $sku,
        'name' => $name,
        'slug' => $slug . '-' . strtolower($originalSku), // Make unique
        'category' => $category,
        'description' => $description,
        'wholesale_price' => $wholesalePrice,
        'retail_price' => $retailPrice,
        'image' => $imageName,
        'product_url' => $data['productUrl']
    ];
    
    $products[] = $product;
    
    // Add to price sheet
    $priceSheet[] = sprintf(
        "%-15s | %-50s | R %10s | R %10s | %s",
        $sku,
        substr($name, 0, 50),
        number_format($wholesalePrice, 2),
        number_format($retailPrice, 2),
        ucfirst($category)
    );
}

echo "\nGenerating SQL import file...\n";

// Generate SQL
$sqlHeader = <<<SQL
-- BYL Jewellery Import
-- Generated: {DATE}
-- Total Products: {COUNT}
-- Pricing: BYL wholesale + 15% markup (ZAR)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Import BYL Jewellery products
-- Uses INSERT ... ON DUPLICATE KEY UPDATE to handle re-imports safely

SQL;

$sqlHeader = str_replace('{DATE}', date('Y-m-d H:i:s'), $sqlHeader);
$sqlHeader = str_replace('{COUNT}', count($products), $sqlHeader);

$sqlStatements[] = $sqlHeader;

foreach ($products as $product) {
    $sql = sprintf(
        "INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES\n" .
        "('%s', '%s', '%s', '%s', '%s', %.2f, %s, 1, 0, 1)\n" .
        "ON DUPLICATE KEY UPDATE\n" .
        "  `name` = VALUES(`name`),\n" .
        "  `description` = VALUES(`description`),\n" .
        "  `price` = VALUES(`price`),\n" .
        "  `category` = VALUES(`category`),\n" .
        "  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);\n",
        addslashes($product['sku']),
        addslashes($product['name']),
        addslashes($product['slug']),
        $product['category'],
        addslashes($product['description']),
        $product['retail_price'],
        $product['image'] ? "'" . addslashes($product['image']) . "'" : 'NULL'
    );
    
    $sqlStatements[] = $sql;
}

$sqlStatements[] = "COMMIT;\n";
$sqlStatements[] = "-- Import completed. Check the price sheet for reference.\n";

// Write SQL file
file_put_contents($sqlOutputFile, implode("\n", $sqlStatements));
echo "SQL file created: $sqlOutputFile\n";

// Write price sheet
$priceSheetHeader = <<<SHEET
BYL JEWELLERY PRICE SHEET
SS Jewellery (ssjewellery.store)
Generated: {DATE}
Total Products: {COUNT}

Pricing: BYL Wholesale + 15% Markup (ZAR)
All prices are in South African Rand (ZAR)

================================================================================
SKU             | Product Name                                       | Wholesale  | Retail     | Category
================================================================================

SHEET;

$priceSheetHeader = str_replace('{DATE}', date('Y-m-d H:i:s'), $priceSheetHeader);
$priceSheetHeader = str_replace('{COUNT}', count($products), $priceSheetHeader);

$priceSheetContent = $priceSheetHeader . implode("\n", $priceSheet) . "\n\n";

// Add summary by category
$priceSheetContent .= "================================================================================\n";
$priceSheetContent .= "SUMMARY BY CATEGORY\n";
$priceSheetContent .= "================================================================================\n\n";

$categoryStats = [];
foreach ($products as $product) {
    if (!isset($categoryStats[$product['category']])) {
        $categoryStats[$product['category']] = ['count' => 0, 'total' => 0];
    }
    $categoryStats[$product['category']]['count']++;
    $categoryStats[$product['category']]['total'] += $product['retail_price'];
}

foreach ($categoryStats as $cat => $stats) {
    $priceSheetContent .= sprintf(
        "%-15s: %2d products | Total Retail Value: R %s\n",
        ucfirst($cat),
        $stats['count'],
        number_format($stats['total'], 2)
    );
}

file_put_contents($priceSheetFile, $priceSheetContent);
echo "Price sheet created: $priceSheetFile\n";

echo "\n✓ Import completed successfully!\n";
echo "\nNext steps:\n";
echo "1. Review the price sheet: $priceSheetFile\n";
echo "2. Upload images from: $imageDir\n";
echo "3. Import SQL on cPanel: $sqlOutputFile\n";
echo "4. Verify products in admin panel\n";
