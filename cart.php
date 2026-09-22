<?php
$pageTitle = 'Shopping Cart';
require_once __DIR__ . '/includes/header.php';

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        if (isset($_POST['update_cart'])) {
            foreach ($_POST['quantity'] as $productId => $quantity) {
                updateCartItem((int)$productId, (int)$quantity);
            }
            setFlashMessage('success', 'Cart updated successfully');
            redirect(BASE_URL . '/cart.php');
        } elseif (isset($_POST['remove_item'])) {
            removeFromCart((int)$_POST['product_id']);
            setFlashMessage('success', 'Item removed from cart');
            redirect(BASE_URL . '/cart.php');
        }
    }
}

// Get cart items with details
$cartItems = getCartItemsWithDetails();
$cartTotal = calculateCartTotal(getCart());
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0;">
        <h1 style="margin-bottom: var(--spacing-md);">Shopping Cart</h1>
        
        <?php if ($message = getFlashMessage('success')): ?>
            <div class="alert alert-success"><?= e($message) ?></div>
        <?php endif; ?>
        
        <?php if ($message = getFlashMessage('error')): ?>
            <div class="alert alert-error"><?= e($message) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($cartItems)): ?>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <div class="cart-product">
                                        <?php if ($item['image_main']): ?>
                                            <img src="<?= UPLOAD_URL . e($item['image_main']) ?>" alt="<?= e($item['name']) ?>" class="cart-product-image">
                                        <?php else: ?>
                                            <img src="<?= BASE_URL ?>/assets/images/placeholder.jpg" alt="<?= e($item['name']) ?>" class="cart-product-image">
                                        <?php endif; ?>
                                        <div>
                                            <strong style="font-family: var(--font-display); font-size: 1.125rem;"><?= e($item['name']) ?></strong><br>
                                            <small style="color: var(--color-text-light);"><?= e($item['sku']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 500;"><?= formatPrice($item['price']) ?></td>
                                <td class="cart-quantity">
                                    <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" 
                                           min="1" max="<?= $item['stock_quantity'] ?>">
                                </td>
                                <td><strong style="color: var(--color-accent); font-family: var(--font-display); font-size: 1.25rem;"><?= formatPrice($item['subtotal']) ?></strong></td>
                                <td>
                                    <button type="submit" name="remove_item" value="1" 
                                            onclick="this.form.product_id.value = <?= $item['id'] ?>"
                                            class="btn btn-sm" style="background: var(--color-error); color: white;">
                                        Remove
                                    </button>
                                    <input type="hidden" name="product_id" value="">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div style="display: flex; justify-content: space-between; margin-top: var(--spacing-lg); gap: var(--spacing-md); flex-wrap: wrap;">
                    <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Continue Shopping</a>
                    <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
                </div>
            </form>
            
            <div class="cart-summary">
                <h3>Cart Summary</h3>
                <div class="cart-total">
                    <span>Total:</span>
                    <span><?= formatPrice($cartTotal) ?></span>
                </div>
                <a href="<?= BASE_URL ?>/checkout.php" class="btn btn-accent" style="width: 100%; margin-top: var(--spacing-md); text-align: center;">
                    Proceed to Checkout
                </a>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: var(--spacing-2xl); background: var(--color-bg-white); border: 1px solid var(--color-border); border-radius: var(--border-radius);">
                <h3 style="margin-bottom: var(--spacing-md);">Your cart is empty</h3>
                <p style="color: var(--color-text-light); margin-bottom: var(--spacing-lg);">Add some beautiful pieces to your cart to get started.</p>
                <a href="<?= BASE_URL ?>/shop.php" class="btn btn-primary">
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
