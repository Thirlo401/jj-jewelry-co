<?php
$pageTitle = 'Finest Diamonds & Jewelry in South Africa';
$pageDescription = 'Discover exceptional rough diamonds, polished diamonds, and exquisite jewelry from JJ Jewelry & Co.';

require_once __DIR__ . '/includes/header.php';

// Get featured products
$featuredProducts = db()->fetchAll(
    "SELECT * FROM products WHERE is_featured = 1 AND is_active = 1 ORDER BY created_at DESC LIMIT 6"
);
?>

<section class="hero">
    <div class="container">
        <h1>Timeless Elegance</h1>
        <p>Discover exceptional diamonds and fine jewelry crafted to perfection</p>
        <a href="<?= BASE_URL ?>/shop.php" class="btn btn-primary">Explore Our Collection</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Collection</h2>
            <p class="section-subtitle">Handpicked exceptional pieces for the discerning collector</p>
        </div>
        
        <?php if (!empty($featuredProducts)): ?>
            <div class="product-grid">
                <?php foreach ($featuredProducts as $product): ?>
                    <a href="<?= BASE_URL ?>/product.php?slug=<?= e($product['slug']) ?>" class="product-card">
                        <div class="product-image">
                            <?php if ($product['image_main']): ?>
                                <img src="<?= UPLOAD_URL . e($product['image_main']) ?>" alt="<?= e($product['name']) ?>">
                            <?php else: ?>
                                <img src="<?= BASE_URL ?>/assets/images/placeholder.jpg" alt="<?= e($product['name']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <div class="product-category"><?= e(getCategoryName($product['category'])) ?></div>
                            <h3 class="product-name"><?= e($product['name']) ?></h3>
                            <div class="product-price"><?= formatPrice($product['price']) ?></div>
                            <?php if ($product['description']): ?>
                                <p class="product-description"><?= e(truncateText($product['description'], 80)) ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--color-text-light);">No featured products available at this time.</p>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: var(--spacing-lg);">
            <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">View All Products</a>
        </div>
    </div>
</section>

<section class="section" style="background: var(--color-bg-light);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Collections</h2>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-md);">
            <div style="text-align: center; padding: var(--spacing-lg);">
                <h3>Rough Diamonds</h3>
                <p style="color: var(--color-text-light); margin: var(--spacing-sm) 0;">Uncut natural diamonds for collectors and custom jewelry</p>
                <a href="<?= BASE_URL ?>/shop.php?category=rough_diamonds" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div style="text-align: center; padding: var(--spacing-lg);">
                <h3>Polished Diamonds</h3>
                <p style="color: var(--color-text-light); margin: var(--spacing-sm) 0;">Expertly cut and certified diamonds of exceptional quality</p>
                <a href="<?= BASE_URL ?>/shop.php?category=polished_diamonds" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div style="text-align: center; padding: var(--spacing-lg);">
                <h3>Fine Jewelry</h3>
                <p style="color: var(--color-text-light); margin: var(--spacing-sm) 0;">Exquisite engagement rings, bracelets, and custom pieces</p>
                <a href="<?= BASE_URL ?>/shop.php?category=jewelry" class="btn btn-accent btn-sm">Explore</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
