-- Migration: Update product categories for SS Jewellery & Co
-- This migration converts the generic 'jewelry' category to specific jewellery categories
-- and removes rough_diamonds/polished_diamonds from public shop filters
-- Run this AFTER backing up your database

-- Step 1: Add new enum values to the category column
-- MySQL doesn't support direct ENUM modification, so we need to alter the column
ALTER TABLE `products` 
MODIFY COLUMN `category` enum(
  'rough_diamonds',
  'polished_diamonds',
  'jewelry',
  'rings',
  'earrings',
  'pendants',
  'bracelets',
  'necklaces'
) NOT NULL;

-- Step 2: Migrate existing 'jewelry' products to 'rings' as default
-- (Admin should manually update products to their correct categories after migration)
-- This prevents breaking existing products
UPDATE `products` 
SET `category` = 'rings' 
WHERE `category` = 'jewelry';

-- Step 3: Optional - Remove the old 'jewelry' enum value
-- Run this ONLY after all products have been properly categorized
-- Uncomment the following line when ready:
-- ALTER TABLE `products` MODIFY COLUMN `category` enum('rough_diamonds','polished_diamonds','rings','earrings','pendants','bracelets','necklaces') NOT NULL;

-- Note: rough_diamonds and polished_diamonds categories remain in the database
-- for admin inventory management, but are excluded from public shop filters
