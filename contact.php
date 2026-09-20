<?php
$pageTitle = 'Contact Us';
$pageDescription = 'Get in touch with JJ Jewelry & Co for inquiries about our diamonds and jewelry collection.';
require_once __DIR__ . '/includes/header.php';

$storeEmail = getSetting('store_email', 'info@jjjewelry.co.za');
$storePhone = getSetting('store_phone', '+27 11 123 4567');
?>

<div class="container">
    <div style="padding: var(--spacing-xl) 0;">
        <h1 style="text-align: center;">Contact Us</h1>
        <p style="text-align: center; color: var(--color-text-light); font-size: 1.125rem; max-width: 600px; margin: var(--spacing-md) auto var(--spacing-lg);">
            Have questions about our diamonds or jewelry? We're here to help.
        </p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); max-width: 1000px; margin: 0 auto;">
            <div class="admin-card">
                <h3>Get In Touch</h3>
                
                <div style="display: grid; gap: var(--spacing-md); margin-top: var(--spacing-md);">
                    <div>
                        <h4 style="color: var(--color-accent); margin-bottom: 0.5rem;">Email</h4>
                        <a href="mailto:<?= e($storeEmail) ?>" style="font-size: 1.125rem;">
                            <?= e($storeEmail) ?>
                        </a>
                    </div>
                    
                    <div>
                        <h4 style="color: var(--color-accent); margin-bottom: 0.5rem;">Phone</h4>
                        <a href="tel:<?= e($storePhone) ?>" style="font-size: 1.125rem;">
                            <?= e($storePhone) ?>
                        </a>
                    </div>
                    
                    <div>
                        <h4 style="color: var(--color-accent); margin-bottom: 0.5rem;">Business Hours</h4>
                        <p style="color: var(--color-text-light);">
                            Monday - Friday: 9:00 AM - 5:00 PM<br>
                            Saturday: 10:00 AM - 2:00 PM<br>
                            Sunday: Closed
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="admin-card">
                <h3>Visit Our Showroom</h3>
                
                <p style="color: var(--color-text-light); margin: var(--spacing-md) 0;">
                    We welcome private appointments to view our collection and discuss your requirements 
                    with our diamond specialists.
                </p>
                
                <div style="background: var(--color-bg-light); padding: var(--spacing-md); border-radius: var(--border-radius); margin: var(--spacing-md) 0;">
                    <strong>JJ Jewelry & Co Showroom</strong><br>
                    <span style="color: var(--color-text-light);">
                        [Address details available upon request]<br>
                        Johannesburg, Gauteng<br>
                        South Africa
                    </span>
                </div>
                
                <p style="color: var(--color-text-light); font-size: 0.95rem;">
                    Please contact us in advance to schedule your visit. This ensures we can provide 
                    you with personalized attention and have your items of interest available.
                </p>
            </div>
        </div>
        
        <div class="admin-card" style="max-width: 1000px; margin: var(--spacing-lg) auto 0;">
            <h3>Frequently Asked Questions</h3>
            
            <div style="display: grid; gap: var(--spacing-md); margin-top: var(--spacing-md);">
                <div>
                    <h4>Do you offer international shipping?</h4>
                    <p style="color: var(--color-text-light);">
                        Currently we ship within South Africa only. For international inquiries, 
                        please contact us directly.
                    </p>
                </div>
                
                <div>
                    <h4>Are your diamonds certified?</h4>
                    <p style="color: var(--color-text-light);">
                        Yes, all our polished diamonds come with certification from internationally 
                        recognized gemological institutes such as GIA and EGL.
                    </p>
                </div>
                
                <div>
                    <h4>Do you offer custom jewelry design?</h4>
                    <p style="color: var(--color-text-light);">
                        Yes, we offer bespoke jewelry design services. Contact us to discuss your 
                        vision with our design team.
                    </p>
                </div>
                
                <div>
                    <h4>What payment methods do you accept?</h4>
                    <p style="color: var(--color-text-light);">
                        We accept EFT/bank transfer and online payments via PayFast. Bank details are 
                        provided after order confirmation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
