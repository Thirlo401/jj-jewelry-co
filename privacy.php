<?php
$pageTitle = 'Privacy Policy';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0; max-width: 800px; margin: 0 auto;">
        <h1>Privacy Policy</h1>
        <p style="color: var(--color-text-light); margin-bottom: var(--spacing-lg);">
            Last updated: <?= date('F Y') ?>
        </p>
        
        <div style="line-height: 1.8;">
            <h2>Introduction</h2>
            <p>
                SS Jewellery & Co ("we", "our", "us") respects your privacy and is committed to protecting 
                your personal information. This Privacy Policy explains how we collect, use, disclose, 
                and safeguard your information when you visit our website and make purchases.
            </p>
            
            <h2>Information We Collect</h2>
            <h3>Personal Information</h3>
            <p>When you place an order or contact us, we may collect:</p>
            <ul>
                <li>Name and contact information (email, phone number)</li>
                <li>Shipping and billing address</li>
                <li>Payment information (processed securely through payment providers)</li>
                <li>Order history and preferences</li>
            </ul>
            
            <h3>Automatically Collected Information</h3>
            <p>We may automatically collect certain information when you visit our website:</p>
            <ul>
                <li>IP address and browser type</li>
                <li>Device information</li>
                <li>Pages visited and time spent on our site</li>
                <li>Referring website addresses</li>
            </ul>
            
            <h2>How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Process and fulfill your orders</li>
                <li>Communicate with you about your orders</li>
                <li>Improve our website and services</li>
                <li>Send marketing communications (with your consent)</li>
                <li>Comply with legal obligations</li>
                <li>Prevent fraud and enhance security</li>
            </ul>
            
            <h2>Information Sharing</h2>
            <p>
                We do not sell, trade, or rent your personal information to third parties. We may share 
                information with:
            </p>
            <ul>
                <li>Payment processors to handle transactions</li>
                <li>Shipping companies to deliver your orders</li>
                <li>Service providers who assist in operating our website</li>
                <li>Law enforcement when required by law</li>
            </ul>
            
            <h2>Data Security</h2>
            <p>
                We implement appropriate technical and organizational security measures to protect your 
                personal information. However, no method of transmission over the Internet is 100% secure, 
                and we cannot guarantee absolute security.
            </p>
            
            <h2>Your Rights</h2>
            <p>Under the Protection of Personal Information Act (POPIA), you have the right to:</p>
            <ul>
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your information</li>
                <li>Object to processing of your information</li>
                <li>Withdraw consent for marketing communications</li>
            </ul>
            
            <h2>Cookies</h2>
            <p>
                We use cookies to enhance your browsing experience and remember your preferences. 
                You can control cookies through your browser settings.
            </p>
            
            <h2>Contact Us</h2>
            <p>
                If you have questions about this Privacy Policy or wish to exercise your rights, 
                please contact us at:
            </p>
            <p>
                <strong>Email:</strong> <?= e(getSetting('store_email', 'info@ssjewellery.store')) ?><br>
                <strong>Phone:</strong> <?= e(getSetting('store_phone', '+27 11 123 4567')) ?>
            </p>
            
            <h2>Changes to This Policy</h2>
            <p>
                We may update this Privacy Policy from time to time. We will notify you of any changes 
                by posting the new policy on this page with an updated "Last updated" date.
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
