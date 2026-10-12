<?php
/**
 * PayFast ITN (Instant Transaction Notification) Handler
 * 
 * This endpoint receives payment notifications from PayFast.
 * DO NOT output anything before processing - PayFast expects clean responses.
 */

// Bootstrap
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/payfast.php';

// Set content type
header('Content-Type: text/plain');

// Get POST data from PayFast
$pfData = $_POST;

// Log the incoming notification
logPayFastTransaction('ITN received', [
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'payment_id' => $pfData['pf_payment_id'] ?? 'none',
    'm_payment_id' => $pfData['m_payment_id'] ?? 'none',
    'payment_status' => $pfData['payment_status'] ?? 'none',
]);

// Validate that we have data
if (empty($pfData)) {
    logPayFastTransaction('ITN validation failed: No POST data received');
    http_response_code(400);
    die('No POST data received');
}

// Verify PayFast signature
$signature = $pfData['signature'] ?? '';
unset($pfData['signature']);

$payfastPassphrase = getSetting('payfast_passphrase');
$calculatedSignature = generatePayFastSignature($pfData, $payfastPassphrase);

if ($signature !== $calculatedSignature) {
    logPayFastTransaction('ITN validation failed: Invalid signature', [
        'received' => $signature,
        'calculated' => $calculatedSignature
    ]);
    http_response_code(403);
    die('Invalid signature');
}

// Get configuration
$isSandbox = getSetting('payfast_sandbox');
$payfastHost = getPayFastHost($isSandbox);

// Build parameter string for validation
$pfParamString = '';
foreach ($pfData as $key => $value) {
    $pfParamString .= $key . '=' . urlencode($value) . '&';
}
$pfParamString = substr($pfParamString, 0, -1);

// Validate with PayFast server
if (!validatePayFastPayment($pfData, $pfParamString, $payfastHost)) {
    logPayFastTransaction('ITN validation failed: PayFast server rejected', ['host' => $payfastHost]);
    http_response_code(403);
    die('Payment validation failed');
}

// Verify the payment status
$paymentStatus = $pfData['payment_status'] ?? '';
$pfPaymentId = $pfData['pf_payment_id'] ?? '';
$orderNumber = $pfData['m_payment_id'] ?? '';
$amountGross = floatval($pfData['amount_gross'] ?? 0);

if (empty($orderNumber)) {
    logPayFastTransaction('ITN validation failed: No order number in m_payment_id');
    http_response_code(400);
    die('No order number');
}

// Get the order
$db = db();
$order = $db->fetchOne(
    "SELECT * FROM orders WHERE order_number = ?",
    [$orderNumber]
);

if (!$order) {
    logPayFastTransaction('ITN validation failed: Order not found', ['order_number' => $orderNumber]);
    http_response_code(404);
    die('Order not found');
}

// Verify the amount matches
$orderTotal = floatval($order['total_amount']);
if (abs($amountGross - $orderTotal) > 0.01) {
    logPayFastTransaction('ITN validation failed: Amount mismatch', [
        'order_number' => $orderNumber,
        'expected' => $orderTotal,
        'received' => $amountGross
    ]);
    http_response_code(400);
    die('Amount mismatch');
}

// Check if already processed (idempotent check)
if ($order['payfast_payment_id'] === $pfPaymentId && $order['payment_status'] === 'COMPLETE') {
    logPayFastTransaction('ITN already processed (idempotent check)', [
        'order_number' => $orderNumber,
        'payment_id' => $pfPaymentId
    ]);
    http_response_code(200);
    die('OK'); // Already processed, but return success
}

// Map PayFast payment_status to our payment_status
$ourPaymentStatus = 'PENDING';
switch ($paymentStatus) {
    case 'COMPLETE':
        $ourPaymentStatus = 'COMPLETE';
        break;
    case 'FAILED':
        $ourPaymentStatus = 'FAILED';
        break;
    case 'CANCELLED':
        $ourPaymentStatus = 'CANCELLED';
        break;
}

// Update order payment status
updateOrderPaymentStatus($order['id'], $ourPaymentStatus, $pfPaymentId, $pfData);

// Log successful processing
logPayFastTransaction('ITN processed successfully', [
    'order_number' => $orderNumber,
    'payment_id' => $pfPaymentId,
    'payment_status' => $ourPaymentStatus,
    'amount' => $amountGross
]);

// Send success response to PayFast
http_response_code(200);
echo 'OK';
exit;
