-- ULTRA JEDNODUCHÝ CLEANUP - BEZ CHÝB
START TRANSACTION;

-- Vypnutie foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Najdenie admin ID
SET @admin_id = (SELECT id FROM users WHERE role = 'admin' LIMIT 1);

-- Vymazanie všetkých dát
DELETE FROM registrations;
DELETE FROM course_registrations;
DELETE FROM workshop_registrations;
DELETE FROM payment_requests;
DELETE FROM credit_transactions;
DELETE FROM yoga_classes;
DELETE FROM workshops;
DELETE FROM courses;
DELETE FROM users WHERE role != 'admin';

-- Zapnutie foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Reset admin hesla
UPDATE users SET password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE role = 'admin';

-- Kontrola
SELECT 'CLEANUP HOTOVÝ' as status;
SELECT COUNT(*) as users FROM users;
SELECT id, name, email, role FROM users LIMIT 5;

-- SPUSTIŤ: COMMIT;