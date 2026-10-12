<?php
/**
 * SS Jewellery - Configuration
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to config.php
 * 2. Update database credentials below
 * 3. Set BASE_URL to your domain
 * 4. Never commit config.php with real credentials
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

// Site Configuration
define('BASE_URL', 'https://yourdomain.com'); // No trailing slash
define('SITE_NAME', 'SS Jewellery');

// Security
define('SESSION_NAME', 'jj_jewelry_session');
define('CSRF_TOKEN_NAME', 'csrf_token');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/products/');
define('UPLOAD_URL', BASE_URL . '/assets/uploads/products/');
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

// Timezone
date_default_timezone_set('Africa/Johannesburg');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
