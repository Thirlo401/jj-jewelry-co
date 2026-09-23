# SS Jewellery - E-commerce Platform

A complete, production-ready online shop for selling fine jewellery. Built for standard cPanel hosting with PHP and MySQL.

**Brand**: SS Jewellery (ssjewellery.store)

## Features

### Customer-Facing Features
- **Elegant Storefront**: Modern, mobile-responsive design with high-end jewellery aesthetic
- **Product Categories**: Rings, Earrings, Bracelets, Necklaces, and Pendants
- **Diamond Requests**: Dedicated inquiry form for polished and rough diamonds (admin-only inventory)
- **Product Filtering**: Browse by jewellery category with multiple sorting options
- **Detailed Product Pages**: Complete specifications including carat weight, cut, clarity, and color
- **Shopping Cart**: Session-based cart with quantity management
- **Secure Checkout**: Customer information capture with validation
- **Multiple Payment Options**:
  - EFT/Bank Transfer (primary method)
  - PayFast integration (configurable)
- **Order Confirmation**: Professional thank-you page with bank details for EFT payments

### Admin Panel Features
- **Secure Login**: Password-hashed authentication
- **Dashboard**: Real-time statistics and recent orders overview
- **Product Management**: 
  - Full CRUD operations
  - Image upload and management
  - SKU, pricing, stock tracking
  - Diamond specifications (carat, cut, clarity, color)
  - Featured product flags
  - Active/inactive status
- **Order Management**:
  - View all orders with filtering by status
  - Detailed order information
  - Customer details and shipping address
  - Update order status (pending, paid, processing, shipped, cancelled)
  - Admin notes for internal tracking
- **Site Settings**:
  - Store information configuration
  - Bank details for EFT payments
  - PayFast API credentials
  - Sandbox mode toggle

### Technical Features
- **Security**:
  - Prepared SQL statements (PDO)
  - CSRF protection on all forms
  - Password hashing (bcrypt)
  - Secure session handling
  - Input validation and sanitization
  - File upload validation (images only)
- **Database**: MySQL with foreign key constraints
- **Sessions**: Secure session management for cart and admin authentication
- **Responsive Design**: Mobile-first CSS with elegant typography
- **Clean Code**: Object-oriented PHP with separation of concerns

## Technology Stack

- **PHP 8.x**: Server-side logic (compatible with PHP 8.0+)
- **MySQL**: Database (via PDO)
- **HTML5/CSS3**: Modern, hand-crafted frontend
- **Vanilla JavaScript**: Minimal client-side interactivity

## Project Structure

```
workspace/
├── admin/                   # Admin panel
│   ├── index.php           # Dashboard
│   ├── login.php           # Admin login
│   ├── logout.php          # Logout handler
│   ├── products.php        # Product list
│   ├── product-edit.php    # Product create/edit
│   ├── orders.php          # Orders list
│   ├── order-detail.php    # Order details
│   ├── settings.php        # Site settings
│   ├── header.php          # Admin header
│   └── footer.php          # Admin footer
├── assets/
│   ├── css/
│   │   └── style.css       # Main stylesheet
│   └── uploads/
│       └── products/       # Product images (created on upload)
├── includes/
│   ├── auth.php            # Authentication functions
│   ├── db.php              # Database connection
│   ├── footer.php          # Public footer
│   ├── header.php          # Public header
│   ├── helpers.php         # Helper functions
│   └── session.php         # Session management
├── sql/
│   ├── schema.sql          # Database schema
│   └── seed.sql            # Sample data
├── about.php               # About page
├── cart.php                # Shopping cart
├── checkout.php            # Checkout process
├── config.example.php      # Configuration template
├── contact.php             # Contact page
├── index.php               # Homepage
├── privacy.php             # Privacy policy
├── product.php             # Product detail page
├── shop.php                # Shop/product listing
├── terms.php               # Terms of service
├── thank-you.php           # Order confirmation
├── DEPLOY.md               # Deployment instructions
└── README.md               # This file
```

## Requirements

- **Hosting**: cPanel with PHP support
- **PHP**: 8.0 or higher
- **MySQL**: 5.7+ or MariaDB 10.2+
- **PHP Extensions**: PDO, PDO_MySQL, GD or Imagick (for image handling)
- **Storage**: Minimum 100MB for uploads

## Quick Start

See [DEPLOY.md](DEPLOY.md) for detailed deployment instructions.

1. Upload all files to your cPanel `public_html` directory
2. Create MySQL database and user via cPanel
3. Import `sql/schema.sql` and `sql/seed.sql`
4. Copy `config.example.php` to `config.php` and configure
5. Set folder permissions for `assets/uploads/products/` to 755
6. Access your site and test

## Default Admin Credentials

**Username**: `admin`  
**Password**: `changeme123`

**⚠️ IMPORTANT**: Change these credentials immediately after first login!

## Configuration

Edit `config.php` to set:

- Database credentials (host, name, username, password)
- Base URL (your domain)
- Upload directory settings
- Timezone (default: Africa/Johannesburg)

## Product Seeding

The `sql/seed.sql` file includes:
- 18 sample products across all categories
- Default admin user
- Default site settings with placeholder bank details

## Security Notes

1. **Change default admin password** on first login
2. **Update bank details** in Admin → Settings
3. **Configure real PayFast credentials** if using online payments (or leave empty for EFT only)
4. **Never commit** `config.php` with real credentials
5. **Set proper file permissions**: 644 for PHP files, 755 for directories, 755 for uploads folder
6. **Enable HTTPS** on your domain for production use
7. **Disable error display** in production: Set `display_errors = 0` in config.php

## Payment Methods

### EFT/Bank Transfer (Primary)
Configure your bank details in Admin → Settings. Customers will see these details on the order confirmation page with instructions to use the order number as payment reference.

### PayFast (Optional)
To enable PayFast:
1. Sign up at https://www.payfast.co.za
2. Get your Merchant ID, Merchant Key, and Passphrase
3. Add credentials in Admin → Settings
4. Set Sandbox Mode to OFF for live payments

## Customization

### Branding
- Update `SITE_NAME` in `config.php`
- Modify color scheme in `assets/css/style.css` (CSS variables at top)
- Add logo image by editing `includes/header.php`

### Product Categories
Categories are defined in the database schema as ENUM. To add/modify categories, update:
1. Database: `products` table `category` column
2. Code: `includes/helpers.php` → `getCategoryName()` function
3. Forms: Admin product edit form and shop filters

## Support & Maintenance

### Backup
Regular backups recommended:
- Database: Use cPanel phpMyAdmin export
- Files: Download via FTP/File Manager
- Backup schedule: Daily for database, weekly for files

### Updates
- Keep PHP version updated
- Monitor error logs in cPanel
- Review order notifications regularly

## Browser Support

- Chrome/Edge (last 2 versions)
- Firefox (last 2 versions)
- Safari (last 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## License

Proprietary - All rights reserved by JJ Jewelry & Co

---

**Built for cPanel Hosting** | **No Node.js Required** | **Production Ready**
