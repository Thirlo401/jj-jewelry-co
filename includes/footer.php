    </main>
    
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>SS Jewellery</h3>
                    <p>South Africa's premier destination for exquisite fine jewellery.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Shop</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/shop.php?category=rings">Rings</a></li>
                        <li><a href="<?= BASE_URL ?>/shop.php?category=earrings">Earrings</a></li>
                        <li><a href="<?= BASE_URL ?>/shop.php?category=bracelets">Bracelets</a></li>
                        <li><a href="<?= BASE_URL ?>/shop.php?category=necklaces">Necklaces</a></li>
                        <li><a href="<?= BASE_URL ?>/shop.php?category=pendants">Pendants</a></li>
                        <li><a href="<?= BASE_URL ?>/request-diamond.php">Request a Diamond</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Information</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/about.php">About Us</a></li>
                        <li><a href="<?= BASE_URL ?>/contact.php">Contact</a></li>
                        <li><a href="<?= BASE_URL ?>/privacy.php">Privacy Policy</a></li>
                        <li><a href="<?= BASE_URL ?>/terms.php">Terms of Service</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Contact</h4>
                    <p><?= e(getSetting('store_email', 'info@jjjewelry.co.za')) ?></p>
                    <p><?= e(getSetting('store_phone', '+27 11 123 4567')) ?></p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> SS Jewellery. All rights reserved.</p>
                <p><a href="<?= BASE_URL ?>/admin/">Admin Login</a></p>
            </div>
        </div>
    </footer>
    
    <script>
        // Sticky header on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.site-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        document.querySelector('.mobile-menu-toggle')?.addEventListener('click', function() {
            document.querySelector('.nav-menu')?.classList.toggle('active');
            this.classList.toggle('active');
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
    
    <?php if (isset($additionalJS)): ?>
        <?= $additionalJS ?>
    <?php endif; ?>
</body>
</html>
