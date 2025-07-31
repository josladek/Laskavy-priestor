-- Add course_id column to payment_requests table for course payments
-- Run this on production MySQL database

ALTER TABLE payment_requests ADD COLUMN course_id INT DEFAULT NULL;

-- Optional: Add index for better performance
CREATE INDEX idx_payment_requests_course_id ON payment_requests(course_id);

-- Verify the column was added
-- DESCRIBE payment_requests;