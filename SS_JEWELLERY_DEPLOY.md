# SS Jewellery & Co - Deployment Instructions

## Overview

This update converts the shop to SS Jewellery & Co with jewellery-only public filters (rings, earrings, pendants, bracelets, necklaces). Diamond inventory (rough/polished) remains in admin for management but is excluded from public shop listings.

## Pre-Deployment Checklist

1. **Backup your database** via cPanel phpMyAdmin Export
2. **Backup existing files** via cPanel File Manager or FTP
3. **Test on staging environment** if available

## Database Migration

### Step 1: Run SQL Migration

Log into cPanel → phpMyAdmin → Select your database → SQL tab

**Copy and paste this SQL:**

```sql
-- Migration: Update product categories for SS Jewellery & Co
-- Run this AFTER backing up your database

-- Step 1: Add new enum values to the category column
ALTER TABLE `products` 
MODIFY COLUMN `category` enum(
  'rough_diamonds',
  'polished_diamonds',
  'jewelry',
  'rings',
  'earrings',
  'pendants',
  'bracelets',
  'necklaces'
) NOT NULL;

-- Step 2: Migrate existing 'jewelry' products to 'rings' as default
-- Admin should manually update products to their correct categories after migration
UPDATE `products` 
SET `category` = 'rings' 
WHERE `category` = 'jewelry';

-- Step 3: Update store email setting
UPDATE `settings` 
SET `setting_value` = 'info@ssjewellery.store' 
WHERE `setting_key` = 'store_email';
```

**Important:** After running the migration, go to Admin → Products and manually recategorize each product from "rings" to the correct category (earrings, pendants, bracelets, necklaces) as needed.

### Optional: Remove Legacy 'jewelry' Category

**Only run this AFTER all products have been properly categorized:**

```sql
-- This permanently removes the old 'jewelry' enum value
-- DO NOT run until all products are recategorized!
ALTER TABLE `products` 
MODIFY COLUMN `category` enum(
  'rough_diamonds',
  'polished_diamonds',
  'rings',
  'earrings',
  'pendants',
  'bracelets',
  'necklaces'
) NOT NULL;
```

## File Upload to cPanel

### Files to Upload (Replace Existing)

Upload these files to your `public_html` directory via cPanel File Manager or FTP. **REPLACE the existing files:**

#### Core Files:
- `shop.php`
- `index.php`
- `about.php`
- `contact.php`
- `privacy.php`
- `terms.php`
- `config.example.php`
- `generate_admin_hash.php`

#### Includes Folder:
- `includes/header.php`
- `includes/footer.php`
- `includes/helpers.php`

#### Admin Folder:
- `admin/product-edit.php`

#### SQL Folder:
- `sql/schema.sql`
- `sql/seed.sql`
- `sql/migrate_to_jewellery_categories.sql` *(NEW FILE - for reference)*

### Files to Update Manually

#### config.php (Do NOT overwrite - edit existing)

**Update these lines in your existing `config.php`:**

```php
// OLD:
define('SITE_NAME', 'JJ Jewelry & Co');
define('SESSION_NAME', 'jj_jewelry_session');

// NEW:
define('SITE_NAME', 'SS Jewellery & Co');
define('SESSION_NAME', 'ss_jewellery_session');
```

Keep your existing database credentials - **do not change DB_HOST, DB_NAME, DB_USER, DB_PASS**.

## Verification Steps

After deployment, verify everything works:

### 1. Check Public Shop Page

Visit: `https://ssjewellery.store/shop.php`

**Expected filters:**
- ✓ All Jewellery
- ✓ Rings
- ✓ Earrings
- ✓ Pendants
- ✓ Bracelets
- ✓ Necklaces

**Should NOT show:**
- ✗ Rough Diamonds
- ✗ Polished Diamonds

### 2. Test Filtering

- Click each category filter (Rings, Earrings, etc.)
- Verify products display correctly
- Verify "All Jewellery" shows only jewellery categories (no diamonds)

### 3. Check Admin Panel

Visit: `https://ssjewellery.store/admin/`

**Admin → Products → Add/Edit Product:**

Category dropdown should show:
- Jewellery (Public Shop): Rings, Earrings, Pendants, Bracelets, Necklaces
- Diamonds (Request-Only): Rough Diamonds, Polished Diamonds
- Legacy: Jewelry (Generic - Please Recategorize)

### 4. Check Branding

Verify these pages show "SS Jewellery & Co":
- Header navigation
- Footer
- About page
- Contact page
- Admin panel

### 5. Test Order Numbers

Place a test order and verify order number format: `SS-YYYYMMDD-XXXXXX`

## Post-Deployment Tasks

### 1. Recategorize Products

Go to Admin → Products and update each product's category:
- Change "rings" products to their correct category (earrings, pendants, etc.)
- Ensure rough/polished diamonds are correctly categorized
- Remove or recategorize any products still marked as "jewelry"

### 2. Update Site Settings

Go to Admin → Settings and verify/update:
- Store email: `info@ssjewellery.store`
- Bank details (if EFT payments are used)
- Any diamond-related text should reference "request for quote" instead

### 3. Optional: Clean Up Legacy Category

After all products are recategorized, run the optional SQL in phpMyAdmin to remove the legacy "jewelry" enum value (see "Optional: Remove Legacy 'jewelry' Category" above).

## Rollback Plan

If issues occur, restore from backups:

1. **Database:** phpMyAdmin → Import → Select backup SQL file
2. **Files:** cPanel File Manager → Upload old files or restore from backup

## Support

If you encounter issues:
- Check error logs: cPanel → Error Log
- Verify PHP version is 8.0+
- Ensure database credentials are correct in `config.php`
- Clear browser cache if pages look incorrect

## Summary of Changes

- ✓ Shop filters now show only jewellery categories
- ✓ Rough/polished diamonds hidden from public shop
- ✓ Admin can still manage all product types
- ✓ Brand changed to SS Jewellery & Co
- ✓ Email domain changed to @ssjewellery.store
- ✓ Order prefix changed to SS-
- ✓ Database supports new jewellery categories
