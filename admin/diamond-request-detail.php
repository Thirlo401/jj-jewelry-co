<?php
$pageTitle = 'Diamond Request Details';
require_once __DIR__ . '/header.php';

$requestId = $_GET['id'] ?? null;
if (!$requestId) {
    redirect(BASE_URL . '/admin/diamond-requests.php');
}

$request = db()->fetchOne("SELECT * FROM diamond_requests WHERE id = ?", [(int)$requestId]);
if (!$request) {
    redirect(BASE_URL . '/admin/diamond-requests.php');
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $newStatus = $_POST['status'] ?? '';
        $adminNotes = trim($_POST['admin_notes'] ?? '');
        
        db()->query(
            "UPDATE diamond_requests SET status = ?, admin_notes = ? WHERE id = ?",
            [$newStatus, $adminNotes, $requestId]
        );
        
        setFlashMessage('success', 'Request updated successfully');
        redirect(BASE_URL . '/admin/diamond-request-detail.php?id=' . $requestId);
    }
}
?>

<div style="margin-bottom: var(--spacing-lg);">
    <a href="<?= BASE_URL ?>/admin/diamond-requests.php" class="btn btn-outline btn-sm">← Back to Requests</a>
</div>

<h1>Diamond Request: <?= e($request['request_number']) ?></h1>

<?php if ($message = getFlashMessage('success')): ?>
    <div class="alert alert-success"><?= e($message) ?></div>
<?php endif; ?>

<div class="form-row">
    <div class="admin-card" style="flex: 2;">
        <h3>Request Details</h3>
        
        <div class="detail-row">
            <span class="detail-label">Request Number:</span>
            <strong><?= e($request['request_number']) ?></strong>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Diamond Type:</span>
            <span class="badge badge-info"><?= ucfirst(e($request['diamond_type'])) ?></span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Preferred Shape:</span>
            <?= $request['shape'] ? e($request['shape']) : 'Not specified' ?>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Carat Range:</span>
            <?php if ($request['carat_min'] || $request['carat_max']): ?>
                <?= $request['carat_min'] ? e($request['carat_min']) : 'Any' ?> - 
                <?= $request['carat_max'] ? e($request['carat_max']) : 'Any' ?> ct
            <?php else: ?>
                Not specified
            <?php endif; ?>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Color Preferences:</span>
            <?= $request['color_notes'] ? e($request['color_notes']) : 'Not specified' ?>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Clarity Preferences:</span>
            <?= $request['clarity_notes'] ? e($request['clarity_notes']) : 'Not specified' ?>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Budget:</span>
            <?= $request['budget'] ? formatPrice($request['budget']) : 'Not specified' ?>
        </div>
        
        <?php if ($request['message']): ?>
            <div class="detail-row">
                <span class="detail-label">Customer Message:</span>
                <div style="white-space: pre-wrap; padding: var(--spacing-sm); background: var(--color-bg-alt); border-radius: var(--border-radius);">
                    <?= e($request['message']) ?>
                </div>
            </div>
        <?php endif; ?>
        
        <h3 style="margin-top: var(--spacing-lg);">Customer Information</h3>
        
        <div class="detail-row">
            <span class="detail-label">Name:</span>
            <?= e($request['customer_name']) ?>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <a href="mailto:<?= e($request['customer_email']) ?>"><?= e($request['customer_email']) ?></a>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Phone:</span>
            <a href="tel:<?= e($request['customer_phone']) ?>"><?= e($request['customer_phone']) ?></a>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Submitted:</span>
            <?= date('j F Y, g:i a', strtotime($request['created_at'])) ?>
        </div>
    </div>
    
    <div class="admin-card" style="flex: 1;">
        <h3>Update Request</h3>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="new" <?= $request['status'] === 'new' ? 'selected' : '' ?>>New</option>
                    <option value="in_progress" <?= $request['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="quoted" <?= $request['status'] === 'quoted' ? 'selected' : '' ?>>Quoted</option>
                    <option value="completed" <?= $request['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="cancelled" <?= $request['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Admin Notes</label>
                <textarea name="admin_notes" class="form-textarea" rows="8" 
                          placeholder="Internal notes, quotes sent, diamonds sourced, etc."><?= e($request['admin_notes'] ?? '') ?></textarea>
            </div>
            
            <button type="submit" name="update_status" class="btn btn-primary" style="width: 100%;">
                Update Request
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
