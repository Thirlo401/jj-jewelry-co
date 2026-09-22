<?php
$pageTitle = 'Shop';
require_once __DIR__ . '/includes/header.php';

// Get filter parameters
$category = $_GET['category'] ?? 'all';
$sort = $_GET['sort'] ?? 'newest';

// Build query
$sql = "SELECT * FROM products WHERE is_active = 1";
$params = [];

if ($category !== 'all') {
    $sql .= " AND category = ?";
    $params[] = $category;
}

// Add sorting
switch ($sort) {
    case 'price_low':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_high':
        $sql .= " ORDER BY price DESC";
        break;
    case 'name':
        $sql .= " ORDER BY name ASC";
        break;
    default:
        $sql .= " ORDER BY created_at DESC";
}

$products = db()->fetchAll($sql, $params);
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0;">
        <h1 style="margin-bottom: var(--spacing-md);">Shop Our Collection</h1>
        <p style="color: var(--color-text-light); font-size: 1.125rem; margin-bottom: var(--spacing-lg);">
            Discover our exquisite selection of diamonds and fine jewelry
        </p>
        
        <div class="shop-header">
            <div class="filter-group">
                <a href="?category=all&sort=<?= e($sort) ?>" 
                   class="filter-btn <?= $category === 'all' ? 'active' : '' ?>">
                    All
                </a>
                <a href="?category=rough_diamonds&sort=<?= e($sort) ?>" 
                   class="filter-btn <?= $category === 'rough_diamonds' ? 'active' : '' ?>">
                    Rough Diamonds
                </a>
                <a href="?category=polished_diamonds&sort=<?= e($sort) ?>" 
                   class="filter-btn <?= $category === 'polished_diamonds' ? 'active' : '' ?>">
                    Polished Diamonds
                </a>
                <a href="?category=jewelry&sort=<?= e($sort) ?>" 
                   class="filter-btn <?= $category === 'jewelry' ? 'active' : '' ?>">
                    Jewelry
                </a>
            </div>
            
            <div class="filter-group">
                <select class="form-select" onchange="window.location.href='?category=<?= e($category) ?>&sort=' + this.value" style="width: auto;">
                    <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
                    <option value="price_low" <?= $sort === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
                    <option value="price_high" <?= $sort === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
                    <option value="name" <?= $sort === 'name' ? 'selected' : '' ?>>Name</option>
                </select>
            </div>
        </div>
        
        <?php if (!empty($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
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
            <div style="text-align: center; padding: var(--spacing-2xl); color: var(--color-text-light);">
                <h3 style="margin-bottom: var(--spacing-sm);">No products found</h3>
                <p>Please try a different filter.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
