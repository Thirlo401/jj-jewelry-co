<?php
$pageTitle = 'Products';
require_once __DIR__ . '/header.php';

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $productId = (int)$_POST['product_id'];
        
        // Get product to delete image
        $product = db()->fetchOne("SELECT image_main FROM products WHERE id = ?", [$productId]);
        if ($product && $product['image_main']) {
            deleteProductImage($product['image_main']);
        }
        
        db()->query("DELETE FROM products WHERE id = ?", [$productId]);
        setFlashMessage('success', 'Product deleted successfully');
        redirect(BASE_URL . '/admin/products.php');
    }
}

// Get all products
$products = db()->fetchAll("SELECT * FROM products ORDER BY created_at DESC");
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-md);">
    <h1>Products</h1>
    <a href="<?= BASE_URL ?>/admin/product-edit.php" class="btn btn-primary">Add New Product</a>
</div>

<?php if ($message = getFlashMessage('success')): ?>
    <div class="alert alert-success"><?= e($message) ?></div>
<?php endif; ?>

<div class="admin-card">
    <?php if (!empty($products)): ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <?php if ($product['image_main']): ?>
                                <img src="<?= UPLOAD_URL . e($product['image_main']) ?>" alt="<?= e($product['name']) ?>" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: var(--border-radius);">
                            <?php else: ?>
                                <div style="width: 60px; height: 60px; background: var(--color-bg-light); border-radius: var(--border-radius);"></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= e($product['name']) ?></strong><br>
                            <?php if ($product['is_featured']): ?>
                                <span class="badge badge-success" style="font-size: 0.7rem;">Featured</span>
                            <?php endif; ?>
                        </td>
                        <td><?= e(getCategoryName($product['category'])) ?></td>
                        <td><?= e($product['sku']) ?></td>
                        <td><?= formatPrice($product['price']) ?></td>
                        <td><?= $product['stock_quantity'] ?></td>
                        <td>
                            <?php if ($product['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="<?= BASE_URL ?>/admin/product-edit.php?id=<?= $product['id'] ?>" class="btn btn-sm">Edit</a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" name="delete_product" class="btn btn-sm" style="background: var(--color-error); color: white;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: var(--color-text-light); padding: var(--spacing-xl);">
            No products yet. <a href="<?= BASE_URL ?>/admin/product-edit.php">Add your first product</a>
        </p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
