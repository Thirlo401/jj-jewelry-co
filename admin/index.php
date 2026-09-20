<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/header.php';

// Get statistics
$totalProducts = db()->fetchOne("SELECT COUNT(*) as count FROM products")['count'];
$activeProducts = db()->fetchOne("SELECT COUNT(*) as count FROM products WHERE is_active = 1")['count'];
$totalOrders = db()->fetchOne("SELECT COUNT(*) as count FROM orders")['count'];
$pendingOrders = db()->fetchOne("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'")['count'];
$totalRevenue = db()->fetchOne("SELECT SUM(total_amount) as total FROM orders WHERE status IN ('paid', 'processing', 'shipped')")['total'] ?? 0;

// Get recent orders
$recentOrders = db()->fetchAll(
    "SELECT * FROM orders ORDER BY created_at DESC LIMIT 10"
);
?>

<h1>Dashboard</h1>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value"><?= $totalProducts ?></div>
        <div class="stat-label">Total Products</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value"><?= $activeProducts ?></div>
        <div class="stat-label">Active Products</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value"><?= $totalOrders ?></div>
        <div class="stat-label">Total Orders</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value"><?= $pendingOrders ?></div>
        <div class="stat-label">Pending Orders</div>
    </div>
    
    <div class="stat-card" style="grid-column: span 2;">
        <div class="stat-value"><?= formatPrice($totalRevenue) ?></div>
        <div class="stat-label">Total Revenue (Paid Orders)</div>
    </div>
</div>

<div class="admin-card">
    <h2>Recent Orders</h2>
    
    <?php if (!empty($recentOrders)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentOrders as $order): ?>
                    <tr>
                        <td><strong><?= e($order['order_number']) ?></strong></td>
                        <td><?= e($order['customer_name']) ?></td>
                        <td><?= date('M j, Y', strtotime($order['created_at'])) ?></td>
                        <td><?= formatPrice($order['total_amount']) ?></td>
                        <td>
                            <span class="badge <?= getStatusBadgeClass($order['status']) ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/order-detail.php?id=<?= $order['id'] ?>" class="btn btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="text-align: center; margin-top: var(--spacing-md);">
            <a href="<?= BASE_URL ?>/admin/orders.php" class="btn btn-outline">View All Orders</a>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: var(--color-text-light); padding: var(--spacing-md);">
            No orders yet.
        </p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
