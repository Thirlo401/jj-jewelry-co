# Pull Request: Transform to SS Jewellery

**Branch**: `cursor/ss-jewellery-updates-5e41`  
**Base**: `main`  
**Type**: Draft PR (mark ready when deployed and tested)

---

## Overview

This PR transforms the shop from "JJ Jewelry & Co" to **SS Jewellery** (ssjewellery.store) with major business model changes:

### Key Changes

✅ **Rebranded to SS Jewellery** throughout entire codebase  
✅ **Public shop is jewellery-only**: Rings, Earrings, Bracelets, Necklaces, Pendants  
✅ **Diamonds hidden from public** - available via request form only  
✅ **Diamond request system** with admin management pages  
✅ **Hero background image** support (admin-uploadable)  
✅ **60 BYL jewellery products** imported with 15% markup (ZAR pricing)

---

## Business Requirements Implemented

### 1. Jewellery-Only Public Catalogue ✅
- Shop filters show only: Rings, Earrings, Bracelets, Necklaces, Pendants
- Featured products filtered to jewellery only
- Homepage collection cards updated to jewellery categories
- Footer navigation updated with jewellery links

### 2. Diamond Request System ✅
- New `/request-diamond.php` page for diamond inquiries
- Form fields: type (polished/rough), shape, carat range, color/clarity, budget, contact info
- Admin pages: `diamond-requests.php` and `diamond-request-detail.php`
- Email notifications to store owner
- Status tracking: new, in_progress, quoted, completed, cancelled

### 3. Hero Background Image ✅
- Admin can upload custom background image via Settings
- Dark overlay for text readability
- Fallback to elegant gradient if no image set
- Responsive and mobile-friendly

### 4. BYL Jewellery Import ✅
- CSV import script (`scripts/import-byl-jewellery.py`)
- Auto-downloads 60 product images (~7MB)
- Applies 15% markup to ZAR wholesale prices
- Generates SQL with `ON DUPLICATE KEY UPDATE` for safe re-imports
- Price sheet included for reference

---

## Database Changes

### New Schema Elements
- **Products categories expanded**: Added `rings`, `earrings`, `bracelets`, `necklaces`, `pendants`
- **New table**: `diamond_requests` for customer diamond inquiries
- **New setting**: `hero_background_image` for homepage customization

### Migration Provided
- `sql/migration-jewellery-categories.sql` - Safe migration for existing databases
- Preserves all existing data (rough_diamonds, polished_diamonds still valid)
- Can be run multiple times safely

---

## Files Changed

### Core Application
- `index.php` - Homepage with jewellery focus, hero image support
- `shop.php` - Jewellery-only filters
- `request-diamond.php` - **NEW** diamond inquiry form
- `includes/header.php` - SS Jewellery branding
- `includes/footer.php` - Updated navigation
- `includes/helpers.php` - New category helper functions

### Admin Panel
- `admin/settings.php` - Hero image upload field
- `admin/product-edit.php` - New jewellery category options
- `admin/diamond-requests.php` - **NEW** request management
- `admin/diamond-request-detail.php` - **NEW** request detail view

### Import System
- `scripts/import-byl-jewellery.py` - Python CSV import script
- `scripts/byl-jewellery-price-sheet.txt` - Price reference (generated)
- `sql/import-byl-jewellery.sql` - 60 BYL products (generated)

### Documentation
- `DEPLOYMENT-GUIDE.md` - **NEW** Complete deployment instructions
- `README.md` - Updated with new features

---

## Deployment Instructions

**⚠️ IMPORTANT: Follow deployment guide carefully**

See `DEPLOYMENT-GUIDE.md` for complete step-by-step instructions.

### Quick Deployment Steps

1. **Backup existing database and files**
2. **Run migration SQL**: `sql/migration-jewellery-categories.sql`
3. **Upload updated files** to cPanel/FTP
4. **Upload product images** from `assets/uploads/products/` (~60 files, 7MB)
5. **Import BYL products**: `sql/import-byl-jewellery.sql`
6. **Update site settings** in admin panel (store name, email, hero image)
7. **Test** diamond request form and admin pages

