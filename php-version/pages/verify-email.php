<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/email_functions.php';

$token = $_GET['token'] ?? '';
$message = '';
$messageType = '';

if (empty($token)) {
    $message = 'Chýba verifikačný token.';
    $messageType = 'error';
} else {
    $result = verifyEmailToken($token);
    
    if ($result) {
        $message = 'Email bol úspešne overený! Môžete sa teraz prihlásiť.';
        $messageType = 'success';
        
        // Automatické prihlásenie po úspešnej verifikácii
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_role'] = 'klient';
        $_SESSION['user_name'] = $result['name'];
    } else {
        $message = 'Neplatný alebo expirovaný token.';
        $messageType = 'error';
    }
}

$currentPage = 'verify-email';
$pageTitle = 'Overenie emailu';
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
        <div class="verify-container">
            <?php if ($messageType === 'success'): ?>
                <div class="verify-icon success">
                    ✅
                </div>
                <h2 class="text-center mb-4" style="color: #28a745;">Email bol úspešne overený!</h2>
                <div class="verify-message">
                    <p class="lead"><?php echo htmlspecialchars($message); ?></p>
                    <p>Váš účet je teraz aktívny a môžete sa registrovať na jogové lekcie.</p>
                </div>
                <div class="verify-actions">
                    <a href="../pages/classes.php" class="btn btn-primary btn-lg">
                        Zobraziť lekcie
                    </a>
                    <a href="../pages/profile.php" class="btn btn-secondary btn-lg">
                        Môj profil
                    </a>
                </div>
            <?php else: ?>
                <div class="verify-icon error">
                    ❌
                </div>
                <h2 class="text-center mb-4" style="color: #dc3545;">Overenie sa nepodarilo</h2>
                <div class="verify-message">
                    <p class="lead"><?php echo htmlspecialchars($message); ?></p>
                    <p>Možné príčiny:</p>
                    <ul class="text-start" style="max-width: 400px; margin: 0 auto;">
                        <li>Token je neplatný alebo expirovaný</li>
                        <li>Email už bol predtým overený</li>
                        <li>Problém s internetovým pripojením</li>
                    </ul>
                </div>
                <div class="verify-actions">
                    <a href="../pages/resend-verification.php" class="btn btn-primary btn-lg">
                        Odoslať nový email
                    </a>
                    <a href="../pages/login.php" class="btn btn-secondary btn-lg">
                        Prihlásiť sa
                    </a>
                </div>
            <?php endif; ?>
            
            <hr class="my-4">
            
            <div class="text-center">
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