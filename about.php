<?php
$pageTitle = 'About Us';
$pageDescription = 'Learn about SS Jewellery & Co, South Africa\'s premier destination for exquisite fine jewellery.';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0; max-width: 800px; margin: 0 auto;">
        <h1>About SS Jewellery & Co</h1>
        
        <div style="margin: var(--spacing-lg) 0; line-height: 1.8;">
            <h2>Our Story</h2>
            <p>
                SS Jewellery & Co has been a trusted name in the South African fine jewellery industry, 
                offering exceptional quality rough diamonds, expertly cut polished diamonds, and exquisite 
                fine jewelry to discerning collectors and jewelry enthusiasts.
            </p>
            
            <h2>Our Commitment</h2>
            <p>
                We are committed to sourcing only the finest diamonds from ethical suppliers and crafting 
                jewelry pieces that embody timeless elegance and exceptional craftsmanship. Every diamond 
                in our collection is carefully selected for its quality, clarity, and brilliance.
            </p>
            
            <h3>Quality Assurance</h3>
            <p>
                All our polished diamonds come with certification from internationally recognized gemological 
                institutes, ensuring authenticity and quality. Our rough diamonds are sourced from reputable 
                mines with full traceability.
            </p>
            
            <h3>Expert Craftsmanship</h3>
            <p>
                Our jewelry pieces are created by master craftsmen who bring decades of experience to every 
                design. From classic solitaires to bespoke custom creations, each piece is made with meticulous 
                attention to detail.
            </p>
            
            <h2>Why Choose Us</h2>
            <ul style="margin: var(--spacing-md) 0 var(--spacing-md) var(--spacing-lg);">
                <li>Ethically sourced diamonds from reputable suppliers</li>
                <li>Certified polished diamonds with GIA and EGL documentation</li>
                <li>Expert guidance for collectors and investors</li>
                <li>Custom jewelry design services</li>
                <li>Competitive pricing with transparent valuations</li>
                <li>Secure nationwide shipping across South Africa</li>
            </ul>
            
            <h2>Visit Us</h2>
            <p>
                We welcome appointments to view our collection in person. Contact us to schedule a private 
                consultation with one of our diamond specialists.
            </p>
        </div>
        
        <div style="text-align: center; margin-top: var(--spacing-xl);">
            <a href="<?= BASE_URL ?>/contact.php" class="btn btn-primary">Get In Touch</a>
            <a href="<?= BASE_URL ?>/shop.php" class="btn btn-outline">Browse Our Collection</a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
