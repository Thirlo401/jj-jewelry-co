<?php
/**
 * Session Management
 */

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_samesite', 'Strict');
    
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', 1);
    }
    
    session_name(SESSION_NAME);
    session_start();
}

/**
 * Generate CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF token
 */
function verifyCsrfToken($token) {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        return false;
    }
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Get flash message
 */
function getFlashMessage($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}

/**
 * Set flash message
 */
function setFlashMessage($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

/**
 * Initialize cart
 */
function initCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

/**
 * Add item to cart
 */
function addToCart($productId, $quantity = 1) {
    initCart();
    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

/**
 * Update cart item
 */
function updateCartItem($productId, $quantity) {
    initCart();
    
    if ($quantity <= 0) {
        unset($_SESSION['cart'][$productId]);
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }
}

/**
 * Remove item from cart
 */
function removeFromCart($productId) {
    initCart();
    unset($_SESSION['cart'][$productId]);
}

/**
 * Get cart items
 */
function getCart() {
    initCart();
    return $_SESSION['cart'];
}

/**
 * Get cart count
 */
function getCartCount() {
    initCart();
    return array_sum($_SESSION['cart']);
}

/**
 * Clear cart
 */
function clearCart() {
    $_SESSION['cart'] = [];
}
