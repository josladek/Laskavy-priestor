-- MySQL updates for advanced client features
-- Execute these SQL commands on production MySQL database

-- 1. Add class ratings table (if not exists) - Fixed MySQL syntax
CREATE TABLE IF NOT EXISTS class_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES yoga_classes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_class_rating (user_id, class_id)
);

-- 2. Add indexes for better performance - use separate statements to avoid errors if already exist
-- Run each ALTER statement separately, ignore errors if index already exists

-- Add user_id index
ALTER TABLE class_ratings ADD INDEX idx_class_ratings_user_id (user_id);

-- Add class_id index  
ALTER TABLE class_ratings ADD INDEX idx_class_ratings_class_id (class_id);

-- Add rating index
ALTER TABLE class_ratings ADD INDEX idx_class_ratings_rating (rating);

-- 3. Verify existing tables structure
DESCRIBE users;
DESCRIBE yoga_classes;
DESCRIBE class_registrations;
DESCRIBE courses;
DESCRIBE workshops;
DESCRIBE payment_requests;

-- 4. Check if all required columns exist
SELECT COLUMN_NAME, DATA_TYPE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'users' 
AND COLUMN_NAME IN ('eur_balance', 'email_verified', 'role');

SELECT COLUMN_NAME, DATA_TYPE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'registrations' 
AND COLUMN_NAME IN ('attendance_marked', 'paid_with_credit', 'status');

-- 5. Verify workshop and course payment integration
SELECT COLUMN_NAME, DATA_TYPE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
AND TABLE_NAME = 'payment_requests' 
AND COLUMN_NAME IN ('workshop_id', 'course_id', 'class_id');

-- End of MySQL updates script