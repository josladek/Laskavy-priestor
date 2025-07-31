<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/qr_generator.php';
require_once __DIR__ . '/../config/payment_config.php';
require_once __DIR__ . '/../includes/email_functions.php';

// Must be logged in
if (!isLoggedIn()) {
    header('Location: ' . url('pages/login.php'));
    exit;
}

$currentUser = getCurrentUser();

// Get payment request from URL parameter (like courses do)
$requestId = (int)($_GET['request_id'] ?? 0);

if (!$requestId) {
    $_SESSION['flash_message'] = 'Platobná požiadavka nenájdená.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/workshops.php'));
    exit;
}

// Get payment request details with custom instructor name
$paymentRequest = db()->fetch("
    SELECT pr.*, w.title as workshop_name, w.date, w.time_start, w.time_end, 
           COALESCE(NULLIF(w.custom_instructor_name, ''), u.name) as instructor_name,
           pu.name as user_name, pu.email as user_email
    FROM payment_requests pr
    LEFT JOIN workshops w ON pr.workshop_id = w.id  
    LEFT JOIN users u ON w.instructor_id = u.id
    LEFT JOIN users pu ON pr.user_id = pu.id
    WHERE pr.id = ? AND pr.user_id = ?
", [$requestId, $currentUser['id']]);

if (!$paymentRequest) {
    $_SESSION['flash_message'] = 'Platobná požiadavka nenájdená alebo nemáte oprávnenie na jej zobrazenie.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/workshops.php'));
    exit;
}

// Convert to the format expected by the rest of the code
$paymentData = [
    'type' => 'workshop',
    'workshop_id' => $paymentRequest['workshop_id'],
    'workshop_name' => $paymentRequest['workshop_name'],
    'registration_id' => $requestId, // Use request ID  
    'payment_request_id' => $requestId,
    'amount' => $paymentRequest['amount'],
    'variable_symbol' => $paymentRequest['variable_symbol'],
    'user_name' => $paymentRequest['user_name'],
    'user_email' => $paymentRequest['user_email']
];

// Get studio info for QR code
$studioInfo = getStudioInfo();

try {
    // Generate QR code data string for payment
    $qrDataString = generateQRPaymentString(
        $paymentData['amount'],
        $paymentData['variable_symbol'],
        'Workshop: ' . $paymentData['workshop_name']
    );
    
    // Update payment request with QR data
    db()->query("
        UPDATE payment_requests 
        SET qr_code_data = ?, updated_at = NOW() 
        WHERE id = ?
    ", [$qrDataString, $paymentData['payment_request_id']]);
    
    // Generate QR code HTML for display
    $qrData = displayPaymentQRCode($qrDataString, 'img-fluid');
    
    // Debug: Log QR generation for troubleshooting
    error_log("Workshop QR Data String: " . $qrDataString);
    error_log("Workshop QR HTML length: " . strlen($qrData));
    
    // Generate QR code base64 for email
    $qrBase64 = generatePaymentQRCodeDataUrl($qrDataString);
    if ($qrBase64) {
        // Extract base64 part from data URL
        $qrBase64 = str_replace('data:image/png;base64,', '', $qrBase64);
    }
    
    // Send email with payment details (correct workshop function call)
    $emailSent = sendWorkshopPaymentEmail([
        'user_email' => $paymentData['user_email'],
        'user_name' => $paymentData['user_name'],
        'workshop_title' => $paymentData['workshop_name'], // Note: workshop_title not workshop_name
        'amount' => $paymentData['amount'],
        'variable_symbol' => $paymentData['variable_symbol'],
        'qr_data' => $qrBase64,
        'studio_info' => $studioInfo
    ]);
} catch (Exception $e) {
    // Handle errors gracefully
    error_log("Workshop payment confirmation error: " . $e->getMessage());
    $qrData = '<p class="text-danger">Chyba pri generovaní QR kódu.</p>';
    $emailSent = false;
}

// No need to clear temp data (using URL parameters)

$pageTitle = 'Potvrdenie registrácie na workshop';
$currentPage = 'workshops';
?>

<?php include '../includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-sage text-white text-center">
                    <h3 class="mb-0"><i class="fas fa-check-circle me-2"></i>Registrácia úspešná!</h3>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-success mb-4">
                        <h5><i class="fas fa-tools me-2"></i><?= htmlspecialchars($paymentData['workshop_name']) ?></h5>
                        <p class="mb-0">Vaša registrácia na workshop bola úspešne vytvorená. Pre potvrdenie účasti je potrebné uhradiť poplatok.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5><i class="fas fa-info-circle me-2 text-sage"></i>Detaily platby</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Suma:</strong></td>
                                    <td><?= formatPrice($paymentData['amount']) ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Variabilný symbol:</strong></td>
                                    <td><code><?= htmlspecialchars($paymentData['variable_symbol']) ?></code></td>
                                </tr>
                                <tr>
                                    <td><strong>IBAN:</strong></td>
                                    <td><code><?= htmlspecialchars($studioInfo['banka'] ?? 'SK1234567890123456789012') ?></code></td>
                                </tr>
                                <tr>
                                    <td><strong>Príjemca:</strong></td>
                                    <td><?= htmlspecialchars($studioInfo['nazov'] ?? 'Láskavý Priestor') ?></td>
                                </tr>
                            </table>
                        </div>

                        <?php if ($qrBase64): ?>
                        <div class="col-md-6 text-center mb-4">
                            <h5><i class="fas fa-qrcode me-2 text-sage"></i>QR kód pre platbu</h5>
                            <div class="qr-container mb-3">
                                <img src="data:image/png;base64,<?= $qrBase64 ?>" 
                                     alt="QR kód pre platbu" 
                                     class="img-fluid border rounded"
                                     style="max-width: 200px;">
                            </div>
                            <p class="small text-muted">Naskenujte QR kód v mobile bankingu</p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-envelope me-2"></i>Email s potvrdzovacími údajmi</h6>
                        <?php if ($emailSent): ?>
                            <p class="mb-0">Na vašu emailovú adresu <strong><?= htmlspecialchars($currentUser['email']) ?></strong> 
                            sme odoslali podrobné pokyny na platbu vrátane QR kódu.</p>
                        <?php else: ?>
                            <p class="mb-0 text-warning">Nepodarilo sa odoslať email s pokynmi. Prosím, uložte si tieto platobné údaje.</p>
                        <?php endif; ?>
                    </div>

                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Dôležité upozornenie</h6>
                        <ul class="mb-0">
                            <li>Platbu prosím uhraďte do <strong>24 hodín</strong> od registrácie</li>
                            <li>Neuhradené registrácie budú automaticky zrušené</li>
                            <li>Po uhradení platby vám príde email s potvrdením</li>
                            <li>Pri problémoch s platbou nás kontaktujte</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <a href="<?= url('pages/workshops.php') ?>" class="btn btn-sage">
                            <i class="fas fa-arrow-left me-2"></i>Späť na workshopy
                        </a>
                        <a href="<?= url('pages/dashboard.php') ?>" class="btn btn-outline-sage ms-2">
                            <i class="fas fa-tachometer-alt me-2"></i>Môj účet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>