<?php
$pageTitle = 'Orders';
require_once __DIR__ . '/header.php';

// Get filter parameters
$status = $_GET['status'] ?? 'all';

// Build query
$sql = "SELECT * FROM orders";
$params = [];

if ($status !== 'all') {
    $sql .= " WHERE status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$orders = db()->fetchAll($sql, $params);
?>

<h1>Orders</h1>

<div class="shop-header" style="margin-bottom: var(--spacing-md);">
    <div class="filter-group">
        <a href="?status=all" class="filter-btn <?= $status === 'all' ? 'active' : '' ?>">All</a>
        <a href="?status=pending" class="filter-btn <?= $status === 'pending' ? 'active' : '' ?>">Pending</a>
        <a href="?status=paid" class="filter-btn <?= $status === 'paid' ? 'active' : '' ?>">Paid</a>
        <a href="?status=processing" class="filter-btn <?= $status === 'processing' ? 'active' : '' ?>">Processing</a>
        <a href="?status=shipped" class="filter-btn <?= $status === 'shipped' ? 'active' : '' ?>">Shipped</a>
        <a href="?status=cancelled" class="filter-btn <?= $status === 'cancelled' ? 'active' : '' ?>">Cancelled</a>
    </div>
</div>

<div class="admin-card">
    <?php if (!empty($orders)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong><?= e($order['order_number']) ?></strong></td>
                        <td>
                            <?= e($order['customer_name']) ?><br>
                            <small style="color: var(--color-text-light);"><?= e($order['customer_email']) ?></small>
                        </td>
                        <td><?= date('M j, Y g:i A', strtotime($order['created_at'])) ?></td>
                        <td><strong><?= formatPrice($order['total_amount']) ?></strong></td>
                        <td><?= strtoupper($order['payment_method']) ?></td>
                        <td>
                            <span class="badge <?= getStatusBadgeClass($order['status']) ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/order-detail.php?id=<?= $order['id'] ?>" class="btn btn-sm">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: var(--color-text-light); padding: var(--spacing-xl);">
            No orders found.
        </p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
