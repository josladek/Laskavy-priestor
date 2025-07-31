<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/email_functions.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $terms = isset($_POST['terms']);
    
    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = 'Prosím vyplňte všetky povinné polia.';
    } elseif (!validateEmail($email)) {
        $error = 'Neplatná emailová adresa. Zadajte správny formát (napr. vasa@email.sk).';
    } elseif (!validatePhone($phone)) {
        $error = 'Neplatné telefónne číslo. Použite slovenský formát (napr. +421 123 456 789, 0123 456 789).';
    } elseif (strlen($password) < 6) {
        $error = 'Heslo musí mať aspoň 6 znakov.';
    } elseif ($password !== $passwordConfirm) {
        $error = 'Heslá sa nezhodujú.';
    } elseif (!$terms) {
        $error = 'Musíte súhlasiť s podmienkami používania.';
    } else {
        // Kontrola existujúceho emailu
        $existingUser = db()->fetch("SELECT id FROM users WHERE email = ?", [$email]);
        if ($existingUser) {
            $error = 'Používateľ s týmto emailom už existuje.';
        } else {
            // Formátovanie telefónu
            $formattedPhone = formatPhone($phone);
            
            try {
                db()->beginTransaction();
                
                // Vytvorenie používateľa s neaktivovaným statusom
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $result = db()->query("
                    INSERT INTO users (name, email, phone, password_hash, role, eur_balance, email_verified, status, created_at) 
                    VALUES (?, ?, ?, ?, 'klient', 0, 0, 'pending', NOW())
                ", [$name, $email, $formattedPhone, $hashedPassword]);
                
                if (!$result) {
                    throw new Exception('Chyba pri vytváraní používateľa');
                }
                
                $userId = db()->lastInsertId();
                
                // Generovanie a odoslanie overovacieho emailu
                $token = generateEmailVerificationToken($userId);
                
                if (sendEmailVerification($email, $name, $token)) {
                    db()->commit();
                    setFlashMessage('Účet bol vytvorený! Skontrolujte svoj email a kliknite na overovací odkaz pre aktiváciu účtu.', 'success');
                    redirect('../pages/login.php');
                } else {
                    throw new Exception('Chyba pri odosielaní overovacieho emailu');
                }
                
            } catch (Exception $e) {
                db()->rollBack();
                error_log("Registration error: " . $e->getMessage());
                $error = 'Chyba pri vytváraní účtu: ' . $e->getMessage();
            }
        }
    }
}

$currentPage = 'register';
$pageTitle = 'Registrácia';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2 class="mb-0 fw-bold">Registrácia</h2>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <svg width="60" height="60" viewBox="0 0 100 100" class="mb-3">
                            <defs>
                                <linearGradient id="register-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:var(--sage);stop-opacity:0.8" />
                                    <stop offset="100%" style="stop-color:var(--sage-dark);stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <path d="M50 20 C40 30, 40 40, 50 45 C60 40, 60 30, 50 20" fill="url(#register-gradient)" opacity="0.9"/>
                            <path d="M65 35 C55 25, 45 25, 50 35 C55 45, 65 45, 65 35" fill="url(#register-gradient)" opacity="0.8"/>
                            <path d="M50 80 C60 70, 60 60, 50 55 C40 60, 40 70, 50 80" fill="url(#register-gradient)" opacity="0.9"/>
                            <path d="M35 35 C45 25, 55 25, 50 35 C45 45, 35 45, 35 35" fill="url(#register-gradient)" opacity="0.8"/>
                            <circle cx="50" cy="50" r="8" fill="var(--sage)"/>
                        </svg>
                        <p class="text-muted">Vytvorte si nový účet</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= e($error) ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Meno a priezvisko *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user text-sage"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name" 
                                               value="<?= e($_POST['name'] ?? '') ?>" placeholder="Vaše meno" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Prosím zadajte vaše meno.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Emailová adresa *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope text-sage"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= e($_POST['email'] ?? '') ?>" placeholder="vasa@email.sk" required>
                            </div>
                            <div class="invalid-feedback">
                                Prosím zadajte platnú emailovú adresu.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefón *</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone text-sage"></i>
                                </span>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= e($_POST['phone'] ?? '') ?>" placeholder="+421 123 456 789 alebo 0123 456 789" required>
                            </div>
                            <div class="invalid-feedback">
                                Prosím zadajte platné slovenské telefónne číslo.
                            </div>
                            <small class="form-text text-muted">
                                Formáty: +421 123 456 789, 0123 456 789, 123 456 789
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Heslo *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock text-sage"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Min. 6 znakov" required minlength="6">
                                    </div>
                                    <div class="invalid-feedback">
                                        Heslo musí mať aspoň 6 znakov.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirm" class="form-label">Potvrdiť heslo *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock text-sage"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" 
                                               placeholder="Zopakujte heslo" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Heslá sa nezhodujú.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    Súhlasím s <a href="terms.php" target="_blank" class="text-sage">podmienkami používania</a> 
                                    a <a href="privacy.php" target="_blank" class="text-sage">ochranou osobných údajov</a> *
                                </label>
                                <div class="invalid-feedback">
                                    Musíte súhlasiť s podmienkami.
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-user-plus me-2"></i> Vytvoriť účet
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-4 text-center">
                        <p class="mb-0">Už máte účet? <a href="login.php" class="text-sage text-decoration-none fw-bold">Prihláste sa</a></p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="small text-muted">
                    <i class="fas fa-shield-alt me-1"></i> Vaše údaje sú chránené SSL šifrovaním
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    
    // Custom password confirmation validation
    function validatePasswords() {
        if (passwordInput.value !== confirmInput.value) {
            confirmInput.setCustomValidity('Heslá sa nezhodujú');
        } else {
            confirmInput.setCustomValidity('');
        }
    }
    
    passwordInput.addEventListener('input', validatePasswords);
    confirmInput.addEventListener('input', validatePasswords);
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            validatePasswords();
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>