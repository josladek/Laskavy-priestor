<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/email_functions.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    
    if (empty($email)) {
        $message = 'Prosím zadajte emailovú adresu.';
        $messageType = 'error';
    } elseif (!validateEmail($email)) {
        $message = 'Neplatná emailová adresa.';
        $messageType = 'error';
    } else {
        // Find user with unverified email
        $user = db()->fetch("
            SELECT id, name, email, email_verified, status 
            FROM users 
            WHERE email = ? AND status = 'pending' AND email_verified = 0
        ", [$email]);
        
        if (!$user) {
            $message = 'Používateľ s týmto emailom neexistuje alebo je už overený.';
            $messageType = 'error';
        } else {
            try {
                // Generate new verification token
                $token = generateEmailVerificationToken($user['id']);
                
                if (sendEmailVerification($user['email'], $user['name'], $token)) {
                    $message = 'Nový overovací email bol odoslaný! Skontrolujte svoju schránku.';
                    $messageType = 'success';
                } else {
                    $message = 'Chyba pri odosielaní emailu. Skúste to neskôr.';
                    $messageType = 'error';
                }
            } catch (Exception $e) {
                error_log("Resend verification error: " . $e->getMessage());
                $message = 'Chyba pri generovaní nového overovacieho emailu.';
                $messageType = 'error';
            }
        }
    }
}

$currentPage = 'resend-verification';
$pageTitle = 'Opätovné odoslanie overovacieho emailu';
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Láskavý Priestor</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/fontawesome-local.min.css" rel="stylesheet">
    <link href="../assets/css/laskavypriestor.css" rel="stylesheet">
    <!-- CSS moved to laskavypriestor.css -->
</head>
<body>
    <div class="container">
        <div class="resend-container">
            <div class="text-center mb-4">
                <h2 style="color: #4a4a4a;">📧 Opätovné odoslanie overovacieho emailu</h2>
                <p class="text-muted">Zadajte váš email pre odoslanie nového overovacieho odkazu</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?>" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Emailová adresa *</label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                           placeholder="vas@email.sk"
                           required>
                    <div class="form-text">
                        Zadajte email, s ktorým ste sa registrovali v našom štúdiu.
                    </div>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Odoslať overovací email
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="mb-2">Už máte overený účet?</p>
                <a href="../pages/login.php" class="text-decoration-none" style="color: #8db3a0;">
                    Prihlásiť sa
                </a>
            </div>

            <div class="text-center mt-3">
                <p class="mb-1">Potrebujete pomoc?</p>
                <a href="mailto:info@laskavypriestor.eu" class="text-decoration-none" style="color: #8db3a0;">
                    📧 info@laskavypriestor.eu
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>