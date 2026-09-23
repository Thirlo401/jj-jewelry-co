<?php
/**
 * Password Hash Generator for SS Jewellery & Co
 * 
 * This script generates the correct bcrypt hash for the default admin password.
 * Run this once during setup if you need to regenerate the admin password hash.
 * 
 * Usage: php generate_admin_hash.php
 */

$password = 'changeme123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "===========================================\n";
echo "Password Hash Generator\n";
echo "===========================================\n\n";
echo "Password: {$password}\n";
echo "Hash: {$hash}\n\n";
echo "Copy this hash and update it in:\n";
echo "1. sql/seed.sql (admin_users INSERT statement)\n";
echo "2. Or run this SQL after import:\n\n";
echo "UPDATE admin_users SET password = '{$hash}' WHERE username = 'admin';\n\n";
echo "===========================================\n";
