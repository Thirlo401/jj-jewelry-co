-- PayFast Integration - Add payment transaction tracking
-- Run this migration to add PayFast payment tracking fields

-- Add payment tracking fields to orders table
ALTER TABLE `orders` 
ADD COLUMN `payment_status` VARCHAR(50) DEFAULT NULL COMMENT 'PayFast payment status: PENDING, COMPLETE, FAILED, CANCELLED' AFTER `payment_method`,
ADD COLUMN `payfast_payment_id` VARCHAR(100) DEFAULT NULL COMMENT 'PayFast payment/transaction ID' AFTER `payment_status`,
ADD COLUMN `payfast_data` TEXT DEFAULT NULL COMMENT 'JSON encoded PayFast transaction data' AFTER `payfast_payment_id`,
ADD INDEX `idx_payfast_payment_id` (`payfast_payment_id`),
ADD INDEX `idx_payment_status` (`payment_status`);

-- Note: payment_status is separate from order status
-- payment_status: PENDING (waiting for PayFast), COMPLETE (paid), FAILED, CANCELLED
-- status: pending (new), paid (payment received), processing (being prepared), shipped, cancelled
