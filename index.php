<?php
$pageTitle = 'Finest Diamonds & Jewelry in South Africa';
$pageDescription = 'Discover exceptional rough diamonds, polished diamonds, and exquisite jewelry from SS Jewellery.';

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
        <div class="hero-actions">
            <a href="<?= BASE_URL ?>/shop.php" class="btn btn-primary">Explore Our Collection</a>
            <a href="<?= BASE_URL ?>/about.php" class="btn btn-outline">Our Story</a>
        </div>
        
        <div class="trust-strip">
            <span>Certified Diamonds</span>
            <span>Ethical Sourcing</span>
            <span>Secure Checkout</span>
        </div>
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
            <p style="text-align: center; color: var(--color-text-light); padding: var(--spacing-xl);">No featured products available at this time.</p>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: var(--spacing-xl);">
            <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">View All Products</a>
        </div>
    </div>
</section>

<section class="section" style="background: var(--color-bg-alt);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Collections</h2>
        </div>
        
        <div class="collection-grid">
            <div class="collection-card">
                <h3>Rough Diamonds</h3>
                <p>Uncut natural diamonds for collectors and custom jewelry</p>
                <a href="<?= BASE_URL ?>/shop.php?category=rough_diamonds" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Polished Diamonds</h3>
                <p>Expertly cut and certified diamonds of exceptional quality</p>
                <a href="<?= BASE_URL ?>/shop.php?category=polished_diamonds" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Fine Jewelry</h3>
                <p>Exquisite engagement rings, bracelets, and custom pieces</p>
                <a href="<?= BASE_URL ?>/shop.php?category=jewelry" class="btn btn-accent btn-sm">Explore</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
