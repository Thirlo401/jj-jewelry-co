# 🚨 URGENT: Brand Fix for Live Site

## Issue Identified
Live site still shows **JJ Jewelry & Co** branding instead of **SS Jewellery & Co**:
- ❌ Header displays "JJ Jewelry & Co"
- ❌ Bank account holder shows "JJ Jewelry & Co (Pty) Ltd"
- ❌ Order references use "JJ-" prefix

## Immediate Fix Required

### Step 1: Upload Updated PHP Files via cPanel File Manager
**Priority files to replace immediately:**
```
✓ config.example.php         (SS Jewellery & Co)
✓ includes/helpers.php        (SS- order prefix)
✓ includes/header.php         (SS Jewellery branding)
✓ includes/footer.php         (ssjewellery.store email)
✓ about.php                   (SS Jewellery & Co)
✓ contact.php                 (SS Jewellery & Co)
✓ privacy.php                 (SS Jewellery & Co)
✓ terms.php                   (SS Jewellery & Co)
✓ generate_admin_hash.php     (SS Jewellery & Co)
```

### Step 2: Run SQL Fix via phpMyAdmin
**File**: `sql/fix-brand-ss-jewellery.sql`

**Execute this SQL immediately:**
```sql
UPDATE `settings` SET `setting_value` = 'SS Jewellery & Co' WHERE `setting_key` = 'store_name';
UPDATE `settings` SET `setting_value` = 'info@ssjewellery.store' WHERE `setting_key` = 'store_email';
UPDATE `settings` SET `setting_value` = 'SS Jewellery & Co (Pty) Ltd' WHERE `setting_key` = 'bank_account_holder';
```

### Step 3: Verify Changes
After uploading files and running SQL:
1. **Clear browser cache** (Ctrl+Shift+R or Cmd+Shift+R)
2. **Check header** → Should show "SS Jewellery"
3. **Place test order** → Order number should start with "SS-"
4. **Check payment page** → Account holder should be "SS Jewellery & Co (Pty) Ltd"

---

## What Was Fixed

### PHP Files Updated
- ✅ **Order prefix**: `JJ-` → `SS-` in `helpers.php`
- ✅ **Site name**: All occurrences changed to "SS Jewellery & Co"
- ✅ **Email addresses**: Updated to `@ssjewellery.store`
- ✅ **Content pages**: About, Contact, Privacy, Terms all updated
- ✅ **Session name**: Changed from `jj_jewelry_session` to `ss_jewellery_session`

### Database Changes (via SQL fix)
- ✅ **store_name** setting → "SS Jewellery & Co"
- ✅ **store_email** setting → "info@ssjewellery.store"
- ✅ **bank_account_holder** → "SS Jewellery & Co (Pty) Ltd"

---

## Quick Deploy Checklist

### Via cPanel File Manager
1. ✅ Navigate to public_html (or site root)
2. ✅ Upload/replace all PHP files listed above
3. ✅ Set file permissions to 644 if needed
4. ✅ Clear any PHP/CDN cache

### Via cPanel phpMyAdmin
1. ✅ Select your database
2. ✅ Click "SQL" tab
3. ✅ Paste contents of `sql/fix-brand-ss-jewellery.sql`
4. ✅ Click "Go"
5. ✅ Verify 3 rows affected

### Test Immediately
```
✓ Homepage header shows "SS Jewellery"
✓ Footer email is info@ssjewellery.store
✓ About page says "SS Jewellery & Co"
✓ Contact page says "SS Jewellery & Co Showroom"
✓ New order numbers start with "SS-"
✓ Payment page shows "SS Jewellery & Co (Pty) Ltd"
```

---

## Rollback (if needed)
If something breaks, restore from backup:
```sql
-- Rollback settings
UPDATE `settings` SET `setting_value` = 'JJ Jewelry & Co' WHERE `setting_key` = 'store_name';
UPDATE `settings` SET `setting_value` = 'info@jjjewelry.co.za' WHERE `setting_key` = 'store_email';
UPDATE `settings` SET `setting_value` = 'JJ Jewelry & Co (Pty) Ltd' WHERE `setting_key` = 'bank_account_holder';
```

---

## Why This Happened
The previous deployment missed updating:
1. Content in about/contact/privacy/terms pages
2. Email fallback defaults in PHP
3. Database settings values (not just seed file)

This fix completes the rebrand and ensures consistent "SS Jewellery & Co" across the entire site.

---

## Estimated Downtime
**None** - These are cosmetic fixes. Site remains functional during update.

## Priority
**CRITICAL** - Affects brand consistency and customer trust.

## Contact
If issues persist after deployment, check:
- Browser cache cleared
- PHP opcache cleared (if enabled)
- CDN cache purged (if using Cloudflare/similar)
