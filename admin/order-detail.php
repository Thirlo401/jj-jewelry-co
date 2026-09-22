<?php
$pageTitle = 'Order Details';
require_once __DIR__ . '/header.php';

// Get order ID
$orderId = $_GET['id'] ?? null;

if (!$orderId) {
    redirect(BASE_URL . '/admin/orders.php');
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $newStatus = $_POST['status'];
        $adminNotes = trim($_POST['admin_notes'] ?? '');
        
        db()->query(
            "UPDATE orders SET status = ?, admin_notes = ? WHERE id = ?",
            [$newStatus, $adminNotes, $orderId]
        );
        
        setFlashMessage('success', 'Order status updated successfully');
        redirect(BASE_URL . '/admin/order-detail.php?id=' . $orderId);
    }
}

// Get order details
$order = db()->fetchOne("SELECT * FROM orders WHERE id = ?", [(int)$orderId]);

if (!$order) {
    redirect(BASE_URL . '/admin/orders.php');
}

// Get order items
$orderItems = db()->fetchAll("SELECT * FROM order_items WHERE order_id = ?", [$orderId]);

// Create product summary for payment reference
$productNames = array_map(function($item) {
    return $item['product_name'];
}, $orderItems);
$paymentForText = implode(', ', $productNames);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
    <h1>Order #<?= e($order['order_number']) ?></h1>
    <a href="<?= BASE_URL ?>/admin/orders.php" class="btn btn-outline">Back to Orders</a>
</div>

<?php if ($message = getFlashMessage('success')): ?>
    <div class="alert alert-success"><?= e($message) ?></div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--spacing-md);">
    <div>
        <div class="admin-card">
            <h3>Order Items</h3>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderItems as $item): ?>
                        <tr>
                            <td><strong><?= e($item['product_name']) ?></strong></td>
                            <td><?= e($item['product_sku']) ?></td>
                            <td><?= formatPrice($item['price']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= formatPrice($item['subtotal']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight: 600; font-size: 1.125rem;">
                        <td colspan="4" style="text-align: right;">Total:</td>
                        <td><?= formatPrice($order['total_amount']) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="admin-card">
            <h3>Customer Information</h3>
            
            <div style="display: grid; gap: var(--spacing-sm);">
                <div>
                    <strong>Name:</strong> <?= e($order['customer_name']) ?>
                </div>
                <div>
                    <strong>Email:</strong> <a href="mailto:<?= e($order['customer_email']) ?>"><?= e($order['customer_email']) ?></a>
                </div>
                <div>
                    <strong>Phone:</strong> <a href="tel:<?= e($order['customer_phone']) ?>"><?= e($order['customer_phone']) ?></a>
                </div>
            </div>
        </div>
        
        <div class="admin-card">
            <h3>Shipping Address</h3>
            
            <div style="line-height: 1.8;">
                <?= nl2br(e($order['shipping_address'])) ?><br>
                <?= e($order['city']) ?>, <?= e($order['postal_code']) ?><br>
                <?= e($order['province']) ?>
            </div>
        </div>
        
        <?php if ($order['customer_notes']): ?>
            <div class="admin-card">
                <h3>Customer Notes</h3>
                <p style="color: var(--color-text-light);"><?= nl2br(e($order['customer_notes'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
    
    <div>
        <div class="admin-card">
            <h3>Order Status</h3>
            
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Admin Notes</label>
                    <textarea name="admin_notes" class="form-textarea" placeholder="Internal notes about this order..."><?= e($order['admin_notes']) ?></textarea>
                </div>
                
                <button type="submit" name="update_status" class="btn btn-primary" style="width: 100%;">
                    Update Status
                </button>
            </form>
        </div>
        
        <div class="admin-card">
            <h3>Order Information</h3>
            
            <div style="display: grid; gap: var(--spacing-sm); font-size: 0.95rem;">
                <div>
                    <strong>Order Date:</strong><br>
                    <?= date('F j, Y g:i A', strtotime($order['created_at'])) ?>
                </div>
                <div>
                    <strong>Last Updated:</strong><br>
                    <?= date('F j, Y g:i A', strtotime($order['updated_at'])) ?>
                </div>
                <div>
                    <strong>Payment Method:</strong><br>
                    <?= strtoupper($order['payment_method']) ?>
                </div>
            </div>
        </div>
        
        <?php if ($order['payment_method'] === 'eft'): ?>
            <div class="admin-card" style="background: var(--color-bg-light);">
                <h3>EFT Payment Reference</h3>
                
                <div style="padding: var(--spacing-sm); background: white; border-left: 3px solid var(--color-accent); border-radius: 4px; margin-bottom: var(--spacing-sm);">
                    <div style="font-size: 0.85rem; color: var(--color-text-light); margin-bottom: 0.25rem;">
                        <strong>Payment Reference:</strong>
                    </div>
                    <div style="font-size: 1.1rem; font-weight: 700; color: var(--color-accent); font-family: monospace;">
                        <?= e($order['order_number']) ?>
                    </div>
                </div>
                
                <div style="font-size: 0.9rem; color: var(--color-text-light); line-height: 1.6;">
                    <div style="margin-bottom: 0.5rem;">
                        <strong style="color: var(--color-text);">Amount Due:</strong> 
                        <span style="color: var(--color-accent); font-weight: 600;"><?= formatPrice($order['total_amount']) ?></span>
                    </div>
                    <div style="margin-bottom: 0.5rem;">
                        <strong style="color: var(--color-text);">Paying for:</strong><br>
                        <?= e($paymentForText) ?>
                    </div>
                    <div style="margin-top: var(--spacing-sm); padding-top: var(--spacing-sm); border-top: 1px solid var(--color-border); font-size: 0.85rem; font-style: italic;">
                        Customer was instructed to use order number as bank transfer reference.
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