### Files to Upload via cPanel/FTP
```
✓ All PHP files (index.php, shop.php, request-diamond.php, admin/*, includes/*)
✓ CSS (assets/css/style.css)
✓ Product images (assets/uploads/products/byl_*.jpg) - 60 files
```

### SQL to Run on cPanel
```sql
1. sql/migration-jewellery-categories.sql
2. sql/import-byl-jewellery.sql
```

---

## Testing Checklist

### Public Site
- [ ] Homepage loads with SS Jewellery branding
- [ ] Hero displays with background image (after upload in admin)
- [ ] Collection cards show 5 jewellery categories + "Request a Diamond"
- [ ] Shop filters: All Jewellery, Rings, Earrings, Bracelets, Necklaces, Pendants
- [ ] No diamond products visible in public shop
- [ ] Request a Diamond form submits successfully
- [ ] Footer navigation shows jewellery categories

### Admin Panel  
- [ ] Products list shows BYL products (60 items)
- [ ] Category dropdown includes all jewellery categories
- [ ] Diamond Requests page loads and shows submitted requests
- [ ] Settings page has hero image upload field
- [ ] Can upload/replace hero background image

### Database
- [ ] Migration runs without errors
- [ ] 60 BYL products imported successfully
- [ ] `diamond_requests` table created
- [ ] `hero_background_image` setting exists

---

## Import Summary

### BYL Jewellery Products
- **Total Products**: 60
- **Categories**: 12 Rings, 12 Earrings, 12 Bracelets, 12 Pendants, 12 Necklaces
- **Pricing**: BYL wholesale + 15% markup (ZAR, no USD conversion)
- **Images**: Downloaded automatically during import
- **Price Range**: R 17,273 - R 183,636

### Sample Products
- Round Brilliant Half Eternity Diamond Ring - R 17,273
- Round Brilliant Diamond Hoop Earrings - R 36,582
- Round Brilliant Cut Diamond Bracelet - R 17,699
- Fancy Intense Yellow Multi Shaped Diamond Pendant - R 142,221
- Round Brilliant Diamond Tennis Necklace - R 62,399

---

## Technical Notes

- **PHP Version**: 7.4+ required
- **Database**: MySQL 5.7+ or MariaDB 10.2+
- **No breaking changes** to existing functionality
- **Backward compatible**: Old `jewelry` category still works
- **Performance**: No impact - same query patterns, minimal new code

---

## Security & Maintenance

- ✅ CSRF protection on all forms
- ✅ SQL injection protection (prepared statements)
- ✅ File upload validation (images only)
- ✅ XSS protection (proper escaping)
- ✅ Admin authentication required for sensitive pages

---

## Next Steps After Merge

1. Update DNS/domain settings if needed
2. Upload hero background image via Admin → Settings
3. Test diamond request email notifications
4. Consider featuring select BYL products on homepage
5. Update About/Contact pages with new branding

---

## Support & Troubleshooting

See `DEPLOYMENT-GUIDE.md` for:
- Detailed troubleshooting guide
- Rollback procedures
- Performance notes
- Security checklist

---

## Preview

| Before | After |
|--------|-------|
| JJ Jewelry & Co | SS Jewellery |
| 3 categories (rough/polished/jewelry) | 5 jewellery categories |
| Diamonds in public shop | Diamonds request-only |
| Plain gradient hero | Custom image hero |
| 7 sample products | 67 products (60 from BYL) |

---

## How to Create This PR

Since automated PR creation requires additional permissions, please create the PR manually:

1. Go to: https://github.com/Thirlo401/jj-jewelry-co/pull/new/cursor/ss-jewellery-updates-5e41
2. Copy the contents of this file (above) as the PR description
3. Set the PR as **Draft** initially
4. After deployment and testing, mark as **Ready for review**

Or use the GitHub CLI:
```bash
gh pr create --draft \
  --title "Transform to SS Jewellery: Jewellery-Only Shop with Diamond Request System" \
  --body-file PR-DESCRIPTION.md
```
