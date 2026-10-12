<?php
/**
 * PayFast Integration Helper Functions
 * 
 * PayFast API Documentation: https://developers.payfast.co.za/
 */

/**
 * Generate PayFast payment signature
 * 
 * @param array $data Payment data array
 * @param string $passphrase Optional passphrase
 * @return string MD5 signature
 */
function generatePayFastSignature($data, $passphrase = '') {
    // Sort the array by key, alphabetically
    ksort($data);
    
    // Create parameter string
    $pfOutput = '';
    foreach ($data as $key => $val) {
        if ($val !== '') {
            $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    
    // Remove last ampersand
    $pfOutput = substr($pfOutput, 0, -1);
    
    // Append passphrase if set
    if (!empty($passphrase)) {
        $pfOutput .= '&passphrase=' . urlencode(trim($passphrase));
    }
    
    return md5($pfOutput);
}

/**
 * Validate PayFast payment data
 * 
 * @param array $pfData POST data from PayFast
 * @param string $pfParamString URL encoded parameter string
 * @param string $pfHost PayFast host to validate against
 * @return bool True if valid
 */
function validatePayFastPayment($pfData, $pfParamString, $pfHost = 'www.payfast.co.za') {
    // Variable initialization
    $url = 'https://' . $pfHost . '/eng/query/validate';
    
    // Use cURL to post the data
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pfParamString);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return ($response === 'VALID');
}

/**
 * Build PayFast payment data array
 * 
 * @param array $order Order details
 * @param array $config PayFast configuration
 * @return array Payment data ready for PayFast
 */
function buildPayFastData($order, $config) {
    $data = [
        // Merchant details
        'merchant_id' => $config['merchant_id'],
        'merchant_key' => $config['merchant_key'],
        
        // Buyer details
        'name_first' => getFirstName($order['customer_name']),
        'name_last' => getLastName($order['customer_name']),
        'email_address' => $order['customer_email'],
        'cell_number' => formatPhoneNumber($order['customer_phone']),
        
        // Transaction details
        'm_payment_id' => $order['order_number'],
        'amount' => number_format($order['total_amount'], 2, '.', ''),
        'item_name' => 'Order ' . $order['order_number'] . ' - SS Jewellery',
        'item_description' => getOrderDescription($order['id']),
        
        // URLs
        'return_url' => $config['return_url'],
        'cancel_url' => $config['cancel_url'],
        'notify_url' => $config['notify_url'],
        
        // Email confirmation
        'email_confirmation' => 1,
        'confirmation_address' => $order['customer_email'],
    ];
    
    // Generate signature
    $data['signature'] = generatePayFastSignature($data, $config['passphrase'] ?? '');
    
    return $data;
}

/**
 * Get PayFast payment URL
 * 
 * @param bool $sandbox Use sandbox environment
 * @return string PayFast payment URL
 */
function getPayFastUrl($sandbox = false) {
    return $sandbox 
        ? 'https://sandbox.payfast.co.za/eng/process'
        : 'https://www.payfast.co.za/eng/process';
}

/**
 * Get PayFast host for validation
 * 
 * @param bool $sandbox Use sandbox environment
 * @return string PayFast host
 */
function getPayFastHost($sandbox = false) {
    return $sandbox ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
}

/**
 * Extract first name from full name
 */
function getFirstName($fullName) {
    $parts = explode(' ', trim($fullName), 2);
    return $parts[0];
}

/**
 * Extract last name from full name
 */
function getLastName($fullName) {
    $parts = explode(' ', trim($fullName), 2);
    return isset($parts[1]) ? $parts[1] : '';
}

/**
 * Format phone number for PayFast (remove spaces and special chars)
 */
function formatPhoneNumber($phone) {
    // Remove all non-numeric characters
    return preg_replace('/[^0-9]/', '', $phone);
}

/**
 * Get order description from order items
 */
function getOrderDescription($orderId) {
    $db = db();
    $items = $db->fetchAll(
        "SELECT product_name, quantity FROM order_items WHERE order_id = ? LIMIT 3",
        [$orderId]
    );
    
    $description = [];
    foreach ($items as $item) {
        $qty = $item['quantity'] > 1 ? ' (x' . $item['quantity'] . ')' : '';
        $description[] = $item['product_name'] . $qty;
    }
    
    $desc = implode(', ', $description);
    
    // Get total item count
    $totalItems = $db->fetchOne(
        "SELECT COUNT(*) as count FROM order_items WHERE order_id = ?",
        [$orderId]
    )['count'];
    
    if ($totalItems > 3) {
        $desc .= ' and ' . ($totalItems - 3) . ' more item(s)';
    }
    
    // Truncate to 255 chars (PayFast limit)
    return substr($desc, 0, 255);
}

/**
 * Update order payment status
 * 
 * @param int $orderId Order ID
 * @param string $paymentStatus Payment status
 * @param string $payfastPaymentId PayFast payment ID
 * @param array $payfastData PayFast transaction data
 */
function updateOrderPaymentStatus($orderId, $paymentStatus, $payfastPaymentId, $payfastData = []) {
    $db = db();
    
    $jsonData = !empty($payfastData) ? json_encode($payfastData) : null;
    
    $db->query(
        "UPDATE orders 
         SET payment_status = ?, 
             payfast_payment_id = ?, 
             payfast_data = ?,
             status = CASE 
                 WHEN ? = 'COMPLETE' THEN 'paid'
                 WHEN ? = 'CANCELLED' THEN 'cancelled'
                 ELSE status
             END
         WHERE id = ?",
        [$paymentStatus, $payfastPaymentId, $jsonData, $paymentStatus, $paymentStatus, $orderId]
    );
}

/**
 * Check if IP address is from PayFast
 * 
 * @param string $ipAddress IP address to check
 * @return bool True if valid PayFast IP
 */
function isPayFastIP($ipAddress) {
    // PayFast IP addresses (as of their documentation)
    $validIPs = [
        '197.97.145.144',
        '41.74.179.194',
        '41.74.179.195',
        '41.74.179.196',
        '41.74.179.197',
        '41.74.179.210',
        '197.97.145.145',
    ];
    
    // For sandbox testing, also allow local IPs
    if (getSetting('payfast_sandbox')) {
        $validIPs[] = '127.0.0.1';
        $validIPs[] = '::1';
    }
    
    return in_array($ipAddress, $validIPs);
}

/**
 * Log PayFast transaction for debugging
 * 
 * @param string $message Log message
 * @param array $data Additional data to log
 */
function logPayFastTransaction($message, $data = []) {
    $logFile = __DIR__ . '/../logs/payfast.log';
    $logDir = dirname($logFile);
    
    // Create logs directory if it doesn't exist
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}";
    
    if (!empty($data)) {
        $logEntry .= " | Data: " . json_encode($data);
    }
    
    $logEntry .= PHP_EOL;
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}
