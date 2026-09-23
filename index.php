<?php
$pageTitle = 'Finest Jewellery in South Africa';
$pageDescription = 'Discover exquisite rings, earrings, bracelets, necklaces and pendants from SS Jewellery.';

require_once __DIR__ . '/includes/header.php';

// Get featured products (jewellery only - public categories)
$featuredProducts = db()->fetchAll(
    "SELECT * FROM products 
     WHERE is_featured = 1 AND is_active = 1 
     AND category IN ('rings', 'earrings', 'bracelets', 'necklaces', 'pendants', 'jewelry')
     ORDER BY created_at DESC LIMIT 6"
);

// Get hero background image
$heroImage = getSetting('hero_background_image');
$heroStyle = '';
if (!empty($heroImage)) {
    $heroImageUrl = UPLOAD_URL . e($heroImage);
    $heroStyle = 'style="background-image: url(\'' . $heroImageUrl . '\');"';
}
?>

<section class="hero hero-with-bg" <?= $heroStyle ?>>
    <div class="hero-overlay"></div>
    <div class="container">
        <h1>Timeless Elegance</h1>
        <p>Discover exquisite fine jewellery crafted to perfection</p>
        <div class="hero-actions">
            <a href="<?= BASE_URL ?>/shop.php" class="btn btn-primary">Explore Our Collection</a>
            <a href="<?= BASE_URL ?>/request-diamond.php" class="btn btn-outline">Request a Diamond</a>
        </div>
        
        <div class="trust-strip">
            <span>Fine Jewellery</span>
            <span>Expert Craftsmanship</span>
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
            <h2 class="section-title">Our Jewellery Collections</h2>
            <p class="section-subtitle">Exquisite pieces for every occasion</p>
        </div>
        
        <div class="collection-grid">
            <div class="collection-card">
                <h3>Rings</h3>
                <p>Stunning engagement rings, eternity bands, and dress rings</p>
                <a href="<?= BASE_URL ?>/shop.php?category=rings" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Earrings</h3>
                <p>Elegant studs, hoops, and drop earrings in precious metals</p>
                <a href="<?= BASE_URL ?>/shop.php?category=earrings" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Bracelets</h3>
                <p>Beautiful tennis bracelets and bangle designs</p>
                <a href="<?= BASE_URL ?>/shop.php?category=bracelets" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Necklaces</h3>
                <p>Timeless chains, statement pieces, and tennis necklaces</p>
                <a href="<?= BASE_URL ?>/shop.php?category=necklaces" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card">
                <h3>Pendants</h3>
                <p>Delicate solitaires, halos, and designer pendants</p>
                <a href="<?= BASE_URL ?>/shop.php?category=pendants" class="btn btn-accent btn-sm">Explore</a>
            </div>
            
            <div class="collection-card" style="background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-hover) 100%); color: white;">
                <h3 style="color: white;">Looking for Diamonds?</h3>
                <p style="color: rgba(255,255,255,0.9);">Request polished or rough diamonds from our specialists</p>
                <a href="<?= BASE_URL ?>/request-diamond.php" class="btn btn-outline btn-sm" style="border-color: white; color: white;">Request a Diamond</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
