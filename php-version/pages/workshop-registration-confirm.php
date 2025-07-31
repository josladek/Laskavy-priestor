<?php
// Workshop registration confirmation page
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$currentUser = getCurrentUser();

if (!$currentUser) {
    $_SESSION['flash_message'] = 'Pre registráciu na workshop sa musíte prihlásiť.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/login.php'));
    exit;
}

$workshopId = (int)($_GET['id'] ?? 0);

if (!$workshopId) {
    $_SESSION['flash_message'] = 'Neplatné ID workshopu.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/workshops.php'));
    exit;
}

try {
    // Get workshop details with instructor name - prioritize custom_instructor_name
    $workshop = db()->fetch("
        SELECT w.*, 
               COALESCE(NULLIF(w.custom_instructor_name, ''), u.name) as lektor_name,
               COUNT(wr.id) as registered_count
        FROM workshops w
        LEFT JOIN users u ON w.instructor_id = u.id
        LEFT JOIN workshop_registrations wr ON w.id = wr.workshop_id AND wr.status = 'confirmed'
        WHERE w.id = ?
        GROUP BY w.id
    ", [$workshopId]);
    
    if (!$workshop) {
        throw new Exception('Workshop nenájdený.');
    }
    
    // Check if user is already registered
    $existing = db()->fetch("
        SELECT id FROM workshop_registrations 
        WHERE workshop_id = ? AND user_id = ? AND status = 'confirmed'
    ", [$workshopId, $currentUser['id']]);
    
    if ($existing) {
        throw new Exception('Na tento workshop ste už prihlásený.');
    }
    
    // Check if workshop is full
    if ($workshop['registered_count'] >= $workshop['capacity']) {
        throw new Exception('Workshop je plný.');
    }
    
    // Calculate price - workshops have single price, no credit option
    $price = $workshop['price'];
    
} catch (Exception $e) {
    $_SESSION['flash_message'] = $e->getMessage();
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/workshops.php'));
    exit;
}

$pageTitle = 'Potvrdenie registrácie - ' . $workshop['title'];
$currentPage = 'workshops';
?>

<?php include '../includes/header.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back button -->
            <div class="mb-4">
                <a href="<?= url('pages/workshops.php') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Späť na workshopy
                </a>
            </div>
            
            <!-- Workshop details card -->
            <div class="card mb-4">
                <?php if ($workshop['image_url']): ?>
                    <img src="<?= url('uploads/workshops/' . $workshop['image_url']) ?>" class="card-img-top" alt="<?= e($workshop['title']) ?>" style="height: 250px; object-fit: cover;">
                <?php endif; ?>
                
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-2">Potvrdenie registrácie na workshop</h1>
                        <p class="text-muted">Skontrolujte detaily workshopu pred potvrdením registrácie</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title fw-bold mb-3"><?= e($workshop['title']) ?></h4>
                            
                            <div class="workshop-details mb-4">
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Dátum:</strong></div>
                                    <div class="col-8"><?= formatDate($workshop['date']) ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Čas:</strong></div>
                                    <div class="col-8"><?= formatTime($workshop['time_start']) ?> - <?= formatTime($workshop['time_end']) ?></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Trvanie:</strong></div>
                                    <div class="col-8"><?= (int)$workshop['duration_hours'] ?> hodín</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Kapacita:</strong></div>
                                    <div class="col-8"><?= (int)$workshop['registered_count'] ?>/<?= (int)$workshop['capacity'] ?> prihlásených</div>
                                </div>
                                <?php if ($workshop['level']): ?>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Úroveň:</strong></div>
                                    <div class="col-8"><span class="badge bg-sage"><?= e($workshop['level']) ?></span></div>
                                </div>
                                <?php endif; ?>
                                <?php if ($workshop['lektor_name']): ?>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Lektor:</strong></div>
                                    <div class="col-8"><?= e($workshop['lektor_name']) ?></div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($workshop['description']): ?>
                                <div class="mb-4">
                                    <h6 class="fw-bold">Popis workshopu:</h6>
                                    <p class="text-muted"><?= e($workshop['description']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-4">
                            <!-- Payment info -->
                            <div class="bg-light p-3 rounded mb-3">
                                <h6 class="fw-bold mb-3">Platobné informácie</h6>
                                
                                <div class="alert alert-info mb-3">
                                    <i class="fas fa-university me-1"></i>
                                    <strong>Bankový prevod</strong>
                                </div>
                                <div class="text-center">
                                    <div class="text-muted small">Cena workshopu</div>
                                    <div class="h4 text-primary"><?= formatPrice($price) ?></div>
                                    <div class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Platba bankovým prevodom alebo v hotovosti
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Registration form -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Dokončenie registrácie</h5>
                    
                    <form method="POST" action="<?= url('pages/register-workshop.php') ?>">
                        <input type="hidden" name="workshop_id" value="<?= $workshopId ?>">
                        <input type="hidden" name="confirmed" value="1">
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Poznámka (nepovinné)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Máte nejaké špecifické požiadavky alebo poznámky ku workshopu?"></textarea>
                            <div class="form-text">Vaša poznámka bude viditeľná administrátorovi.</div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Informácia o platbe:</strong> Po potvrdení registrácie budete presmerovaný na stránku s platobými údajmi a QR kódom. Platobné pokyny budú odoslané aj na váš email.
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= url('pages/workshops.php') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Zrušiť
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-1"></i>Potvrdiť registráciu za <?= formatPrice($price) ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>