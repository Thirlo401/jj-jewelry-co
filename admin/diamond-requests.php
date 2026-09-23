<?php
$pageTitle = 'Diamond Requests';
require_once __DIR__ . '/header.php';

// Get filter
$status = $_GET['status'] ?? 'all';

// Build query
$sql = "SELECT * FROM diamond_requests WHERE 1=1";
$params = [];

if ($status !== 'all') {
    $sql .= " AND status = ?";
    $params[] = $status;
}

$sql .= " ORDER BY created_at DESC";

$requests = db()->fetchAll($sql, $params);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
    <h1>Diamond Requests</h1>
</div>

<div class="admin-card" style="margin-bottom: var(--spacing-lg); padding: var(--spacing-md);">
    <div class="filter-group">
        <a href="?status=all" class="filter-btn <?= $status === 'all' ? 'active' : '' ?>">
            All (<?= count(db()->fetchAll("SELECT id FROM diamond_requests")) ?>)
        </a>
        <a href="?status=new" class="filter-btn <?= $status === 'new' ? 'active' : '' ?>">
            New (<?= count(db()->fetchAll("SELECT id FROM diamond_requests WHERE status = 'new'")) ?>)
        </a>
        <a href="?status=in_progress" class="filter-btn <?= $status === 'in_progress' ? 'active' : '' ?>">
            In Progress (<?= count(db()->fetchAll("SELECT id FROM diamond_requests WHERE status = 'in_progress'")) ?>)
        </a>
        <a href="?status=quoted" class="filter-btn <?= $status === 'quoted' ? 'active' : '' ?>">
            Quoted (<?= count(db()->fetchAll("SELECT id FROM diamond_requests WHERE status = 'quoted'")) ?>)
        </a>
        <a href="?status=completed" class="filter-btn <?= $status === 'completed' ? 'active' : '' ?>">
            Completed (<?= count(db()->fetchAll("SELECT id FROM diamond_requests WHERE status = 'completed'")) ?>)
        </a>
    </div>
</div>

<?php if (!empty($requests)): ?>
    <div class="admin-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Request #</th>
                    <th>Type</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Requirements</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><strong><?= e($request['request_number']) ?></strong></td>
                        <td>
                            <span class="badge badge-info">
                                <?= ucfirst(e($request['diamond_type'])) ?>
                            </span>
                        </td>
                        <td><?= e($request['customer_name']) ?></td>
                        <td>
                            <div><?= e($request['customer_email']) ?></div>
                            <div style="font-size: 0.875rem; color: var(--color-text-light);">
                                <?= e($request['customer_phone']) ?>
                            </div>
                        </td>
                        <td>
                            <?php if ($request['shape']): ?>
                                <div><strong>Shape:</strong> <?= e($request['shape']) ?></div>
                            <?php endif; ?>
                            <?php if ($request['carat_min'] || $request['carat_max']): ?>
                                <div><strong>Carat:</strong> 
                                    <?= $request['carat_min'] ? e($request['carat_min']) : 'Any' ?> - 
                                    <?= $request['carat_max'] ? e($request['carat_max']) : 'Any' ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($request['color_notes']): ?>
                                <div><strong>Color:</strong> <?= e($request['color_notes']) ?></div>
                            <?php endif; ?>
                            <?php if ($request['clarity_notes']): ?>
                                <div><strong>Clarity:</strong> <?= e($request['clarity_notes']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $request['budget'] ? formatPrice($request['budget']) : 'Not specified' ?>
                        </td>
                        <td>
                            <span class="badge <?= getStatusBadgeClass($request['status']) ?>">
                                <?= ucfirst(str_replace('_', ' ', e($request['status']))) ?>
                            </span>
                        </td>
                        <td style="white-space: nowrap;">
                            <?= date('j M Y', strtotime($request['created_at'])) ?>
                        </td>
                        <td>
                            <a href="diamond-request-detail.php?id=<?= $request['id'] ?>" 
                               class="btn btn-sm btn-outline">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="admin-card">
        <p style="text-align: center; color: var(--color-text-light); padding: var(--spacing-xl);">
            No diamond requests found.
        </p>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/footer.php'; ?>
