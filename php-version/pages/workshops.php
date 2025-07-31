<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Get filter parameters
$filters = [
    'category' => $_GET['category'] ?? 'all',
    'level' => $_GET['level'] ?? 'all',
    'date_from' => $_GET['date_from'] ?? date('Y-m-d')
];

// Get available categories and levels for filters
$categories = db()->fetchAll("SELECT DISTINCT category FROM workshops WHERE status = 'active' AND date >= CURDATE() ORDER BY category");
$levels = db()->fetchAll("SELECT DISTINCT level FROM workshops WHERE status = 'active' AND date >= CURDATE() ORDER BY level");

// Build query with filters
$whereConditions = ["w.status = 'active'", "w.date >= CURDATE()"];
$params = [];

if ($filters['category'] !== 'all') {
    $whereConditions[] = "w.category = ?";
    $params[] = $filters['category'];
}

if ($filters['level'] !== 'all') {
    $whereConditions[] = "w.level = ?";
    $params[] = $filters['level'];
}

if ($filters['date_from']) {
    $whereConditions[] = "w.date >= ?";
    $params[] = $filters['date_from'];
}

$whereClause = implode(' AND ', $whereConditions);

// Get current user ID if logged in
$currentUserId = isLoggedIn() ? getCurrentUser()['id'] : null;

