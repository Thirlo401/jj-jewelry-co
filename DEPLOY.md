# Deployment Guide for cPanel Hosting

Complete step-by-step instructions for deploying JJ Jewelry & Co to cPanel hosting.

## Prerequisites

Before you begin, ensure you have:

- cPanel hosting account with PHP 8.0+ support
- MySQL database access
- FTP/SFTP credentials or cPanel File Manager access
- Your domain configured and pointing to your hosting

## Deployment Steps

### Step 1: Prepare Your Files

1. Download or export the entire project directory
2. Verify all files are present (see project structure in README.md)
3. **Do NOT include** `.git` folder if present

### Step 2: Create MySQL Database

1. **Log in to cPanel**
2. **Navigate to "MySQL Databases"** (under Databases section)
3. **Create a new database**:
   - Database name: e.g., `youruser_jjjewelry`
   - Click "Create Database"
4. **Create a database user**:
   - Username: e.g., `youruser_jjadmin`
   - Password: Generate a strong password (save it!)
   - Click "Create User"
5. **Add user to database**:
   - Select the database you created
   - Select the user you created
   - Check "ALL PRIVILEGES"
   - Click "Make Changes"
6. **Save these credentials** - you'll need them for configuration:
   ```
   Database Name: youruser_jjjewelry
   Database User: youruser_jjadmin
   Database Password: [your generated password]
   Database Host: localhost
   ```

### Step 3: Import Database Schema

1. **Navigate to phpMyAdmin** in cPanel (under Databases section)
2. **Select your database** from the left sidebar
3. **Click the "Import" tab**
4. **Upload and import** `sql/schema.sql`:
   - Click "Choose File"
   - Select `sql/schema.sql`
   - Click "Go" at the bottom
   - Wait for "Import has been successfully finished" message
5. **Import sample data** `sql/seed.sql`:
   - Repeat the process with `sql/seed.sql`
   - This creates the admin user and sample products

**✓ Database import complete!** You should now see tables: `admin_users`, `products`, `orders`, `order_items`, `settings`

### Step 4: Upload Files to Server

#### Option A: Using cPanel File Manager (Recommended for beginners)

