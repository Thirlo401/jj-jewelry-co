# SS Jewellery Deployment Guide

This guide covers deploying the updated SS Jewellery shop to cPanel hosting.

## Overview of Changes

This update transforms the shop from "JJ Jewelry & Co" to "SS Jewellery" with the following major changes:

1. **Brand Update**: All references changed from JJ Jewelry to SS Jewellery
2. **Jewellery-Only Public Catalogue**: Shop now shows only jewellery categories (rings, earrings, bracelets, necklaces, pendants)
3. **Diamond Request System**: Polished and rough diamonds available via inquiry form only (not in public shop)
4. **Hero Background Image**: Admin can upload custom background image for homepage hero section
5. **BYL Jewellery Import**: ~60 new jewellery products with images, priced at +15% markup (ZAR)

## Pre-Deployment Checklist

- [ ] Backup existing database
- [ ] Backup existing files (especially `assets/uploads/products/`)
- [ ] Review `scripts/byl-jewellery-price-sheet.txt` to verify pricing
- [ ] Test on staging environment if available

## Deployment Steps

### Step 1: Database Migration

Run the migration SQL to update the schema for existing databases:

```bash
sql/migration-jewellery-categories.sql
```

This will:
- Add new jewellery categories to products table
- Create `diamond_requests` table
- Add `hero_background_image` setting

**Via cPanel phpMyAdmin:**
1. Log into cPanel → phpMyAdmin
2. Select your database
3. Click "SQL" tab
4. Paste contents of `migration-jewellery-categories.sql`
5. Click "Go"

### Step 2: Upload Files

Upload the following files/folders via cPanel File Manager or FTP:

#### Core Application Files
```
/workspace/
├── index.php                           (updated homepage)
├── shop.php                           (updated with jewellery filters)
├── request-diamond.php                (NEW - diamond inquiry form)
├── includes/
│   ├── header.php                     (brand update)
│   ├── footer.php                     (updated navigation)
│   └── helpers.php                    (new category functions)
├── assets/
│   └── css/
│       └── style.css                  (hero background image support)
├── admin/
│   ├── settings.php                   (hero image upload)
│   ├── product-edit.php               (new categories)
│   ├── diamond-requests.php           (NEW)
│   └── diamond-request-detail.php     (NEW)
```

#### Product Images
Upload all images from `assets/uploads/products/` to the server:
```
assets/uploads/products/byl_*.jpg
```
**Total:** ~60 images (~7MB total size)

**Important:** Ensure the `assets/uploads/products/` directory has write permissions (755 or 775).

### Step 3: Import BYL Jewellery Products

Run the import SQL to add the 60 new jewellery products:

```bash
sql/import-byl-jewellery.sql
```

**Via cPanel phpMyAdmin:**
1. Log into cPanel → phpMyAdmin
2. Select your database
3. Click "SQL" tab
4. Paste contents of `import-byl-jewellery.sql`
5. Click "Go"

**Verify:**
- Check that 60 products were imported
- Verify pricing (all prices should be BYL wholesale + 15%)
- Confirm images are displaying correctly

### Step 4: Update Site Settings

Log into the admin panel (`/admin/`) and update:

1. **Store Information** (Admin → Settings):
   - Store Name: `SS Jewellery`
   - Store Email: `info@ssjewellery.store`
   - Update bank details if needed

2. **Hero Background Image** (Admin → Settings):
   - Upload a high-quality background image (recommended: 1920x1080px or larger)
   - JPEG or PNG format
   - The image will have a dark overlay for text readability

3. **Test Diamond Requests**:
   - Visit `/request-diamond.php`
   - Submit a test request
   - Verify it appears in Admin → Diamond Requests

### Step 5: Post-Deployment Verification

#### Public Site Checks
- [ ] Homepage loads with new SS Jewellery branding
- [ ] Hero section displays with background image (if uploaded)
- [ ] Collection cards show 5 jewellery categories + "Request a Diamond"
- [ ] Shop page filters show: All Jewellery, Rings, Earrings, Bracelets, Necklaces, Pendants
- [ ] No diamond products visible in public shop
- [ ] Featured products only show jewellery items
- [ ] Footer links updated to jewellery categories
- [ ] Request a Diamond form works and submits successfully

