-- SS Jewellery Seed Data
-- Default admin user and sample products

-- Insert default admin user
-- Username: admin  
-- Password: changeme123 (MUST be changed after first login!)
-- NOTE: If password doesn't work, run: php generate_admin_hash.php
--       to generate a new hash, then update this line or run UPDATE query
INSERT INTO `admin_users` (`username`, `password`, `email`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@ssjewellery.store');

-- Insert default site settings
INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('store_name', 'SS Jewellery'),
('store_email', 'info@ssjewellery.store'),
('store_phone', '+27 11 123 4567'),
('currency', 'ZAR'),
('bank_name', 'First National Bank'),
('bank_account_holder', 'SS Jewellery (Pty) Ltd'),
('bank_account_number', '62XXXXXXXX'),
('bank_branch_code', '250655'),
('bank_account_type', 'Business Cheque Account'),
('payfast_merchant_id', ''),
('payfast_merchant_key', ''),
('payfast_passphrase', ''),
('payfast_sandbox', '1');

-- Insert sample products
INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `carat_weight`, `cut`, `clarity`, `color`, `stock_quantity`, `is_featured`, `is_active`) VALUES

-- Rough Diamonds
('RD-001', 'Natural Rough Diamond 2.5ct', 'natural-rough-diamond-25ct', 'rough_diamonds', 'Uncut natural diamond crystal with exceptional clarity. Perfect for custom cutting and setting. Sourced from ethical mines in Botswana.', 18500.00, 2.50, NULL, 'VS1', 'H', 3, 1, 1),
('RD-002', 'Rough Diamond Crystal 1.8ct', 'rough-diamond-crystal-18ct', 'rough_diamonds', 'Beautiful octahedral rough diamond showing excellent color and crystal structure. Ideal for collectors or custom jewelry.', 12750.00, 1.80, NULL, 'VS2', 'I', 2, 1, 1),
('RD-003', 'Large Rough Diamond 4.2ct', 'large-rough-diamond-42ct', 'rough_diamonds', 'Impressive rough diamond specimen with minimal inclusions. Excellent potential for high-value polished stone.', 38900.00, 4.20, NULL, 'VVS2', 'G', 1, 1, 1),
('RD-004', 'Investment Grade Rough 3.1ct', 'investment-grade-rough-31ct', 'rough_diamonds', 'Premium rough diamond with exceptional color grading. Perfect for investment or bespoke jewelry creation.', 26500.00, 3.10, NULL, 'VVS1', 'F', 2, 0, 1),

-- Polished Diamonds
('PD-001', 'Round Brilliant Cut 1.5ct', 'round-brilliant-cut-15ct', 'polished_diamonds', 'Exquisitely cut round brilliant diamond with exceptional fire and brilliance. GIA certified with ideal proportions.', 89500.00, 1.50, 'Round Brilliant', 'VVS1', 'E', 1, 1, 1),
('PD-002', 'Princess Cut Diamond 1.2ct', 'princess-cut-diamond-12ct', 'polished_diamonds', 'Modern princess cut diamond with perfect square proportions and stunning sparkle. Certified by EGL.', 54200.00, 1.20, 'Princess', 'VS1', 'F', 2, 1, 1),
('PD-003', 'Emerald Cut Diamond 2.0ct', 'emerald-cut-diamond-20ct', 'polished_diamonds', 'Elegant emerald cut diamond showcasing exceptional clarity through its large table. Timeless sophistication.', 125000.00, 2.00, 'Emerald', 'IF', 'D', 1, 1, 1),
('PD-004', 'Oval Cut Diamond 1.8ct', 'oval-cut-diamond-18ct', 'polished_diamonds', 'Beautiful oval brilliant cut maximizing carat weight with excellent elongation ratio. Perfect for engagement rings.', 76500.00, 1.80, 'Oval', 'VVS2', 'F', 1, 1, 1),
('PD-005', 'Cushion Cut Diamond 1.6ct', 'cushion-cut-diamond-16ct', 'polished_diamonds', 'Romantic cushion cut diamond combining vintage appeal with modern brilliance. Excellent color and clarity.', 68900.00, 1.60, 'Cushion', 'VS2', 'G', 2, 0, 1),

-- Jewelry
('JW-001', 'Classic Solitaire Engagement Ring', 'classic-solitaire-engagement-ring', 'jewelry', 'Timeless platinum solitaire featuring a stunning 1.0ct round brilliant diamond in a six-prong setting. Size 6 (resizable).', 142000.00, 1.00, 'Round Brilliant', 'VVS1', 'E', 1, 1, 1),
('JW-002', 'Diamond Tennis Bracelet', 'diamond-tennis-bracelet', 'jewelry', '18k white gold tennis bracelet showcasing 5.5ct total weight of perfectly matched round brilliants. 7 inches length.', 185000.00, 5.50, 'Round Brilliant', 'VS1', 'F', 1, 1, 1),
('JW-003', 'Diamond Stud Earrings', 'diamond-stud-earrings', 'jewelry', 'Classic diamond stud earrings in 18k white gold. 0.75ct total weight (0.375ct each). Four-prong basket setting.', 67500.00, 0.75, 'Round Brilliant', 'VVS2', 'E', 2, 1, 1),
('JW-004', 'Halo Engagement Ring', 'halo-engagement-ring', 'jewelry', 'Breathtaking halo design in platinum featuring 1.25ct center stone surrounded by 0.45ct of pavé diamonds. Size 5.5.', 198000.00, 1.70, 'Round Brilliant', 'IF', 'D', 1, 1, 1),
('JW-005', 'Diamond Eternity Band', 'diamond-eternity-band', 'jewelry', 'Elegant 18k yellow gold eternity band with 2.0ct total weight of princess cut diamonds. Size 6.', 92500.00, 2.00, 'Princess', 'VS1', 'G', 3, 0, 1),
('JW-006', 'Pendant Necklace with Solitaire', 'pendant-necklace-with-solitaire', 'jewelry', 'Delicate 18k white gold pendant featuring a 0.50ct round brilliant diamond. Includes 18-inch chain.', 45000.00, 0.50, 'Round Brilliant', 'VVS1', 'F', 2, 1, 1),
('JW-007', 'Three Stone Anniversary Ring', 'three-stone-anniversary-ring', 'jewelry', 'Stunning platinum three stone ring with 2.5ct total weight. Center 1.5ct flanked by two 0.5ct diamonds. Size 6.5.', 215000.00, 2.50, 'Emerald', 'VVS2', 'E', 1, 1, 1);