1. **Navigate to "File Manager"** in cPanel
2. **Go to `public_html`** directory (or your domain's document root)
3. **Upload files**:
   - Click "Upload" button
   - Select all files from your local project folder
   - Wait for upload to complete
   - Or upload as a ZIP file and extract:
     - Upload the ZIP file
     - Right-click → "Extract"
     - Move extracted files to `public_html` if needed

#### Option B: Using FTP/SFTP (Recommended for advanced users)

1. **Connect to your server** using an FTP client (FileZilla, Cyberduck, etc.)
   - Host: Your domain or server IP
   - Username: Your cPanel username
   - Password: Your cPanel password
   - Port: 21 (FTP) or 22 (SFTP)
2. **Navigate to `public_html`** (or your domain's document root)
3. **Upload all files** from your local project folder
4. **Verify upload** - ensure all folders and files are present

### Step 5: Configure the Application

1. **Locate `config.example.php`** in the root of `public_html`
2. **Copy it to `config.php`**:
   - In File Manager: Right-click → Copy → Name it `config.php`
   - Via FTP: Download, rename locally, upload
3. **Edit `config.php`** with your database credentials:

```php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'youruser_jjjewelry');      // Your database name
define('DB_USER', 'youruser_jjadmin');         // Your database user
define('DB_PASS', 'your_database_password');   // Your database password

// Site Configuration
define('BASE_URL', 'https://yourdomain.com');  // Your domain (no trailing slash)
define('SITE_NAME', 'JJ Jewelry & Co');
```

4. **Important**: Set error reporting for production:

```php
// Error Reporting (set to 0 in production)
error_reporting(0);
ini_set('display_errors', 0);
```

5. **Save the file**

### Step 6: Set File Permissions

Proper permissions are crucial for security and functionality.

#### Using cPanel File Manager:

1. **Set directory permissions to 755**:
   - Select folders: `admin`, `assets`, `includes`, `sql`
   - Right-click → "Change Permissions"
   - Set to `755` (or check: Read+Execute for all, Write for owner only)

2. **Set PHP file permissions to 644**:
   - Select all `.php` files
   - Right-click → "Change Permissions"
   - Set to `644`

3. **Set upload directory to 755** (must be writable):
   - Navigate to `assets/uploads/products/`
   - If folder doesn't exist, create it: New Folder → `products`
   - Right-click on `products` folder → "Change Permissions"
   - Set to `755` (or check: Owner: Read+Write+Execute, Group/Public: Read+Execute)

#### Via SSH (if available):

```bash
cd public_html
chmod 755 admin assets includes sql
chmod 644 *.php admin/*.php
chmod 755 assets/uploads/products
```

### Step 7: Verify Installation

1. **Visit your website**: `https://yourdomain.com`
   - You should see the JJ Jewelry & Co homepage
   - Sample products should be visible
   - If you see errors, check:
     - Database connection details in `config.php`
     - Database tables were imported correctly
     - File permissions are correct

2. **Test the shop**:
   - Click "Shop" in navigation
   - Filter by categories
   - View a product detail page
   - Add item to cart
   - View cart

3. **Access admin panel**: `https://yourdomain.com/admin/`
   - Login with default credentials:
     - **Username**: `admin`
     - **Password**: `changeme123`
   - **IMMEDIATELY CHANGE PASSWORD** after first login

### Step 8: Configure Site Settings (Important!)

1. **Log in to admin panel**
2. **Navigate to "Settings"**
3. **Update Store Information**:
   - Store name (if different)
   - Store email (your real email)
   - Store phone number

4. **Configure Bank Details for EFT Payments**:
   - Bank name
   - Account holder name
   - Account number
   - Branch code
   - Account type
   - **Save Settings**

5. **Optional: Configure PayFast** (if using online payments):
   - Sign up at https://www.payfast.co.za
   - Get credentials from PayFast dashboard
   - Enter Merchant ID, Merchant Key, Passphrase
   - Set Sandbox Mode to OFF for live payments
   - **Save Settings**

### Step 9: Security Hardening (Critical!)

1. **Change admin password**:
   - Currently, you need to do this via database
   - Generate a new password hash:
   ```php
   <?php echo password_hash('YourNewSecurePassword', PASSWORD_DEFAULT); ?>
   ```
   - Update in phpMyAdmin: `admin_users` table → `password` field

2. **Delete `config.example.php`**:
   - This prevents exposing your configuration structure

3. **Protect sensitive files** (optional but recommended):
   - Create `.htaccess` in root with:
   ```apache
   <Files "config.php">
       Require all denied
   </Files>
   ```

4. **Enable HTTPS**:
   - In cPanel, use "SSL/TLS Status" to enable AutoSSL (free)
   - Or install Let's Encrypt certificate
   - Update `BASE_URL` in `config.php` to use `https://`

5. **Set up regular backups**:
   - Use cPanel's Backup feature
   - Schedule automatic database backups

### Step 10: Test Complete Workflow

1. **Place a test order**:
   - Browse products as a customer
   - Add items to cart
   - Complete checkout with test information
   - Verify order confirmation page displays bank details

2. **Manage order in admin**:
   - Log in to admin panel
   - View the test order in "Orders"
   - Update order status
   - Add admin notes

3. **Test product management**:
   - Create a new product
   - Upload a product image
   - Edit an existing product
   - Mark a product as featured
   - Deactivate a product

## Document Root Configuration

### If your document root is NOT public_html:

Some cPanel setups use different document roots. Check with your host:

- Common alternatives: `www`, `htdocs`, `public`, `html`
- For addon domains: May be in a subdirectory

**To change document root**:
1. cPanel → Domains → Domain Management
2. Select your domain → Edit
3. Update "Document Root" if needed

### Using a subdirectory:

If you want the shop in a subdirectory (e.g., `yourdomain.com/shop`):

1. Upload files to `public_html/shop/` instead of `public_html/`
2. Update `BASE_URL` in `config.php`:
   ```php
   define('BASE_URL', 'https://yourdomain.com/shop');
   ```

## Troubleshooting

### Database Connection Errors

**Error**: "Database connection failed"

**Solutions**:
- Verify database credentials in `config.php`
- Check database user has privileges (cPanel → MySQL Databases)
- Confirm database host is `localhost` (usually correct)
- Check database server is running (contact host if issue persists)

### White Screen / Blank Page

**Solutions**:
- Enable error display temporarily in `config.php`:
  ```php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ```
- Check PHP version (must be 8.0+): cPanel → MultiPHP Manager
- Check PHP error log: cPanel → Errors
- Verify all files uploaded correctly

### Image Upload Not Working

**Solutions**:
- Check `assets/uploads/products/` folder exists
- Verify folder permissions are `755`
- Check PHP `upload_max_filesize`: cPanel → MultiPHP INI Editor
- Increase if needed (minimum 5MB recommended)

### Can't Access Admin Panel

**Solutions**:
- Clear browser cache and cookies
- Try incognito/private mode
- Verify `admin` folder uploaded correctly
- Check `.htaccess` not blocking admin directory

### "File not found" or 404 Errors

**Solutions**:
- Verify `BASE_URL` in `config.php` matches your actual domain
- Check files are in correct location (document root)
- Ensure .php extension not hidden by URL rewriting
- Check cPanel error logs for clues

### Session/Cart Issues

**Solutions**:
- Check PHP sessions are enabled: cPanel → PHP Configuration
- Verify session directory is writable
- Clear browser cookies
- Check `session.save_path` in PHP settings

## Performance Optimization (Optional)

### Enable PHP OPcache:
- cPanel → MultiPHP INI Editor
- Enable OPcache (improves performance)

### Enable Gzip Compression:
Add to `.htaccess` in root:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### Browser Caching:
Add to `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## Maintenance

### Regular Tasks:
- **Daily**: Check for new orders
- **Weekly**: Backup database
- **Monthly**: Review product inventory
- **Quarterly**: Update PHP version (if new version available)

### Monitoring:
- Check cPanel error logs regularly
- Monitor disk space usage
- Review failed login attempts (security)

## Support

For technical issues with the application:
- Review error logs in cPanel
- Check database connection settings
- Verify file permissions
- Consult README.md for configuration details

For hosting-specific issues:
- Contact your hosting provider's support
- Provide error messages from cPanel logs

---

## Quick Checklist

- [ ] MySQL database created
- [ ] Database user created with privileges
- [ ] Schema and seed SQL imported
- [ ] Files uploaded to document root
- [ ] config.php created and configured
- [ ] BASE_URL set correctly
- [ ] File permissions set (755 for folders, 644 for files)
- [ ] Upload folder writable (755)
- [ ] Website loads successfully
- [ ] Admin panel accessible
- [ ] Admin password changed
- [ ] Store information updated
- [ ] Bank details configured
- [ ] Test order placed successfully
- [ ] HTTPS enabled
- [ ] Backups configured

**Congratulations!** Your JJ Jewelry & Co shop is now live and ready to accept orders.
