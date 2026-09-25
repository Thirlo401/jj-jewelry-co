<?php
$pageTitle = 'Edit Product';
require_once __DIR__ . '/header.php';

// Check if editing or creating
$productId = $_GET['id'] ?? null;
$product = null;

if ($productId) {
    $product = db()->fetchOne("SELECT * FROM products WHERE id = ?", [(int)$productId]);
    if (!$product) {
        redirect(BASE_URL . '/admin/products.php');
    }
    $pageTitle = 'Edit Product';
} else {
    $pageTitle = 'Add New Product';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_product'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors = [];
        
        // Validate inputs
        $sku = trim($_POST['sku'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $slug = generateSlug($name);
        $category = $_POST['category'] ?? '';
        $description = trim($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $caratWeight = !empty($_POST['carat_weight']) ? floatval($_POST['carat_weight']) : null;
        $cut = trim($_POST['cut'] ?? '');
        $clarity = trim($_POST['clarity'] ?? '');
        $color = trim($_POST['color'] ?? '');
        $stockQuantity = (int)($_POST['stock_quantity'] ?? 0);
        $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
        $isActive = isset($_POST['is_active']) ? 1 : 0;
        $currentImage = $_POST['current_image'] ?? '';
        
        if (empty($sku)) $errors[] = 'SKU is required';
        if (empty($name)) $errors[] = 'Name is required';
        if (empty($category)) $errors[] = 'Category is required';
        if ($price <= 0) $errors[] = 'Valid price is required';
        
        // Handle image upload
        $imageName = $currentImage;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = uploadProductImage($_FILES['image']);
            if ($uploadResult['success']) {
                // Delete old image if exists
                if ($currentImage) {
                    deleteProductImage($currentImage);
                }
                $imageName = $uploadResult['filename'];
            } else {
                $errors[] = $uploadResult['error'];
            }
        }
        
        if (empty($errors)) {
            try {
                if ($productId) {
                    // Update existing product
                    db()->query(
                        "UPDATE products SET sku = ?, name = ?, slug = ?, category = ?, description = ?, 
                         price = ?, carat_weight = ?, cut = ?, clarity = ?, color = ?, 
                         stock_quantity = ?, image_main = ?, is_featured = ?, is_active = ? 
                         WHERE id = ?",
                        [
                            $sku, $name, $slug, $category, $description, $price, $caratWeight,
                            $cut ?: null, $clarity ?: null, $color ?: null, $stockQuantity,
                            $imageName, $isFeatured, $isActive, $productId
                        ]
                    );
                    setFlashMessage('success', 'Product updated successfully');
                } else {
                    // Create new product
                    db()->query(
                        "INSERT INTO products (sku, name, slug, category, description, price, carat_weight, 
                         cut, clarity, color, stock_quantity, image_main, is_featured, is_active) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                        [
                            $sku, $name, $slug, $category, $description, $price, $caratWeight,
                            $cut ?: null, $clarity ?: null, $color ?: null, $stockQuantity,
                            $imageName, $isFeatured, $isActive
                        ]
                    );
                    setFlashMessage('success', 'Product created successfully');
                }
                
                redirect(BASE_URL . '/admin/products.php');
            } catch (PDOException $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $errors[] = 'SKU already exists';
                } else {
                    $errors[] = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }
}
?>

<h1><?= $pageTitle ?></h1>

<div class="admin-card" style="max-width: 900px;">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <strong>Please correct the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem;">
                <?php foreach ($errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
        <input type="hidden" name="current_image" value="<?= e($product['image_main'] ?? '') ?>">
        
        <h3>Basic Information</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label required">SKU</label>
                <input type="text" name="sku" class="form-input" 
                       value="<?= e($product['sku'] ?? $_POST['sku'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label required">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <optgroup label="Jewellery (Public Shop)">
                        <option value="rings" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'rings' ? 'selected' : '' ?>>
                            Rings
                        </option>
                        <option value="earrings" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'earrings' ? 'selected' : '' ?>>
                            Earrings
                        </option>
                        <option value="pendants" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'pendants' ? 'selected' : '' ?>>
                            Pendants
                        </option>
                        <option value="bracelets" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'bracelets' ? 'selected' : '' ?>>
                            Bracelets
                        </option>
                        <option value="necklaces" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'necklaces' ? 'selected' : '' ?>>
                            Necklaces
                        </option>
                    </optgroup>
                    <optgroup label="Diamonds (Request-Only - Not in Public Shop)">
                        <option value="rough_diamonds" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'rough_diamonds' ? 'selected' : '' ?>>
                            Rough Diamonds
                        </option>
                        <option value="polished_diamonds" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'polished_diamonds' ? 'selected' : '' ?>>
                            Polished Diamonds
                        </option>
                    </optgroup>
                    <optgroup label="Legacy (Deprecated)">
                        <option value="jewelry" <?= ($product['category'] ?? $_POST['category'] ?? '') === 'jewelry' ? 'selected' : '' ?>>
                            Jewelry (Generic - Please Recategorize)
                        </option>
                    </optgroup>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label required">Product Name</label>
            <input type="text" name="name" class="form-input" 
                   value="<?= e($product['name'] ?? $_POST['name'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-textarea"><?= e($product['description'] ?? $_POST['description'] ?? '') ?></textarea>
        </div>
        
        <h3 style="margin-top: var(--spacing-lg);">Pricing & Stock</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label required">Price (ZAR)</label>
                <input type="number" name="price" class="form-input" step="0.01" min="0"
                       value="<?= e($product['price'] ?? $_POST['price'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label class="form-label required">Stock Quantity</label>
                <input type="number" name="stock_quantity" class="form-input" min="0"
                       value="<?= e($product['stock_quantity'] ?? $_POST['stock_quantity'] ?? '0') ?>" required>
            </div>
        </div>
        
        <h3 style="margin-top: var(--spacing-lg);">Diamond/Jewelry Specifications</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Carat Weight</label>
                <input type="number" name="carat_weight" class="form-input" step="0.01" min="0"
                       value="<?= e($product['carat_weight'] ?? $_POST['carat_weight'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label class="form-label">Cut</label>
                <input type="text" name="cut" class="form-input" 
                       value="<?= e($product['cut'] ?? $_POST['cut'] ?? '') ?>"
                       placeholder="e.g., Round Brilliant, Princess">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Clarity</label>
                <input type="text" name="clarity" class="form-input" 
                       value="<?= e($product['clarity'] ?? $_POST['clarity'] ?? '') ?>"
                       placeholder="e.g., VVS1, VS2, IF">
            </div>
            
            <div class="form-group">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-input" 
                       value="<?= e($product['color'] ?? $_POST['color'] ?? '') ?>"
                       placeholder="e.g., D, E, F">
            </div>
        </div>
        
        <h3 style="margin-top: var(--spacing-lg);">Product Image</h3>
        
        <?php if (!empty($product['image_main'])): ?>
            <div style="margin-bottom: var(--spacing-md);">
                <img src="<?= UPLOAD_URL . e($product['image_main']) ?>" alt="Current image" 
                     style="max-width: 200px; border-radius: var(--border-radius);">
                <p style="color: var(--color-text-light); font-size: 0.875rem; margin-top: 0.5rem;">
                    Current image (upload a new one to replace)
                </p>
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label class="form-label">Upload Image</label>
            <input type="file" name="image" class="form-input" accept="image/jpeg,image/png,image/webp">
            <small style="color: var(--color-text-light);">Allowed: JPG, PNG, WEBP (max 5MB)</small>
        </div>
        
        <h3 style="margin-top: var(--spacing-lg);">Display Options</h3>
        
        <div style="display: flex; gap: var(--spacing-md); margin-bottom: var(--spacing-md);">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" 
                       <?= ($product['is_featured'] ?? $_POST['is_featured'] ?? 0) ? 'checked' : '' ?>>
                <span>Featured Product</span>
            </label>
            
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" 
                       <?= isset($product) ? ($product['is_active'] ? 'checked' : '') : 'checked' ?>>
                <span>Active (visible on site)</span>
            </label>
        </div>
        
        <div style="display: flex; gap: var(--spacing-sm); margin-top: var(--spacing-lg);">
            <button type="submit" name="save_product" class="btn btn-primary">
                <?= $productId ? 'Update Product' : 'Create Product' ?>
            </button>
            <a href="<?= BASE_URL ?>/admin/products.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
