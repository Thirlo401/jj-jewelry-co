<?php
$pageTitle = 'Checkout';
require_once __DIR__ . '/includes/header.php';

// Check if cart is empty
$cartItems = getCartItemsWithDetails();
$cartTotal = calculateCartTotal(getCart());

if (empty($cartItems)) {
    redirect(BASE_URL . '/cart.php');
}

// Handle checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    if (verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        // Validate input
        $errors = [];
        $customerName = trim($_POST['customer_name'] ?? '');
        $customerEmail = trim($_POST['customer_email'] ?? '');
        $customerPhone = trim($_POST['customer_phone'] ?? '');
        $shippingAddress = trim($_POST['shipping_address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');
        $province = trim($_POST['province'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? 'eft';
        $customerNotes = trim($_POST['customer_notes'] ?? '');
        
        if (empty($customerName)) $errors[] = 'Name is required';
        if (empty($customerEmail) || !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required';
        }
        if (empty($customerPhone)) $errors[] = 'Phone is required';
        if (empty($shippingAddress)) $errors[] = 'Shipping address is required';
        if (empty($city)) $errors[] = 'City is required';
        if (empty($postalCode)) $errors[] = 'Postal code is required';
        if (empty($province)) $errors[] = 'Province is required';
        
        if (empty($errors)) {
            try {
                // Generate order number
                $orderNumber = generateOrderNumber();
                
                // Create order
                $db = db();
                $db->query(
                    "INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, 
                     shipping_address, city, postal_code, province, total_amount, payment_method, customer_notes) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [
                        $orderNumber, $customerName, $customerEmail, $customerPhone,
                        $shippingAddress, $city, $postalCode, $province,
                        $cartTotal, $paymentMethod, $customerNotes
                    ]
                );
                
                $orderId = $db->lastInsertId();
                
                // Add order items
                foreach ($cartItems as $item) {
                    $db->query(
                        "INSERT INTO order_items (order_id, product_id, product_name, product_sku, price, quantity, subtotal) 
                         VALUES (?, ?, ?, ?, ?, ?, ?)",
                        [
                            $orderId, $item['id'], $item['name'], $item['sku'],
                            $item['price'], $item['quantity'], $item['subtotal']
                        ]
                    );
                }
                
                // Clear cart
                clearCart();
                
                // Redirect to thank you page
                redirect(BASE_URL . '/thank-you.php?order=' . $orderNumber);
            } catch (Exception $e) {
                $errors[] = 'An error occurred while processing your order. Please try again.';
                error_log($e->getMessage());
            }
        }
    }
}
?>

