<?php
/**
 * PayFast Cancel URL Handler
 * 
 * Customer is redirected here if they cancel payment on PayFast.
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

// Update payment status to cancelled if not already updated
if ($order['payment_status'] === 'PENDING' || empty($order['payment_status'])) {
    updateOrderPaymentStatus($order['id'], 'CANCELLED', null);
}

// Log the cancellation
logPayFastTransaction('Customer cancelled PayFast payment', [
    'order_number' => $orderNumber
]);

// Now safe to output HTML
$pageTitle = 'Payment Cancelled';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0; text-align: center;">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="width: 80px; height: 80px; background: #ffc107; border-radius: 50%; margin: 0 auto var(--spacing-md); display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </div>
            
            <h1>Payment Cancelled</h1>
            <p style="font-size: 1.25rem; color: var(--color-text-light); margin: var(--spacing-md) 0;">
                Your payment was cancelled and your order has not been processed.
            </p>
            
            <div class="admin-card" style="text-align: left; margin-top: var(--spacing-lg);">
                <h3>Order Details</h3>
                
                <div style="display: grid; gap: var(--spacing-sm); margin: var(--spacing-md) 0;">
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                        <span style="color: var(--color-text-light);">Order Number:</span>
                        <strong><?= e($order['order_number']) ?></strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                        <span style="color: var(--color-text-light);">Amount:</span>
                        <strong style="font-size: 1.25rem;"><?= formatPrice($order['total_amount']) ?></strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                        <span style="color: var(--color-text-light);">Status:</span>
                        <strong style="color: #ffc107;">Payment Cancelled</strong>
                    </div>
                </div>
            </div>
            
            <div class="admin-card" style="text-align: left; margin-top: var(--spacing-md); background: #fff3cd; border: 2px solid #ffc107;">
                <h3 style="color: #856404;">💡 What happens now?</h3>
                <p style="color: #856404; line-height: 1.6;">
                    Your order <strong><?= e($order['order_number']) ?></strong> has been created but payment was not completed. 
                    You can still complete this order by choosing an alternative payment method.
                </p>
                <p style="color: #856404; line-height: 1.6; margin-top: var(--spacing-sm);">
                    <strong>Option 1:</strong> Contact us to arrange EFT payment<br>
                    <strong>Option 2:</strong> Place a new order and try again
                </p>
                
                <?php if (getSetting('store_email') || getSetting('store_phone')): ?>
                    <div style="margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid #ffc107;">
                        <strong style="color: #856404;">Contact us:</strong><br>
                        <?php if (getSetting('store_email')): ?>
                            <a href="mailto:<?= e(getSetting('store_email')) ?>" style="color: #856404; text-decoration: underline;">
                                <?= e(getSetting('store_email')) ?>
                            </a><br>
                        <?php endif; ?>
                        <?php if (getSetting('store_phone')): ?>
                            <a href="tel:<?= e(getSetting('store_phone')) ?>" style="color: #856404; text-decoration: underline;">
                                <?= e(getSetting('store_phone')) ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: var(--spacing-lg); display: flex; gap: var(--spacing-sm); justify-content: center;">
                <a href="<?= BASE_URL ?>/shop.php" class="btn btn-primary">Continue Shopping</a>
                <a href="<?= BASE_URL ?>/" class="btn btn-outline">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
