<?php
/**
 * PayFast Return URL Handler
 * 
 * Customer is redirected here after completing payment on PayFast.
 */

// Bootstrap
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/payfast.php';

// Get order number
$orderNumber = $_GET['order'] ?? '';

if (empty($orderNumber)) {
    redirect(BASE_URL . '/');
}

// Get order details
$order = db()->fetchOne(
    "SELECT * FROM orders WHERE order_number = ?",
    [$orderNumber]
);

if (!$order) {
    redirect(BASE_URL . '/');
}

// Log the return
logPayFastTransaction('Customer returned from PayFast', [
    'order_number' => $orderNumber,
    'payment_status' => $order['payment_status']
]);

// Redirect to thank you page
redirect(BASE_URL . '/thank-you.php?order=' . $orderNumber);
