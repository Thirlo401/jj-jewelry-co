-- BYL Jewellery Import
-- Generated: 2026-09-23 18:42:00
-- Total Products: 60
-- Pricing: BYL wholesale + 15% markup (ZAR)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Import BYL Jewellery products
-- Uses INSERT ... ON DUPLICATE KEY UPDATE to handle re-imports safely

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12189', 'Round Brilliant Half Eternity Diamond Ring - White Gold', 'round-brilliant-half-eternity-diamond-ring-12189', 'rings', 'Half Eternity Rings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 17273.00, 'byl_12189_0.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11716', 'Round Brilliant Half Eternity Diamond Ring - Rose Gold', 'round-brilliant-half-eternity-diamond-ring-11716', 'rings', 'Half Eternity Rings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 17767.50, 'byl_11716_1.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11784', 'Round Brilliant Eternity Diamond Ring - In Platinum', 'round-brilliant-eternity-diamond-ring-11784', 'rings', 'Eternity Rings in In Platinum. SS Jewellery reseller stock from BYL Diamonds collection.', 18043.50, 'byl_11784_2.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-9258', 'Round Brilliant Diamond Dress Ring - White Gold', 'round-brilliant-diamond-dress-ring-9258', 'rings', 'Dress Rings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 18594.35, 'byl_9258_3.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-1088', 'Round Brilliant Cut Diamond Ring - Yellow Gold', 'round-brilliant-cut-diamond-ring-1088', 'rings', 'Dress Rings in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 18595.50, 'byl_1088_4.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11714', 'Round Brilliant Half Eternity Diamond Ring - Yellow Gold', 'round-brilliant-half-eternity-diamond-ring-11714', 'rings', 'Half Eternity Rings in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 18779.50, 'byl_11714_5.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-8754', 'Round Brilliant Half Eternity Diamond Ring - Rose Gold', 'round-brilliant-half-eternity-diamond-ring-8754', 'rings', 'Half Eternity Rings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 18791.00, 'byl_8754_6.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11746', 'Baguette Cut Eternity Diamond Ring - White Gold', 'baguette-cut-eternity-diamond-ring-11746', 'rings', 'Half Eternity Rings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 18940.50, 'byl_11746_7.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-10610', 'Oval Cut Solitaire Diamond Ring - White Gold', 'oval-cut-solitaire-diamond-ring-10610', 'rings', 'Solitaire Rings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19653.50, 'byl_10610_8.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-10872', 'Round Brilliant Half Eternity Diamond Ring - Rose Gold', 'round-brilliant-half-eternity-diamond-ring-10872', 'rings', 'Half Eternity Rings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19676.50, 'byl_10872_9.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12945', 'Fancy Light Yellow Radiant Cut Diamond Cluster Ring - Rose Gold', 'fancy-light-yellow-radiant-cut-diamond-cluster-ring-12945', 'rings', 'Solitaire Rings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19676.50, 'byl_12945_10.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11807', 'Tapered Baguette Cut Diamond Ring - White Gold', 'tapered-baguette-cut-diamond-ring-11807', 'rings', 'Half Eternity Rings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 20297.50, 'byl_11807_11.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-10825', 'Round Brilliant Diamond Hoop Earrings - White Gold', 'round-brilliant-diamond-hoop-earrings-10825', 'earrings', 'Hoop Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 36581.50, 'byl_10825_12.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SAER1041', 'Round Brilliant Diamond Drop Earrings - White Gold', 'round-brilliant-diamond-drop-earrings-saer1041', 'earrings', 'Drop Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 36880.50, 'byl_SAER1041_13.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SAER1004', 'Marquise Cut Diamond Hoop Earrings - Yellow Gold', 'marquise-cut-diamond-hoop-earrings-saer1004', 'earrings', 'Hoop Earrings in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 32447.25, 'byl_SAER1004_14.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-RPID954', 'Round Brilliant Diamond Hoop Earrings - White Gold', 'round-brilliant-diamond-hoop-earrings-rpid954', 'earrings', 'Hoop Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 133423.00, 'byl_RPID954_15.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12795', 'Round Brilliant Cut Halo Diamond Stud Earrings - Rose Gold', 'round-brilliant-cut-halo-diamond-stud-earrings-12795', 'earrings', 'Diamond Stud Earrings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 44953.50, 'byl_12795_16.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12793', 'Round Brilliant Cut Halo Diamond Stud Earrings - Yellow Gold', 'round-brilliant-cut-halo-diamond-stud-earrings-12793', 'earrings', 'Diamond Stud Earrings in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 46080.50, 'byl_12793_17.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12784', 'Round Brilliant Cut Halo Diamond Stud Earrings - White Gold', 'round-brilliant-cut-halo-diamond-stud-earrings-12784', 'earrings', 'Diamond Stud Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 43033.00, 'byl_12784_18.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12770', 'Round Brilliant Cut Halo Diamond Stud Earrings - White Gold', 'round-brilliant-cut-halo-diamond-stud-earrings-12770', 'earrings', 'Diamond Stud Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 44608.50, 'byl_12770_19.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12678', 'Round Brilliant Cut Diamond Stud Earrings - Rose Gold', 'round-brilliant-cut-diamond-stud-earrings-12678', 'earrings', 'Stud Earrings in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 30222.00, 'byl_12678_20.png', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12675', 'Round Brilliant Cut Diamond Stud Earrings - Yellow Gold', 'round-brilliant-cut-diamond-stud-earrings-12675', 'earrings', 'Stud Earrings in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 31188.00, 'byl_12675_21.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12239', 'Round Brilliant Cut Diamond Stud Earrings - White Gold', 'round-brilliant-cut-diamond-stud-earrings-12239', 'earrings', 'Stud Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 176404.25, 'byl_12239_22.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12237', 'Round Brilliant Cut Diamond Stud Earrings - White Gold', 'round-brilliant-cut-diamond-stud-earrings-12237', 'earrings', 'Diamond Earrings in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 71254.00, 'byl_12237_23.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR234A', 'Round Brilliant Cut Diamond Bracelet - White Gold', 'round-brilliant-cut-diamond-bracelet-sabr234a', 'bracelets', 'Diamond Bracelets in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 17698.50, 'byl_SABR234A_24.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR234B', 'Three Tone Round Brilliant Cut Diamond Bracelet - Three Toned', 'three-tone-round-brilliant-cut-diamond-bracelet-sabr234b', 'bracelets', 'Diamond Bracelets in Three Toned. SS Jewellery reseller stock from BYL Diamonds collection.', 17698.50, 'byl_SABR234B_25.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR232B', 'Round Brilliant Cut Diamond Bracelet - Rose Gold', 'round-brilliant-cut-diamond-bracelet-sabr232b', 'bracelets', 'Diamond Bracelets in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR232B_26.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR232D', 'Round Brilliant Cut Diamond Bracelet - Rose Gold', 'round-brilliant-cut-diamond-bracelet-sabr232d', 'bracelets', 'Diamond Bracelets in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR232D_27.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR238B', 'Two Tone Round Brilliant Cut Diamond Bracelet - Rose & Yellow Gold', 'two-tone-round-brilliant-cut-diamond-bracelet-sabr238b', 'bracelets', 'Diamond Bracelets in Rose & Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR238B_28.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR238A', 'Three Tone Round Brilliant Cut Diamond Bracelet - Three Toned', 'three-tone-round-brilliant-cut-diamond-bracelet-sabr238a', 'bracelets', 'Diamond Bracelets in Three Toned. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR238A_29.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR237C', 'Three Tone Round Brilliant Cut Diamond Bracelet - Three Toned', 'three-tone-round-brilliant-cut-diamond-bracelet-sabr237c', 'bracelets', 'Diamond Bracelets in Three Toned. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR237C_30.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR237A', 'Two Tone Round Brilliant Cut Diamond Bracelet - Rose & Yellow Gold', 'two-tone-round-brilliant-cut-diamond-bracelet-sabr237a', 'bracelets', 'Diamond Bracelets in Rose & Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19184.30, 'byl_SABR237A_31.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR231A', 'Round Brilliant Cut Diamond Bracelet - White Gold', 'round-brilliant-cut-diamond-bracelet-sabr231a', 'bracelets', 'Diamond Bracelets in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19468.35, 'byl_SABR231A_32.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR231B', 'Round Brilliant Cut Diamond Bracelet - White Gold', 'round-brilliant-cut-diamond-bracelet-sabr231b', 'bracelets', 'Diamond Bracelets in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19468.35, 'byl_SABR231B_33.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR231C', 'Round Brilliant Cut Diamond Bracelet - White Gold', 'round-brilliant-cut-diamond-bracelet-sabr231c', 'bracelets', 'Diamond Bracelets in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19468.35, 'byl_SABR231C_34.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-SABR230A', 'Round Brilliant Cut Diamond Bracelet - Yellow Gold', 'round-brilliant-cut-diamond-bracelet-sabr230a', 'bracelets', 'Diamond Bracelets in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 19774.25, 'byl_SABR230A_35.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12652', 'Fancy Intense Yellow Multi Shaped Diamond Pendant - Yellow Gold', 'fancy-intense-yellow-multi-shaped-diamond-pendant-12652', 'pendants', 'Illusion Diamond Pendants in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 142220.50, 'byl_12652_36.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-13158', 'Pear Shape Black Diamond, Emerald & Double Halo Diamond Pendant - Yellow Gold', 'pear-shape-black-diamond-emerald-double-halo-diamond-pendant-13158', 'pendants', 'Diamond Pendants in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 51065.75, 'byl_13158_37.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12931', 'Marquise Cut Fancy Yellow Double Halo Diamond Pendant - Yellow Gold', 'marquise-cut-fancy-yellow-double-halo-diamond-pendant-12931', 'pendants', 'Diamond Pendants in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 327985.75, 'byl_12931_38.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12558', 'Round Brilliant Circle Diamond Pendant - Rose Gold', 'round-brilliant-circle-diamond-pendant-12558', 'pendants', 'Diamond Pendants in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33844.50, 'byl_12558_39.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-10557', 'Round Brilliant Diamond Pendant - Rose Gold', 'round-brilliant-diamond-pendant-10557', 'pendants', 'Diamond Pendants in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 41388.50, 'byl_10557_40.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-UPID3772', 'Round Brilliant Solitaire Diamond Pendant - White Gold', 'round-brilliant-solitaire-diamond-pendant-upid3772', 'pendants', 'Solitaire Diamond Pendant in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 22114.50, 'byl_UPID3772_41.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12043', 'Fancy Light Yellow Radiant Cut Halo Diamond Pendant - Yellow Gold', 'fancy-light-yellow-radiant-cut-halo-diamond-pendant-12043', 'pendants', 'Fancy Yellow Pendants in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 96600.00, 'byl_12043_42.png', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12685', 'Round Brilliant Solitaire Diamond Pendant - Rose Gold', 'round-brilliant-solitaire-diamond-pendant-12685', 'pendants', 'Solitaire Diamond Pendant in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 22091.50, 'byl_12685_43.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12684', 'Round Brilliant Solitaire Diamond Pendant - Rose Gold', 'round-brilliant-solitaire-diamond-pendant-12684', 'pendants', 'Solitaire Diamond Pendant in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 22298.50, 'byl_12684_44.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12563', 'Round Brilliant Circle Diamond Pendant - White Gold', 'round-brilliant-circle-diamond-pendant-12563', 'pendants', 'Diamond Pendants in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 36064.00, 'byl_12563_45.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12093', 'Round Brilliant Teardrop Diamond Pendant - White Gold', 'round-brilliant-teardrop-diamond-pendant-12093', 'pendants', 'Solitaire Diamond Pendant in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 28934.00, 'byl_12093_46.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11988', 'Round Brilliant Halo Diamond Pendant - White Gold', 'round-brilliant-halo-diamond-pendant-11988', 'pendants', 'Diamond Pendants in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 29313.50, 'byl_11988_47.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12706', 'Round Brilliant Diamond Tennis Necklace - Yellow Gold', 'round-brilliant-diamond-tennis-necklace-12706', 'necklaces', 'Tennis Necklace in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 62399.00, 'byl_12706_48.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK231', 'Round Brilliant Diamond Bezel Set Three-Tone Necklace - Three-Tone Gold', 'round-brilliant-diamond-bezel-set-three-tone-necklace-neck231', 'necklaces', 'Diamond Necklace in Three-Tone Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33361.50, 'byl_NECK231_49.png', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12715', 'Round Brilliant Diamond Tennis Necklace - White Gold', 'round-brilliant-diamond-tennis-necklace-12715', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 132629.50, 'byl_12715_50.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12708', 'Round Brilliant Diamond Tennis Necklace - Yellow Gold', 'round-brilliant-diamond-tennis-necklace-12708', 'necklaces', 'Diamond Necklace in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 183586.00, 'byl_12708_51.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-12049', 'Round Brilliant Illusion Set Diamond Cluster Necklace - White Gold', 'round-brilliant-illusion-set-diamond-cluster-necklace-12049', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33452.35, 'byl_12049_52.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK227B', 'Round Brilliant Diamond Necklace - White Gold', 'round-brilliant-diamond-necklace-neck227b', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33933.05, 'byl_NECK227B_53.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK227A', 'Round Brilliant Diamond Necklace - White Gold', 'round-brilliant-diamond-necklace-neck227a', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33933.05, 'byl_NECK227A_54.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK224C', 'Round Brilliant Diamond Necklace - Yellow Gold', 'round-brilliant-diamond-necklace-neck224c', 'necklaces', 'Diamond Necklace in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33933.05, 'byl_NECK224C_55.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK223B', 'Round Brilliant Diamond Necklace - Yellow Gold', 'round-brilliant-diamond-necklace-neck223b', 'necklaces', 'Diamond Necklace in Yellow Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 32447.25, 'byl_NECK223B_56.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK222C', 'Round Brilliant Diamond Necklace - White Gold', 'round-brilliant-diamond-necklace-neck222c', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 33933.05, 'byl_NECK222C_57.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-NECK228A', 'Round Brilliant Diamond Necklace - White Gold', 'round-brilliant-diamond-necklace-neck228a', 'necklaces', 'Diamond Necklace in White Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 29497.50, 'byl_NECK228A_58.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

INSERT INTO `products` (`sku`, `name`, `slug`, `category`, `description`, `price`, `image_main`, `stock_quantity`, `is_featured`, `is_active`) VALUES
('BYL-JW-11728', 'Round Brilliant Diamond Cluster Necklace - Rose Gold', 'round-brilliant-diamond-cluster-necklace-11728', 'necklaces', 'Diamond Necklace in Rose Gold. SS Jewellery reseller stock from BYL Diamonds collection.', 26853.65, 'byl_11728_59.jpg', 1, 0, 1)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `description` = VALUES(`description`),
  `price` = VALUES(`price`),
  `category` = VALUES(`category`),
  `image_main` = COALESCE(VALUES(`image_main`), `image_main`);

COMMIT;
-- Import completed. Check the price sheet for reference.
