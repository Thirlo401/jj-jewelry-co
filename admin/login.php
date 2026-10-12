<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (loginAdmin($username, $password)) {
            redirect(BASE_URL . '/admin/');
        } else {
            $error = 'Invalid username or password';
        }
    }
}

// Redirect if already logged in
if (isAdminLoggedIn()) {
    redirect(BASE_URL . '/admin/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--color-bg-light);">
        <div style="width: 100%; max-width: 400px; padding: var(--spacing-md);">
            <div class="admin-card">
                <h2 style="text-align: center; margin-bottom: var(--spacing-md);">Admin Login</h2>
                <p style="text-align: center; color: var(--color-text-light); margin-bottom: var(--spacing-md);">
                    <?= SITE_NAME ?>
                </p>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?= e($error) ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-input" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                </form>
                
                <div style="text-align: center; margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid var(--color-border);">
                    <a href="<?= BASE_URL ?>/" style="color: var(--color-text-light); font-size: 0.95rem;">
                        &larr; Back to Website
                    </a>
                </div>
            </div>
            
            <p style="text-align: center; margin-top: var(--spacing-md); color: var(--color-text-light); font-size: 0.875rem;">
                Default credentials: admin / changeme123<br>
                <strong style="color: var(--color-error);">Change immediately after first login!</strong>
            </p>
        </div>
    </div>
</body>
</html>
