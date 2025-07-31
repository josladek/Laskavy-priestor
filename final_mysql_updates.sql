-- MySQL script for class_ratings table creation
-- This needs to be run on the production MySQL database manually

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

-- Add constraint to ensure rating is between 1 and 5
ALTER TABLE class_ratings ADD CONSTRAINT chk_rating_range CHECK (rating BETWEEN 1 AND 5);