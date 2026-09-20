<?php
/**
 * Helper Functions
 */

/**
 * Escape HTML output
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Format price in ZAR
 */
function formatPrice($amount) {
    return 'R ' . number_format($amount, 2);
}

/**
 * Generate slug from string
 */
function generateSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Generate unique order number
 */
function generateOrderNumber() {
    return 'JJ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
}

/**
 * Upload product image
 */
function uploadProductImage($file) {
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'error' => 'Invalid file upload'];
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload failed'];
    }
    
    // Check file size
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'error' => 'File too large (max 5MB)'];
    }
    
    // Get file extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Check allowed extensions
    if (!in_array($extension, ALLOWED_EXTENSIONS)) {
        return ['success' => false, 'error' => 'Invalid file type. Allowed: JPG, PNG, WEBP'];
    }
    
    // Verify it's an actual image
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
    
    if (!in_array($mimeType, $allowedMimes)) {
        return ['success' => false, 'error' => 'File is not a valid image'];
    }
    
    // Generate unique filename
    $filename = uniqid('prod_', true) . '.' . $extension;
    $destination = UPLOAD_DIR . $filename;
    
    // Create upload directory if it doesn't exist
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'error' => 'Failed to save file'];
}

/**
 * Delete product image
 */
function deleteProductImage($filename) {
    if (empty($filename)) {
        return;
    }
    
    $filepath = UPLOAD_DIR . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

/**
 * Get category display name
 */
function getCategoryName($category) {
    $categories = [
        'rough_diamonds' => 'Rough Diamonds',
        'polished_diamonds' => 'Polished Diamonds',
        'jewelry' => 'Jewelry'
    ];
    
    return $categories[$category] ?? $category;
}

/**
 * Get order status badge class
 */
function getStatusBadgeClass($status) {
    $classes = [
        'pending' => 'badge-warning',
        'paid' => 'badge-info',
        'processing' => 'badge-primary',
        'shipped' => 'badge-success',
        'cancelled' => 'badge-danger'
    ];
    
    return $classes[$status] ?? 'badge-secondary';
}

/**
 * Get site settings
 */
function getSetting($key, $default = '') {
    static $settings = null;
    
    if ($settings === null) {
        $db = db();
        $rows = $db->fetchAll("SELECT setting_key, setting_value FROM settings");
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    
    return $settings[$key] ?? $default;
}

/**
 * Update site setting
 */
function updateSetting($key, $value) {
    $db = db();
    $db->query(
        "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
         ON DUPLICATE KEY UPDATE setting_value = ?",
        [$key, $value, $value]
    );
}

/**
 * Truncate text
 */
function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

/**
 * Calculate cart total
 */
function calculateCartTotal($cartItems) {
    $total = 0;
    
    if (empty($cartItems)) {
        return $total;
    }
    
    $productIds = array_keys($cartItems);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    
    $db = db();
    $products = $db->fetchAll(
        "SELECT id, price FROM products WHERE id IN ($placeholders) AND is_active = 1",
        $productIds
    );
    
    foreach ($products as $product) {
        $quantity = $cartItems[$product['id']];
        $total += $product['price'] * $quantity;
    }
    
    return $total;
}

/**
 * Get cart items with product details
 */
function getCartItemsWithDetails() {
    $cart = getCart();
    
    if (empty($cart)) {
        return [];
    }
    
    $productIds = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));
    
    $db = db();
    $products = $db->fetchAll(
        "SELECT * FROM products WHERE id IN ($placeholders) AND is_active = 1",
        $productIds
    );
    
    $items = [];
    foreach ($products as $product) {
        $product['quantity'] = $cart[$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $items[] = $product;
    }
    
    return $items;
}
