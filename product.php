<?php
require_once __DIR__ . '/includes/header.php';

// Get product by slug
$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    redirect(BASE_URL . '/shop.php');
}

$product = db()->fetchOne(
    "SELECT * FROM products WHERE slug = ? AND is_active = 1",
    [$slug]
);

if (!$product) {
    redirect(BASE_URL . '/shop.php');
}

$pageTitle = $product['name'];

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if ($quantity > 0 && $quantity <= $product['stock_quantity']) {
            addToCart($product['id'], $quantity);
            setFlashMessage('success', 'Product added to cart!');
            redirect(BASE_URL . '/cart.php');
        } else {
            setFlashMessage('error', 'Invalid quantity');
        }
    }
}
?>

<div class="container">
    <div class="product-detail">
        <div class="product-detail-image">
            <?php if ($product['image_main']): ?>
                <img src="<?= UPLOAD_URL . e($product['image_main']) ?>" alt="<?= e($product['name']) ?>">
            <?php else: ?>
                <img src="<?= BASE_URL ?>/assets/images/placeholder.jpg" alt="<?= e($product['name']) ?>">
            <?php endif; ?>
        </div>
        
        <div class="product-detail-info">
            <div class="product-category"><?= e(getCategoryName($product['category'])) ?></div>
            <h1><?= e($product['name']) ?></h1>
            <div class="product-price"><?= formatPrice($product['price']) ?></div>
            
            <?php if ($product['description']): ?>
                <p style="color: var(--color-text-light); line-height: 1.8; margin: var(--spacing-md) 0;">
                    <?= nl2br(e($product['description'])) ?>
                </p>
            <?php endif; ?>
            
            <div class="product-meta">
                <div class="meta-item">
                    <span class="meta-label">SKU:</span>
                    <span class="meta-value"><?= e($product['sku']) ?></span>
                </div>
                
                <?php if ($product['carat_weight']): ?>
                    <div class="meta-item">
                        <span class="meta-label">Carat Weight:</span>
                        <span class="meta-value"><?= e($product['carat_weight']) ?> ct</span>
                    </div>
                <?php endif; ?>
                
                <?php if ($product['cut']): ?>
                    <div class="meta-item">
                        <span class="meta-label">Cut:</span>
                        <span class="meta-value"><?= e($product['cut']) ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($product['clarity']): ?>
                    <div class="meta-item">
                        <span class="meta-label">Clarity:</span>
                        <span class="meta-value"><?= e($product['clarity']) ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($product['color']): ?>
                    <div class="meta-item">
                        <span class="meta-label">Color:</span>
                        <span class="meta-value"><?= e($product['color']) ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="meta-item">
                    <span class="meta-label">Availability:</span>
                    <span class="meta-value">
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <?= $product['stock_quantity'] ?> in stock
                        <?php else: ?>
                            Out of stock
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <?php if ($product['stock_quantity'] > 0): ?>
                <form method="POST" style="margin-top: var(--spacing-md);">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="form-group">
                        <label class="form-label">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity'] ?>" class="form-input" style="width: 100px;">
                    </div>
                    
                    <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                    <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Continue Shopping</a>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    This item is currently out of stock. Please contact us for availability.
                </div>
                <a href="<?= BASE_URL ?>/contact.php" class="btn btn-accent">Contact Us</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
