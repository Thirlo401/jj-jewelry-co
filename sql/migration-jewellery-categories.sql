-- Migration: Add Jewellery Categories and Diamond Requests
-- Run this on existing live databases to update the schema
-- This migration preserves all existing data

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Step 1: Modify the products category enum to include new jewellery categories
-- Note: This preserves existing rough_diamonds, polished_diamonds, and jewelry values
ALTER TABLE `products` 
  MODIFY `category` enum(
    'rough_diamonds',
    'polished_diamonds',
    'jewelry',
    'rings',
    'earrings',
    'bracelets',
    'necklaces',
    'pendants'
  ) NOT NULL;

-- Step 2: Create diamond_requests table for customer diamond inquiries
CREATE TABLE IF NOT EXISTS `diamond_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_number` varchar(50) NOT NULL,
  `diamond_type` enum('polished','rough') NOT NULL,
  `shape` varchar(50) DEFAULT NULL,
  `carat_min` decimal(8,2) DEFAULT NULL,
  `carat_max` decimal(8,2) DEFAULT NULL,
  `color_notes` text DEFAULT NULL,
  `clarity_notes` text DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','in_progress','quoted','completed','cancelled') NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `request_number` (`request_number`),
  KEY `status` (`status`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Step 3: Add hero background image setting
INSERT INTO `settings` (`setting_key`, `setting_value`) 
VALUES ('hero_background_image', '')
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;

COMMIT;

-- NOTES:
-- 1. Existing products with category 'jewelry' remain unchanged
-- 2. New products can use: rings, earrings, bracelets, necklaces, pendants
-- 3. Rough and polished diamonds can still exist in admin but won't show in public shop
-- 4. Run this migration before importing the BYL jewellery CSV data
