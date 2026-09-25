<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/helpers.php';

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$cartCount = getCartCount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' - ' : '' ?><?= SITE_NAME ?></title>
    <meta name="description" content="<?= e($pageDescription ?? 'Exquisite fine jewellery including rings, earrings, pendants, bracelets, and necklaces in South Africa') ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <?php if (isset($additionalCSS)): ?>
        <?= $additionalCSS ?>
    <?php endif; ?>
</head>
<body>
    <header class="site-header">
        <nav class="nav-container">
            <div class="nav-brand">
                <a href="<?= BASE_URL ?>/">
                    <span class="brand-name">SS Jewellery & Co</span>
                </a>
            </div>
            
            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <ul class="nav-menu">
                <li><a href="<?= BASE_URL ?>/" class="<?= $currentPage === 'index' ? 'active' : '' ?>">Home</a></li>
                <li><a href="<?= BASE_URL ?>/shop.php" class="<?= $currentPage === 'shop' ? 'active' : '' ?>">Shop</a></li>
                <li><a href="<?= BASE_URL ?>/about.php" class="<?= $currentPage === 'about' ? 'active' : '' ?>">About</a></li>
                <li><a href="<?= BASE_URL ?>/contact.php" class="<?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a></li>
            </ul>
            
            <div class="nav-actions">
                <a href="<?= BASE_URL ?>/cart.php" class="cart-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-count"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </nav>
    </header>
    
    <main class="main-content">
