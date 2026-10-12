<?php
$pageTitle = 'Terms of Service';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0; max-width: 800px; margin: 0 auto;">
        <h1>Terms of Service</h1>
        <p style="color: var(--color-text-light); margin-bottom: var(--spacing-lg);">
            Last updated: <?= date('F Y') ?>
        </p>
        
        <div style="line-height: 1.8;">
            <h2>Agreement to Terms</h2>
            <p>
                By accessing and using the SS Jewellery website, you agree to be bound by these 
                Terms of Service. If you do not agree to these terms, please do not use our website 
                or services.
            </p>
            
            <h2>Products and Pricing</h2>
            <h3>Product Information</h3>
            <p>
                We strive to provide accurate descriptions and images of our products. However, we 
                cannot guarantee that product descriptions, images, or other content is entirely 
                accurate, complete, or current.
            </p>
            
            <h3>Pricing</h3>
            <p>
                All prices are listed in South African Rand (ZAR) and include VAT where applicable. 
                We reserve the right to change prices at any time without notice. The price applicable 
                to your order is the price displayed at the time of purchase.
            </p>
            
            <h2>Orders and Payment</h2>
            <h3>Order Acceptance</h3>
            <p>
                Your order is an offer to purchase products from us. We reserve the right to accept 
                or decline your order for any reason, including product availability, errors in pricing 
                or product information, or suspected fraudulent activity.
            </p>
            
            <h3>Payment Methods</h3>
            <p>
                We accept EFT/bank transfer and online payments via PayFast. Payment must be received 
                before your order is processed for shipping.
            </p>
            
            <h3>Payment Terms</h3>
            <p>
                For EFT payments, orders are held for 5 business days pending payment confirmation. 
                Unpaid orders will be automatically cancelled after this period.
            </p>
            
            <h2>Shipping and Delivery</h2>
            <p>
                We ship within South Africa only. Shipping times vary based on location and courier 
                availability. We are not responsible for delays caused by courier services or customs.
            </p>
            
            <h3>Risk of Loss</h3>
            <p>
                All items purchased from SS Jewellery are shipped with insurance. Risk of loss and 
                title for purchased items pass to you upon delivery to the shipping carrier.
            </p>
            
            <h2>Returns and Refunds</h2>
            <h3>Return Policy</h3>
            <p>
                Due to the nature of our products (high-value diamonds and jewelry), all sales are final. 
                Returns are only accepted in cases of:
            </p>
            <ul>
                <li>Damaged items received</li>
                <li>Incorrect items shipped</li>
                <li>Significant discrepancies from product description</li>
            </ul>
            
            <h3>Return Process</h3>
            <p>
                To initiate a return, contact us within 48 hours of receiving your order. Returns must 
                be in original condition with all documentation and packaging. Return shipping must be 
                insured and tracked.
            </p>
            
            <h2>Product Authenticity</h2>
            <p>
                All diamonds sold by SS Jewellery are genuine and natural unless otherwise specified. 
                Polished diamonds come with certification from recognized gemological institutes. We 
                guarantee the authenticity of all products sold.
            </p>
            
            <h2>Limitation of Liability</h2>
            <p>
                To the fullest extent permitted by law, SS Jewellery shall not be liable for any 
                indirect, incidental, special, consequential, or punitive damages arising from your use 
                of our website or products.
            </p>
            
            <h2>Intellectual Property</h2>
            <p>
                All content on this website, including text, images, logos, and designs, is the property 
                of SS Jewellery and is protected by copyright and trademark laws. Unauthorized use 
                is prohibited.
            </p>
            
            <h2>Privacy</h2>
            <p>
                Your use of our website is also governed by our Privacy Policy. Please review our 
                <a href="<?= BASE_URL ?>/privacy.php">Privacy Policy</a> to understand our practices.
            </p>
            
            <h2>Governing Law</h2>
            <p>
                These Terms of Service are governed by the laws of South Africa. Any disputes shall be 
                resolved in the courts of South Africa.
            </p>
            
            <h2>Changes to Terms</h2>
            <p>
                We reserve the right to modify these terms at any time. Changes will be effective 
                immediately upon posting to the website. Your continued use of the website constitutes 
                acceptance of the modified terms.
            </p>
            
            <h2>Contact Information</h2>
            <p>
                For questions about these Terms of Service, please contact us at:
            </p>
            <p>
                <strong>Email:</strong> <?= e(getSetting('store_email', 'info@ssjewellery.store')) ?><br>
                <strong>Phone:</strong> <?= e(getSetting('store_phone', '+27 11 123 4567')) ?>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
