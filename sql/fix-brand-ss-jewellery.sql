-- URGENT: Brand Fix for SS Jewellery & Co
-- Run this immediately on live database to fix brand display issues
-- This updates store name and bank account holder in settings

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- Update store name to SS Jewellery & Co
UPDATE `settings` 
SET `setting_value` = 'SS Jewellery & Co' 
WHERE `setting_key` = 'store_name';

-- Update store email to ssjewellery.store domain
UPDATE `settings` 
SET `setting_value` = 'info@ssjewellery.store' 
WHERE `setting_key` = 'store_email';

-- Update bank account holder name
UPDATE `settings` 
SET `setting_value` = 'SS Jewellery & Co (Pty) Ltd' 
WHERE `setting_key` = 'bank_account_holder';

COMMIT;

-- Verification queries (run these to confirm changes)
-- SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('store_name', 'store_email', 'bank_account_holder');

-- NOTES:
-- 1. This fixes the header brand display (from JJ Jewelry & Co → SS Jewellery & Co)
-- 2. This fixes bank account holder on payment pages
-- 3. Order numbers will use SS- prefix after PHP files are updated
-- 4. Run this IMMEDIATELY after uploading updated PHP files