#### Admin Panel Checks
- [ ] Login to admin panel works
- [ ] Admin → Products shows new BYL products
- [ ] Product categories dropdown includes new jewellery categories
- [ ] Admin → Diamond Requests page loads
- [ ] Admin → Settings has hero image upload field
- [ ] Can upload/replace hero background image

#### Database Checks
- [ ] Run: `SELECT COUNT(*) FROM products WHERE sku LIKE 'BYL-JW-%'` → Should return 60
- [ ] Run: `SELECT COUNT(*) FROM diamond_requests` → Should return 0 (or test requests)
- [ ] Verify `settings` table has `hero_background_image` row

## Troubleshooting

### Issue: Images not displaying

**Solution:**
1. Verify images uploaded to `/assets/uploads/products/`
2. Check directory permissions: `chmod 755 assets/uploads/products`
3. Check file permissions: `chmod 644 assets/uploads/products/*.jpg`

### Issue: Diamond request form doesn't submit

**Solution:**
1. Verify `diamond_requests` table exists
2. Check server error logs for PHP errors
3. Ensure mail() function is enabled (for email notifications)

### Issue: Products imported but images missing

**Solution:**
1. Re-upload images from `assets/uploads/products/`
2. Verify image filenames match those in database
3. Check that image paths in products table are correct (just filename, not full path)

### Issue: Hero background image not showing

**Solution:**
1. Upload image via Admin → Settings → Hero Background Image
2. Verify image uploaded to `assets/uploads/products/`
3. Check CSS is updated (`assets/css/style.css`)
4. Clear browser cache

## Rollback Procedure

If you need to rollback:

1. **Restore Database Backup**
   - Import your pre-deployment database backup via phpMyAdmin

2. **Restore Files**
   - Replace updated files with your backup copies
   - Keep new product images if desired

3. **Clean Up** (optional)
   - Remove `diamond_requests` table if not needed
   - Remove BYL product images from `assets/uploads/products/byl_*`

## File Checksums (for verification)

Key files that changed:

```
index.php                    - Homepage with hero image support
shop.php                     - Jewellery-only filters
request-diamond.php          - NEW diamond inquiry form
includes/header.php          - SS Jewellery branding
includes/footer.php          - Updated navigation
includes/helpers.php         - New category helpers
assets/css/style.css         - Hero background image CSS
admin/settings.php           - Hero image upload
admin/product-edit.php       - New category options
admin/diamond-requests.php   - NEW admin page
```

## Performance Notes

- Total new images: ~60 files (~7MB)
- New database rows: 60 products + 1 diamond_requests table
- No performance impact expected
- Page load times should remain unchanged

## Support

For issues or questions:
- Review error logs: cPanel → Error Logs
- Check PHP version: Requires PHP 7.4+
- Database: MySQL 5.7+ or MariaDB 10.2+

## Post-Deployment Tasks

After successful deployment:

1. **Update DNS** (if domain changed)
   - Point domain to: `ssjewellery.store`

2. **SSL Certificate**
   - Install/update SSL certificate via cPanel

3. **Email Configuration**
   - Update email addresses in Admin → Settings
   - Test diamond request email notifications

4. **Content Updates**
   - Review About page content
   - Update Contact page if needed
   - Consider adding privacy policy updates

5. **SEO**
   - Update meta titles/descriptions for new brand
   - Submit updated sitemap to Google Search Console
   - Update Google My Business if applicable

## Security Reminders

- [ ] Change default admin password after deployment
- [ ] Review file permissions (files: 644, directories: 755)
- [ ] Keep cPanel credentials secure
- [ ] Regular database backups enabled
- [ ] Update `.htaccess` if needed for security headers

## Next Steps

Consider these future enhancements:
- Add more product images for BYL jewellery
- Feature select BYL products on homepage
- Add customer testimonials
- Implement product reviews
- Add wishlist functionality
- Create jewellery care guide pages
