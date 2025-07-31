-- Simple MySQL updates for class ratings - Execute on production database
-- Run only the CREATE TABLE statement, ignore INDEX errors if they already exist

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

-- Add indexes separately (ignore error if already exist)
-- Run these one by one:

-- ALTER TABLE class_ratings ADD INDEX idx_class_ratings_user_id (user_id);
-- ALTER TABLE class_ratings ADD INDEX idx_class_ratings_class_id (class_id); 
-- ALTER TABLE class_ratings ADD INDEX idx_class_ratings_rating (rating);