<?php
/**
 * Authentication Functions
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session.php';

/**
 * Check if admin is logged in
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_username']);
}

/**
 * Require admin login
 */
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: ' . BASE_URL . '/admin/login.php');
        exit;
    }
}

/**
 * Login admin user
 */
function loginAdmin($username, $password) {
    $db = db();
    
    $admin = $db->fetchOne(
        "SELECT id, username, password, email FROM admin_users WHERE username = ?",
        [$username]
    );
    
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_email'] = $admin['email'];
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        return true;
    }
    
    return false;
}

/**
 * Logout admin user
 */
function logoutAdmin() {
    $_SESSION = [];
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}

/**
 * Get current admin user
 */
function getCurrentAdmin() {
    if (!isAdminLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_id'],
        'username' => $_SESSION['admin_username'],
        'email' => $_SESSION['admin_email']
    ];
}