// Get workshops without any JOINs first - ultra simple
$workshops = db()->fetchAll("
    SELECT DISTINCT w.* FROM workshops w
    WHERE $whereClause
    ORDER BY w.date ASC, w.id ASC
", $params);

// Process each workshop separately to avoid reference issues
for ($i = 0; $i < count($workshops); $i++) {
    // Add instructor name
    if (!empty($workshops[$i]['custom_instructor_name'])) {
        $workshops[$i]['lektor_name'] = $workshops[$i]['custom_instructor_name'];
    } else if (!empty($workshops[$i]['instructor_id'])) {
        $instructor = db()->fetch("SELECT name FROM users WHERE id = ?", [$workshops[$i]['instructor_id']]);
        $workshops[$i]['lektor_name'] = $instructor ? $instructor['name'] : 'Neznámy lektor';
    } else {
        $workshops[$i]['lektor_name'] = 'Neznámy lektor';
    }
    
    // Add registration counts
    $counts = db()->fetch("
        SELECT 
            COUNT(CASE WHEN wr.status = 'confirmed' THEN 1 END) as registered_count,
            COUNT(CASE WHEN wr.status = 'waitlisted' THEN 1 END) as waitlist_count
        FROM workshop_registrations wr 
        WHERE wr.workshop_id = ?
    ", [$workshops[$i]['id']]);
    
    $workshops[$i]['registered_count'] = $counts['registered_count'] ?? 0;
    $workshops[$i]['waitlist_count'] = $counts['waitlist_count'] ?? 0;
    
    // Add user registration status
    if ($currentUserId) {
        $userRegistration = db()->fetch("
            SELECT status FROM workshop_registrations 
            WHERE workshop_id = ? AND user_id = ? AND status IN ('confirmed', 'waitlisted', 'pending')
        ", [$workshops[$i]['id'], $currentUserId]);
        
        $workshops[$i]['user_registration_status'] = $userRegistration ? $userRegistration['status'] : null;
    } else {
        $workshops[$i]['user_registration_status'] = null;
    }
}

$currentPage = 'workshops';
$pageTitle = 'Workshopy';
?>

<?php include '../includes/header.php'; ?>

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Workshopy</h1>
        <p class="lead text-muted">Špeciálne jogové workshopy pre hlbšie porozumenie</p>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="category" class="form-label">Kategória</label>
                    <select class="form-select" id="category" name="category">
                        <option value="all" <?= $filters['category'] === 'all' ? 'selected' : '' ?>>Všetky kategórie</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= e($category['category']) ?>" <?= $filters['category'] === $category['category'] ? 'selected' : '' ?>>
                                <?= $category['category'] === 'General' ? 'Všeobecný' : 
                                   ($category['category'] === 'Meditation' ? 'Meditácia' : 
                                   ($category['category'] === 'Breathwork' ? 'Dýchacie techniky' : 
                                   ($category['category'] === 'Philosophy' ? 'Filozofia' : 
                                   ($category['category'] === 'Anatomy' ? 'Anatómia' : 
                                   ($category['category'] === 'Advanced Practice' ? 'Pokročilá prax' : e($category['category'])))))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="level" class="form-label">Úroveň</label>
                    <select class="form-select" id="level" name="level">
                        <option value="all" <?= $filters['level'] === 'all' ? 'selected' : '' ?>>Všetky úrovne</option>
                        <?php foreach ($levels as $level): ?>
                            <option value="<?= e($level['level']) ?>" <?= $filters['level'] === $level['level'] ? 'selected' : '' ?>>
                                <?= $level['level'] === 'All Levels' ? 'Všetky úrovne' : 
                                   ($level['level'] === 'Beginner' ? 'Začiatočník' : 
                                   ($level['level'] === 'Intermediate' ? 'Stredne pokročilý' : 
                                   ($level['level'] === 'Advanced' ? 'Pokročilý' : e($level['level'])))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Od dátumu</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="<?= e($filters['date_from']) ?>" min="<?= date('Y-m-d') ?>">
                </div>
                
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i> Filtrovať
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Workshops Grid -->
    <?php if (!empty($workshops)): ?>
        <div class="row g-4">
            <?php foreach ($workshops as $workshop): ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="card h-100 workshop-card">
                        <?php if ($workshop['image_url']): ?>
                            <img src="<?= url('uploads/workshops/' . $workshop['image_url']) ?>" class="card-img-top" alt="<?= e($workshop['title']) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <svg width="80" height="80" viewBox="0 0 100 100">
                                    <defs>
                                        <linearGradient id="workshop-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:var(--sage);stop-opacity:0.3" />
                                            <stop offset="100%" style="stop-color:var(--sage-dark);stop-opacity:0.6" />
                                        </linearGradient>
                                    </defs>
                                    <circle cx="50" cy="50" r="35" fill="none" stroke="url(#workshop-gradient)" stroke-width="3"/>
                                    <path d="M30 40 Q50 20, 70 40 Q50 60, 30 40" fill="url(#workshop-gradient)"/>
                                    <circle cx="50" cy="50" r="8" fill="var(--sage)"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-secondary"><?= e($workshop['category']) ?></span>
                                    <span class="badge bg-outline-secondary"><?= e($workshop['level']) ?></span>
                                </div>
                                <?php if ($workshop['user_registration_status']): ?>
                                    <span class="badge bg-success">
                                        <?php if ($workshop['user_registration_status'] === 'confirmed'): ?>
                                            Prihlásený
                                        <?php elseif ($workshop['user_registration_status'] === 'waitlisted'): ?>
                                            Čakacia listina
                                        <?php else: ?>
                                            Pending
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <h5 class="card-title"><?= e($workshop['title']) ?></h5>
                            <p class="card-text text-muted"><?= e(substr($workshop['description'], 0, 100)) ?>...</p>
                            
                            <div class="workshop-details mb-3">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-user-graduate me-2 text-sage"></i>
                                    <span><?= e($workshop['lektor_name']) ?></span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-calendar me-2 text-sage"></i>
                                    <span><?= formatDate($workshop['date']) ?></span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-clock me-2 text-sage"></i>
                                    <span><?= formatTime($workshop['time_start']) ?> - <?= formatTime($workshop['time_end']) ?> (<?= $workshop['duration_hours'] ?>h)</span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-map-marker-alt me-2 text-sage"></i>
                                    <span><?= e($workshop['location']) ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2 text-sage"></i>
                                    <span>
                                        <?= $workshop['registered_count'] ?>/<?= $workshop['capacity'] ?> účastníkov
                                        <?php if ($workshop['waitlist_count'] > 0): ?>
                                            <small class="text-warning">(+<?= $workshop['waitlist_count'] ?> čaká)</small>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>

                            <?php if ($workshop['materials_included']): ?>
                                <div class="materials mb-2">
                                    <small class="text-muted">
                                        <strong>V cene:</strong> <?= e($workshop['materials_included']) ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="price">
                                        <?php if ($workshop['is_free'] || $workshop['price'] == 0): ?>
                                            <span class="h5 text-success mb-0">BEZPLATNE</span>
                                        <?php else: ?>
                                            <span class="h5 text-primary mb-0"><?= formatPrice($workshop['price']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <?php if ($workshop['user_registration_status']): ?>
                                            <?php if ($workshop['user_registration_status'] === 'confirmed'): ?>
                                                <span class="text-success fw-bold">
                                                    <i class="fas fa-check-circle me-1"></i> Zaregistrovaný
                                                </span>
                                            <?php elseif ($workshop['user_registration_status'] === 'waitlisted'): ?>
                                                <span class="text-warning fw-bold">
                                                    <i class="fas fa-clock me-1"></i> Na čakacej listine
                                                </span>
                                            <?php else: ?>
                                                <span class="text-info fw-bold">
                                                    <i class="fas fa-hourglass-half me-1"></i> Čaká na potvrdenie
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($workshop['registered_count'] >= $workshop['capacity']): ?>
                                                <button class="btn btn-warning" disabled>
                                                    <i class="fas fa-list me-1"></i> Čakacia listina
                                                </button>
                                            <?php else: ?>
                                                <?php if (isLoggedIn()): ?>
                                                    <a href="<?= url('pages/workshop-registration-confirm.php?id=' . $workshop['id']) ?>" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-money-bill me-1"></i> Registrovať
                                                    </a>
                                                    <br>
                                                    <small class="text-info">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        <?php if ($workshop['is_free'] || $workshop['price'] == 0): ?>
                                                            Bezplatný workshop
                                                        <?php else: ?>
                                                            Platba bankovým prevodom
                                                        <?php endif; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <a href="<?= url('pages/login.php') ?>" class="btn btn-outline-primary">
                                                        Prihlásiť sa
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Žiadne workshopy</h4>
            <p class="text-muted">Momentálne nie sú naplánované žiadne workshopy podľa vašich kritérií.</p>
            <a href="workshops.php" class="btn btn-outline-primary">Zobraziť všetky workshopy</a>
        </div>
    <?php endif; ?>
</div>

<!-- CSS moved to laskavypriestor.css -->

<?php include '../includes/footer.php'; ?>