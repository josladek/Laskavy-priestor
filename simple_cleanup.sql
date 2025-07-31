-- FINÁLNY CLEANUP - RIEŠI FOREIGN KEY CONSTRAINTS
START TRANSACTION;

-- Vypnutie foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Identifikuj admin
SET @admin_id = (SELECT id FROM users WHERE role = 'admin' LIMIT 1);

-- Vymaž všetky záznamy (DELETE namiesto TRUNCATE)
DELETE FROM registrations;
DELETE FROM course_registrations; 
DELETE FROM workshop_registrations;
DELETE FROM payment_requests;
DELETE FROM credit_transactions;
DELETE FROM yoga_classes;
DELETE FROM workshops;
DELETE FROM courses;

-- Vymaž non-admin users
DELETE FROM users WHERE id != IFNULL(@admin_id, 1) AND role != 'admin';

-- Reset AUTO_INCREMENT counters
ALTER TABLE registrations AUTO_INCREMENT = 1;
ALTER TABLE course_registrations AUTO_INCREMENT = 1;
ALTER TABLE workshop_registrations AUTO_INCREMENT = 1;
ALTER TABLE payment_requests AUTO_INCREMENT = 1;
ALTER TABLE credit_transactions AUTO_INCREMENT = 1;
ALTER TABLE yoga_classes AUTO_INCREMENT = 1;
ALTER TABLE workshops AUTO_INCREMENT = 1;
ALTER TABLE courses AUTO_INCREMENT = 1;
ALTER TABLE users AUTO_INCREMENT = 2;

-- Zapnutie foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Reset admin (len existujúce stĺpce)
UPDATE users SET 
  password_hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  eur_balance = 0.00
WHERE role = 'admin';

-- Kontrola výsledkov
SELECT 'CLEANUP DOKONČENÝ' as status;
SELECT COUNT(*) as remaining_users FROM users;
SELECT COUNT(*) as remaining_classes FROM yoga_classes;
SELECT COUNT(*) as remaining_courses FROM courses;
SELECT COUNT(*) as remaining_workshops FROM workshops;
SELECT COUNT(*) as remaining_registrations FROM registrations;

SELECT 'Admin používateľ:' as info;
SELECT id, name, email, role FROM users WHERE role = 'admin';

SELECT 'SPUSTIŤ: COMMIT; pre potvrdenie alebo ROLLBACK; pre zrušenie' as instruction;

-- COMMIT;