<div class="container">
    <div style="padding: var(--spacing-lg) 0;">
        <h1>Checkout</h1>
        
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
        
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: var(--spacing-lg); margin-top: var(--spacing-md);">
            <div>
                <form method="POST" id="checkout-form">
                    <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                    
                    <div class="admin-card">
                        <h3>Contact Information</h3>
                        
                        <div class="form-group">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="customer_name" class="form-input" 
                                   value="<?= e($_POST['customer_name'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Email</label>
                                <input type="email" name="customer_email" class="form-input" 
                                       value="<?= e($_POST['customer_email'] ?? '') ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label required">Phone</label>
                                <input type="tel" name="customer_phone" class="form-input" 
                                       value="<?= e($_POST['customer_phone'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="admin-card">
                        <h3>Shipping Address</h3>
                        
                        <div class="form-group">
                            <label class="form-label required">Street Address</label>
                            <input type="text" name="shipping_address" class="form-input" 
                                   value="<?= e($_POST['shipping_address'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">City</label>
                                <input type="text" name="city" class="form-input" 
                                       value="<?= e($_POST['city'] ?? '') ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label required">Postal Code</label>
                                <input type="text" name="postal_code" class="form-input" 
                                       value="<?= e($_POST['postal_code'] ?? '') ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label required">Province</label>
                            <select name="province" class="form-select" required>
                                <option value="">Select Province</option>
                                <option value="Gauteng" <?= ($_POST['province'] ?? '') === 'Gauteng' ? 'selected' : '' ?>>Gauteng</option>
                                <option value="Western Cape" <?= ($_POST['province'] ?? '') === 'Western Cape' ? 'selected' : '' ?>>Western Cape</option>
                                <option value="KwaZulu-Natal" <?= ($_POST['province'] ?? '') === 'KwaZulu-Natal' ? 'selected' : '' ?>>KwaZulu-Natal</option>
                                <option value="Eastern Cape" <?= ($_POST['province'] ?? '') === 'Eastern Cape' ? 'selected' : '' ?>>Eastern Cape</option>
                                <option value="Free State" <?= ($_POST['province'] ?? '') === 'Free State' ? 'selected' : '' ?>>Free State</option>
                                <option value="Mpumalanga" <?= ($_POST['province'] ?? '') === 'Mpumalanga' ? 'selected' : '' ?>>Mpumalanga</option>
                                <option value="Limpopo" <?= ($_POST['province'] ?? '') === 'Limpopo' ? 'selected' : '' ?>>Limpopo</option>
                                <option value="North West" <?= ($_POST['province'] ?? '') === 'North West' ? 'selected' : '' ?>>North West</option>
                                <option value="Northern Cape" <?= ($_POST['province'] ?? '') === 'Northern Cape' ? 'selected' : '' ?>>Northern Cape</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="admin-card">
                        <h3>Payment Method</h3>
                        
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: var(--spacing-sm); background: var(--color-bg-light); border-radius: var(--border-radius);">
                                <input type="radio" name="payment_method" value="eft" checked>
                                <strong>EFT / Bank Transfer</strong>
                            </label>
                            <div style="padding: var(--spacing-sm); background: var(--color-bg-light); margin-top: 0.5rem; font-size: 0.95rem; color: var(--color-text-light);">
                                Bank details will be provided after order confirmation. Please use your order number as payment reference.
                            </div>
                        </div>
                        
                        <?php if (getSetting('payfast_merchant_id')): ?>
                            <div>
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; padding: var(--spacing-sm); background: var(--color-bg-light); border-radius: var(--border-radius);">
                                    <input type="radio" name="payment_method" value="payfast">
                                    <strong>PayFast (Online Payment)</strong>
                                </label>
                                <div style="padding: var(--spacing-sm); background: var(--color-bg-light); margin-top: 0.5rem; font-size: 0.95rem; color: var(--color-text-light);">
                                    Pay securely with credit card, debit card, or instant EFT.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="admin-card">
                        <h3>Additional Notes</h3>
                        
                        <div class="form-group">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="customer_notes" class="form-textarea" 
                                      placeholder="Any special instructions or requests?"><?= e($_POST['customer_notes'] ?? '') ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            
            <div>
                <div class="admin-card" style="position: sticky; top: 100px;">
                    <h3>Order Summary</h3>
                    
                    <div style="margin: var(--spacing-md) 0;">
                        <?php foreach ($cartItems as $item): ?>
                            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--color-border);">
                                <div>
                                    <strong><?= e($item['name']) ?></strong><br>
                                    <small style="color: var(--color-text-light);">Qty: <?= $item['quantity'] ?></small>
                                </div>
                                <div><?= formatPrice($item['subtotal']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="cart-total">
                        <span>Total:</span>
                        <span><?= formatPrice($cartTotal) ?></span>
                    </div>
                    
                    <button type="submit" name="place_order" form="checkout-form" class="btn btn-accent" style="width: 100%; margin-top: var(--spacing-md);">
                        Place Order
                    </button>
                    
                    <a href="<?= BASE_URL ?>/cart.php" class="btn btn-outline" style="width: 100%; margin-top: var(--spacing-sm); text-align: center;">
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
