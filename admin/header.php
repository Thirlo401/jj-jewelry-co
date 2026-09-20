<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

requireAdminLogin();

$pageTitle = $pageTitle ?? 'Admin Panel';
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <header class="admin-header">
        <nav class="admin-nav">
            <div>
                <a href="<?= BASE_URL ?>/admin/" style="font-weight: 600; font-size: 1.125rem;">
                    <?= SITE_NAME ?> Admin
                </a>
            </div>
            
            <div>
                <a href="<?= BASE_URL ?>/admin/" class="<?= $currentPage === 'index' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= BASE_URL ?>/admin/products.php" class="<?= $currentPage === 'products' || $currentPage === 'product-edit' ? 'active' : '' ?>">Products</a>
                <a href="<?= BASE_URL ?>/admin/orders.php" class="<?= $currentPage === 'orders' || $currentPage === 'order-detail' ? 'active' : '' ?>">Orders</a>
                <a href="<?= BASE_URL ?>/admin/settings.php" class="<?= $currentPage === 'settings' ? 'active' : '' ?>">Settings</a>
                <a href="<?= BASE_URL ?>/" target="_blank">View Site</a>
                <a href="<?= BASE_URL ?>/admin/logout.php">Logout</a>
            </div>
        </nav>
    </header>
    
    <main class="admin-content">
