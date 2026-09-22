<?php
// Bootstrap - load essentials before any output
require_once __DIR__ . '/includes/bootstrap.php';

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

// Get order items
$orderItems = db()->fetchAll(
    "SELECT * FROM order_items WHERE order_id = ?",
    [$order['id']]
);

// Get bank details from settings
$bankName = getSetting('bank_name');
$accountHolder = getSetting('bank_account_holder');
$accountNumber = getSetting('bank_account_number');
$branchCode = getSetting('bank_branch_code');
$accountType = getSetting('bank_account_type');

// Check if bank details are configured
$bankDetailsConfigured = !empty($bankName) && !empty($accountHolder) && 
                         !empty($accountNumber) && !empty($branchCode);

// Create a human-readable product summary for payment reference
$productSummary = [];
foreach ($orderItems as $item) {
    $qty = $item['quantity'] > 1 ? ' (x' . $item['quantity'] . ')' : '';
    $productSummary[] = $item['product_name'] . $qty;
}
$paymentForText = implode(', ', $productSummary);

// Now safe to output HTML
$pageTitle = 'Thank You';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0; text-align: center;">
        <div style="max-width: 600px; margin: 0 auto;">
            <div style="width: 80px; height: 80px; background: var(--color-success); border-radius: 50%; margin: 0 auto var(--spacing-md); display: flex; align-items: center; justify-content: center;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            
            <h1>Thank You for Your Order!</h1>
            <p style="font-size: 1.25rem; color: var(--color-text-light); margin: var(--spacing-md) 0;">
                Your order has been successfully placed.
            </p>
            
            <div class="admin-card" style="text-align: left; margin-top: var(--spacing-lg);">
                <h3>Order Details</h3>
                
                <div style="display: grid; gap: var(--spacing-sm); margin: var(--spacing-md) 0;">
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                        <span style="color: var(--color-text-light);">Order Number:</span>
                        <strong><?= e($order['order_number']) ?></strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                        <span style="color: var(--color-text-light);">Order Date:</span>
                        <strong><?= date('F j, Y', strtotime($order['created_at'])) ?></strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                        <span style="color: var(--color-text-light);">Total Amount:</span>
                        <strong style="color: var(--color-accent); font-size: 1.25rem;"><?= formatPrice($order['total_amount']) ?></strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                        <span style="color: var(--color-text-light);">Payment Method:</span>
                        <strong><?= strtoupper($order['payment_method']) ?></strong>
                    </div>
                </div>
            </div>
            
            <div class="admin-card" style="text-align: left; margin-top: var(--spacing-md);">
                <h3>Items Ordered</h3>
                
                <div style="margin: var(--spacing-md) 0;">
                    <?php foreach ($orderItems as $item): ?>
                        <div style="display: flex; justify-content: space-between; align-items: start; padding: 0.75rem 0; border-bottom: 1px solid var(--color-border);">
                            <div style="flex: 1;">
                                <strong style="color: var(--color-text); display: block; margin-bottom: 0.25rem;"><?= e($item['product_name']) ?></strong>
                                <div style="display: flex; gap: 1rem; font-size: 0.9rem; color: var(--color-text-light);">
                                    <span>SKU: <?= e($item['product_sku']) ?></span>
                                    <span>Qty: <?= $item['quantity'] ?></span>
                                    <span><?= formatPrice($item['price']) ?> each</span>
                                </div>
                            </div>
                            <div style="font-weight: 600; color: var(--color-text);">
                                <?= formatPrice($item['subtotal']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div style="padding: var(--spacing-sm); background: var(--color-bg-light); border-radius: var(--border-radius); margin-top: var(--spacing-sm);">
                    <strong>Paying for:</strong> <?= e($paymentForText) ?>
                </div>
            </div>
            
            <?php if ($order['payment_method'] === 'eft'): ?>
                <?php if ($bankDetailsConfigured): ?>
                    <div class="admin-card" style="text-align: left; margin-top: var(--spacing-md); background: linear-gradient(135deg, #f8f4f0 0%, #fefefe 100%); border: 2px solid var(--color-accent);">
                        <h3 style="color: var(--color-accent);">💳 Payment Instructions</h3>
                        <p style="color: var(--color-text); margin-bottom: var(--spacing-md); font-weight: 500;">
                            Please transfer <strong style="color: var(--color-accent); font-size: 1.15rem;"><?= formatPrice($order['total_amount']) ?></strong> to the following bank account:
                        </p>
                        
                        <div style="display: grid; gap: var(--spacing-sm); background: white; padding: var(--spacing-md); border-radius: var(--border-radius); margin-bottom: var(--spacing-md);">
                            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                                <strong>Bank:</strong> 
                                <span><?= e($bankName) ?></span>
                            </div>
                            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                                <strong>Account Holder:</strong> 
                                <span><?= e($accountHolder) ?></span>
                            </div>
                            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                                <strong>Account Number:</strong> 
                                <span style="font-family: monospace; font-size: 1.1rem; color: var(--color-accent);"><?= e($accountNumber) ?></span>
                            </div>
                            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                                <strong>Branch Code:</strong> 
                                <span style="font-family: monospace; font-size: 1.1rem;"><?= e($branchCode) ?></span>
                            </div>
                            <div style="display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem; padding: 0.5rem 0;">
                                <strong>Account Type:</strong> 
                                <span><?= e($accountType) ?></span>
                            </div>
                        </div>
                        
                        <div style="background: white; padding: var(--spacing-md); border-left: 4px solid var(--color-accent); border-radius: var(--border-radius);">
                            <div style="margin-bottom: 0.5rem;">
                                <strong style="font-size: 1.05rem; color: var(--color-text);">Payment Reference:</strong>
                            </div>
                            <div style="font-size: 1.25rem; font-weight: 700; color: var(--color-accent); font-family: monospace; margin-bottom: 0.75rem;">
                                <?= e($order['order_number']) ?>
                            </div>
                            <div style="font-size: 0.95rem; color: var(--color-text-light); line-height: 1.6;">
                                <strong style="color: var(--color-text);">Important:</strong> Please use your order number <strong><?= e($order['order_number']) ?></strong> as your payment reference. This ensures we can match your payment to your order quickly.
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="admin-card" style="text-align: left; margin-top: var(--spacing-md); background: #fff3cd; border: 2px solid #ffc107;">
                        <h3 style="color: #856404;">⚠️ Payment Details Required</h3>
                        <p style="color: #856404; margin-bottom: var(--spacing-md); font-weight: 500;">
                            Our bank account details are being updated. Please contact us directly to complete your payment.
                        </p>
                        
                        <div style="background: white; padding: var(--spacing-md); border-radius: var(--border-radius);">
                            <div style="margin-bottom: var(--spacing-sm);">
                                <strong>Your Order Number:</strong> <span style="font-family: monospace; font-size: 1.1rem; color: var(--color-accent);"><?= e($order['order_number']) ?></span>
                            </div>
                            <div style="margin-bottom: var(--spacing-sm);">
                                <strong>Amount Due:</strong> <span style="font-size: 1.15rem; color: var(--color-accent);"><?= formatPrice($order['total_amount']) ?></span>
                            </div>
                            <div style="margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--color-border);">
                                <strong>Please contact us:</strong><br>
                                <?php if (getSetting('store_email')): ?>
                                    Email: <a href="mailto:<?= e(getSetting('store_email')) ?>" style="color: var(--color-accent);"><?= e(getSetting('store_email')) ?></a><br>
                                <?php endif; ?>
                                <?php if (getSetting('store_phone')): ?>
                                    Phone: <a href="tel:<?= e(getSetting('store_phone')) ?>" style="color: var(--color-accent);"><?= e(getSetting('store_phone')) ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <div style="margin-top: var(--spacing-lg); padding: var(--spacing-md); background: var(--color-bg-light); border-radius: var(--border-radius);">
                <p style="color: var(--color-text-light); font-size: 0.95rem;">
                    A confirmation email has been sent to <strong><?= e($order['customer_email']) ?></strong>.
                    We will notify you once your payment is received and your order is being processed.
                </p>
            </div>
            
            <div style="margin-top: var(--spacing-lg); display: flex; gap: var(--spacing-sm); justify-content: center;">
                <a href="<?= BASE_URL ?>/" class="btn btn-primary">Back to Home</a>
                <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
