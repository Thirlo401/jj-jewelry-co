<?php
$pageTitle = 'Thank You';
require_once __DIR__ . '/includes/header.php';

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

// Get bank details from settings
$bankName = getSetting('bank_name');
$accountHolder = getSetting('bank_account_holder');
$accountNumber = getSetting('bank_account_number');
$branchCode = getSetting('bank_branch_code');
$accountType = getSetting('bank_account_type');
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
            
            <?php if ($order['payment_method'] === 'eft'): ?>
                <div class="admin-card" style="text-align: left; margin-top: var(--spacing-md); background: var(--color-bg-light);">
                    <h3>Payment Instructions</h3>
                    <p style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
                        Please make your payment using the following bank details:
                    </p>
                    
                    <div style="display: grid; gap: var(--spacing-sm);">
                        <div>
                            <strong>Bank:</strong> <?= e($bankName) ?>
                        </div>
                        <div>
                            <strong>Account Holder:</strong> <?= e($accountHolder) ?>
                        </div>
                        <div>
                            <strong>Account Number:</strong> <?= e($accountNumber) ?>
                        </div>
                        <div>
                            <strong>Branch Code:</strong> <?= e($branchCode) ?>
                        </div>
                        <div>
                            <strong>Account Type:</strong> <?= e($accountType) ?>
                        </div>
                        <div style="margin-top: var(--spacing-sm); padding: var(--spacing-sm); background: white; border-left: 3px solid var(--color-accent);">
                            <strong>Payment Reference:</strong> <?= e($order['order_number']) ?><br>
                            <small style="color: var(--color-text-light);">Please use your order number as the payment reference</small>
                        </div>
                    </div>
                </div>
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
