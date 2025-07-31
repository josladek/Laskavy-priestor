-- ===================================================================
-- FINÁLNY DATABÁZOVÝ CLEANUP - RIEŠI VŠETKY CHYBY
-- ===================================================================

START TRANSACTION;

-- Vypnutie foreign key checks na začiatku
SET FOREIGN_KEY_CHECKS = 0;

-- Identifikuj admin používateľa
SET @admin_id = (SELECT id FROM users WHERE role = 'admin' LIMIT 1);

-- ===================================================================
-- CLEANUP S KONTROLOU EXISTENCIE TABULIEK
-- ===================================================================

-- 1. Vymazanie attendance (ak existuje)
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'attendance');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE attendance', 'SELECT "attendance table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2. Vymazanie registrácií
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'registrations');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE registrations', 'SELECT "registrations table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Vymazanie course registrácií
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'course_registrations');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE course_registrations', 'SELECT "course_registrations table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 4. Vymazanie workshop registrácií
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'workshop_registrations');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE workshop_registrations', 'SELECT "workshop_registrations table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 5. Vymazanie payment requests
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'payment_requests');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE payment_requests', 'SELECT "payment_requests table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 6. Vymazanie credit transactions
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'credit_transactions');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE credit_transactions', 'SELECT "credit_transactions table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 7. Vymazanie notifications (ak existuje)
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'notifications');
SET @sql = IF(@table_exists > 0, 'TRUNCATE TABLE notifications', 'SELECT "notifications table not exists" as info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 8. Vymazanie yoga classes
DELETE FROM yoga_classes;
ALTER TABLE yoga_classes AUTO_INCREMENT = 1;

-- 9. Vymazanie workshops
DELETE FROM workshops;
ALTER TABLE workshops AUTO_INCREMENT = 1;

-- 10. Vymazanie courses
DELETE FROM courses;
ALTER TABLE courses AUTO_INCREMENT = 1;

-- 11. Vymazanie non-admin users
DELETE FROM users WHERE id != IFNULL(@admin_id, 1) AND role != 'admin';
ALTER TABLE users AUTO_INCREMENT = 2;

-- Zapnutie foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ===================================================================
-- RESET ADMIN POUŽÍVATEĽA
-- ===================================================================

UPDATE users SET 
  password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  eur_balance = 0.00
WHERE role = 'admin';

-- ===================================================================
-- KONTROLA VÝSLEDKOV
-- ===================================================================

SELECT 'DATABASE CLEANUP COMPLETED' as status;

SELECT 'Remaining users:' as info;
SELECT id, name, email, role FROM users;

SELECT 'Table counts after cleanup:' as info;
SELECT 'yoga_classes' as table_name, COUNT(*) as count FROM yoga_classes
UNION ALL
SELECT 'courses' as table_name, COUNT(*) as count FROM courses
UNION ALL  
SELECT 'workshops' as table_name, COUNT(*) as count FROM workshops
UNION ALL
SELECT 'users' as table_name, COUNT(*) as count FROM users;

SELECT 'Settings preserved:' as info;
SELECT COUNT(*) as settings_count FROM settings;

SELECT 'EXECUTE COMMIT; TO CONFIRM OR ROLLBACK; TO CANCEL' as instruction;

-- COMMIT;