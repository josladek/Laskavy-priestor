<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Only admins can view users
requireRole('admin');

$users = db()->fetchAll("
    SELECT u.*, 
           COUNT(r.id) as total_registrations,
           MAX(r.registered_on) as last_registration
    FROM users u
    LEFT JOIN registrations r ON u.id = r.user_id
    GROUP BY u.id, u.name, u.email, u.phone, u.role, u.eur_balance, u.created_at
    ORDER BY u.created_at DESC
");

$currentPage = 'users';
$pageTitle = 'Používatelia';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-charcoal">Používatelia</h1>
                <a href="../admin/dashboard.php" class="btn btn-outline-sage">
                    <i class="fas fa-arrow-left me-2"></i>Späť na dashboard
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Meno</th>
                                    <th>Email</th>
                                    <th>Telefón</th>
                                    <th>Rola</th>
                                    <th>Kredit</th>
                                    <th>Registrácie</th>
                                    <th>Posledná aktivita</th>
                                    <th>Akcie</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <strong><?= e($user['name']) ?></strong>
                                        <br><small class="text-muted">ID: <?= $user['id'] ?></small>
                                    </td>
                                    <td><?= e($user['email']) ?></td>
                                    <td><?= e($user['phone']) ?></td>
                                    <td>
                                        <span class="badge <?= $user['role'] === 'admin' ? 'bg-danger' : ($user['role'] === 'lektor' ? 'bg-warning' : 'bg-info') ?>">
                                            <?= ucfirst($user['role']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user['role'] === 'klient' || $user['role'] === 'student'): ?>
                                            <span class="fw-bold text-sage"><?= formatPrice($user['eur_balance']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?= $user['total_registrations'] ?></span>
                                    </td>
                                    <td>
                                        <?php if ($user['last_registration']): ?>
                                            <small><?= formatDate($user['last_registration']) ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Žiadne</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="../admin/client-detail.php?id=<?= $user['id'] ?>" 
                                               class="btn btn-outline-primary btn-sm">Detail</a>
                                            <?php if ($user['role'] === 'klient' || $user['role'] === 'student'): ?>
                                                <a href="../admin/promote-to-lecturer.php?id=<?= $user['id'] ?>" 
                                                   class="btn btn-outline-warning btn-sm">Povýšiť</a>
                                            <?php elseif ($user['role'] === 'lektor'): ?>
                                                <a href="../admin/demote-lecturer.php?id=<?= $user['id'] ?>" 
                                                   class="btn btn-outline-secondary btn-sm">Degradovať</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>