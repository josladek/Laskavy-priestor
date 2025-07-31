<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireRole(['admin', 'lektor']);

$currentUser = getCurrentUser();
$isAdmin = $currentUser['role'] === 'admin';

// Date range for reports
$startDate = $_GET['start_date'] ?? date('Y-m-01'); // First day of current month
$endDate = $_GET['end_date'] ?? date('Y-m-t'); // Last day of current month

// Validate dates
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
    $startDate = date('Y-m-01');
    $endDate = date('Y-m-t');
}

// Ensure start date is not after end date
if (strtotime($startDate) > strtotime($endDate)) {
    $temp = $startDate;
    $startDate = $endDate;
    $endDate = $temp;
}

// Get statistics based on user role
if ($isAdmin) {
    // Admin can see all data
    $totalClasses = db()->fetchValue("
        SELECT COUNT(*) FROM yoga_classes 
        WHERE date BETWEEN ? AND ?
    ", [$startDate, $endDate]);
    
    $totalRegistrations = db()->fetchValue("
        SELECT COUNT(*) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND cr.status = 'confirmed'
    ", [$startDate, $endDate]);
    
    $totalAttendance = db()->fetchValue("
        SELECT COUNT(*) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND cr.status = 'confirmed' AND cr.attendance_marked = 1
    ", [$startDate, $endDate]);
    
    $totalRevenue = db()->fetchValue("
        SELECT COALESCE(SUM(
            CASE 
                WHEN cr.paid_with_credit = 1 THEN yc.price_with_credit
                ELSE yc.price
            END
        ), 0) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND cr.status = 'confirmed'
    ", [$startDate, $endDate]);
    
    // Popular class types
    $popularTypes = db()->fetchAll("
        SELECT yc.type, COUNT(*) as registrations
        FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND cr.status = 'confirmed'
        GROUP BY yc.type
        ORDER BY registrations DESC
        LIMIT 5
    ", [$startDate, $endDate]);
    
    // Monthly revenue trend
    $monthlyRevenue = db()->fetchAll("
        SELECT 
            DATE_FORMAT(yc.date, '%Y-%m') as month,
            COALESCE(SUM(
                CASE 
                    WHEN cr.paid_with_credit = 1 THEN yc.price_with_credit
                    ELSE yc.price
                END
            ), 0) as revenue
        FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN DATE_SUB(?, INTERVAL 5 MONTH) AND ?
            AND cr.status = 'confirmed'
        GROUP BY DATE_FORMAT(yc.date, '%Y-%m')
        ORDER BY month
    ", [$endDate, $endDate]);
    
} else {
    // Lektor can only see their own classes
    $instructorId = $currentUser['id'];
    
    $totalClasses = db()->fetchValue("
        SELECT COUNT(*) FROM yoga_classes 
        WHERE date BETWEEN ? AND ? AND instructor_id = ?
    ", [$startDate, $endDate, $instructorId]);
    
    $totalRegistrations = db()->fetchValue("
        SELECT COUNT(*) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND yc.instructor_id = ? AND cr.status = 'confirmed'
    ", [$startDate, $endDate, $instructorId]);
    
    $totalAttendance = db()->fetchValue("
        SELECT COUNT(*) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND yc.instructor_id = ? AND cr.status = 'confirmed' AND cr.attendance_marked = 1
    ", [$startDate, $endDate, $instructorId]);
    
    $totalRevenue = db()->fetchValue("
        SELECT COALESCE(SUM(
            CASE 
                WHEN cr.paid_with_credit = 1 THEN yc.price_with_credit
                ELSE yc.price
            END
        ), 0) FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND yc.instructor_id = ? AND cr.status = 'confirmed'
    ", [$startDate, $endDate, $instructorId]);
    
    $popularTypes = db()->fetchAll("
        SELECT yc.type, COUNT(*) as registrations
        FROM class_registrations cr
        JOIN yoga_classes yc ON cr.class_id = yc.id
        WHERE yc.date BETWEEN ? AND ? AND yc.instructor_id = ? AND cr.status = 'confirmed'
        GROUP BY yc.type
        ORDER BY registrations DESC
        LIMIT 5
    ", [$startDate, $endDate, $instructorId]);
    
    $monthlyRevenue = [];
}

$attendanceRate = $totalRegistrations > 0 ? round(($totalAttendance / $totalRegistrations) * 100, 1) : 0;

$pageTitle = 'Reporty a štatistiky';
$currentPage = 'reports';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title">📊 Reporty a štatistiky</h1>
        <div class="d-flex gap-2">
            <button class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </button>
            <button class="btn btn-danger" onclick="exportToPDF()">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4">
        <div class="card-header">
            <h5><i class="fas fa-calendar-alt me-2"></i>Obdobie</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Od dátumu</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="<?= htmlspecialchars($startDate) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Do dátumu</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="<?= htmlspecialchars($endDate) ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Filtrovať
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Rýchle filtre
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="?start_date=<?= date('Y-m-01') ?>&end_date=<?= date('Y-m-t') ?>">Tento mesiac</a></li>
                            <li><a class="dropdown-item" href="?start_date=<?= date('Y-m-01', strtotime('-1 month')) ?>&end_date=<?= date('Y-m-t', strtotime('-1 month')) ?>">Minulý mesiac</a></li>
                            <li><a class="dropdown-item" href="?start_date=<?= date('Y-01-01') ?>&end_date=<?= date('Y-12-31') ?>">Tento rok</a></li>
                            <li><a class="dropdown-item" href="?start_date=<?= date('Y-01-01', strtotime('-1 year')) ?>&end_date=<?= date('Y-12-31', strtotime('-1 year')) ?>">Minulý rok</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-gradient h-100" style="background: linear-gradient(135deg, #e8f5e8, #d4e9d4);">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-dumbbell fa-2x" style="color: #4a7c59;"></i>
                    </div>
                    <h3 class="mb-1" style="color: #2d5016;"><?= $totalClasses ?></h3>
                    <p class="mb-0 small" style="color: #5a6c57;">Celkom lekcií</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-gradient h-100" style="background: linear-gradient(135deg, #fff2e8, #f7e6d3);">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-users fa-2x" style="color: #b8860b;"></i>
                    </div>
                    <h3 class="mb-1" style="color: #8b4513;"><?= $totalRegistrations ?></h3>
                    <p class="mb-0 small" style="color: #a0522d;">Registrácií</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-gradient h-100" style="background: linear-gradient(135deg, #e8f4fd, #d3e9f7);">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-check-circle fa-2x" style="color: #2c5aa0;"></i>
                    </div>
                    <h3 class="mb-1" style="color: #1e3a8a;"><?= $attendanceRate ?>%</h3>
                    <p class="mb-0 small" style="color: #3b5998;">Miera dochádzky</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card bg-gradient h-100" style="background: linear-gradient(135deg, #fce8f3, #f7d6e9);">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-euro-sign fa-2x" style="color: #a855f7;"></i>
                    </div>
                    <h3 class="mb-1" style="color: #7c2d92;"><?= number_format($totalRevenue, 2) ?>€</h3>
                    <p class="mb-0 small" style="color: #8b5a95;">Tržby</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Popular Class Types -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie text-primary me-2"></i>Najobľúbenejšie typy lekcií</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($popularTypes)): ?>
                        <p class="text-muted text-center">Žiadne dáta pre vybrané obdobie.</p>
                    <?php else: ?>
                        <canvas id="popularTypesChart" height="200"></canvas>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue Trend (Admin only) -->
        <?php if ($isAdmin && !empty($monthlyRevenue)): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-chart-line text-success me-2"></i>Trend tržieb</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Detailed Statistics -->
        <div class="<?= ($isAdmin && !empty($monthlyRevenue)) ? 'col-12' : 'col-md-6' ?> mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5><i class="fas fa-list text-info me-2"></i>Detailné štatistiky</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td><strong>Priemerná dochádzka na lekciu</strong></td>
                                    <td><?= $totalClasses > 0 ? round($totalAttendance / $totalClasses, 1) : 0 ?> účastníkov</td>
                                </tr>
                                <tr>
                                    <td><strong>Priemerná tržba na lekciu</strong></td>
                                    <td><?= $totalClasses > 0 ? number_format($totalRevenue / $totalClasses, 2) : '0.00' ?>€</td>
                                </tr>
                                <tr>
                                    <td><strong>Priemerná cena na účastníka</strong></td>
                                    <td><?= $totalRegistrations > 0 ? number_format($totalRevenue / $totalRegistrations, 2) : '0.00' ?>€</td>
                                </tr>
                                <tr>
                                    <td><strong>Obsadenosť lekcií</strong></td>
                                    <td><?= $attendanceRate ?>%</td>
                                </tr>
                                <?php if ($isAdmin): ?>
                                <tr>
                                    <td><strong>Celkový počet aktívnych klientov</strong></td>
                                    <td>
                                        <?= db()->fetchValue("
                                            SELECT COUNT(DISTINCT cr.user_id) 
                                            FROM class_registrations cr
                                            JOIN yoga_classes yc ON cr.class_id = yc.id
                                            WHERE yc.date BETWEEN ? AND ? AND cr.status = 'confirmed'
                                        ", [$startDate, $endDate]) ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($popularTypes)): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Popular Types Chart
    const typesCtx = document.getElementById('popularTypesChart').getContext('2d');
    const typesData = <?= json_encode($popularTypes) ?>;
    
    new Chart(typesCtx, {
        type: 'doughnut',
        data: {
            labels: typesData.map(item => item.type),
            datasets: [{
                data: typesData.map(item => item.registrations),
                backgroundColor: [
                    '#4a7c59', '#8db3a0', '#b8860b', '#2c5aa0', '#a855f7'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    <?php if ($isAdmin && !empty($monthlyRevenue)): ?>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = <?= json_encode($monthlyRevenue) ?>;
    
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => {
                const [year, month] = item.month.split('-');
                const date = new Date(year, month - 1);
                return date.toLocaleDateString('sk-SK', { year: 'numeric', month: 'short' });
            }),
            datasets: [{
                label: 'Tržby (€)',
                data: revenueData.map(item => parseFloat(item.revenue)),
                borderColor: '#4a7c59',
                backgroundColor: 'rgba(74, 124, 89, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '€';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    <?php endif; ?>
});

function exportToExcel() {
    // Create CSV content
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Typ,Registrácií\n";
    
    <?php if (!empty($popularTypes)): ?>
    const typesData = <?= json_encode($popularTypes) ?>;
    typesData.forEach(function(item) {
        csvContent += item.type + "," + item.registrations + "\n";
    });
    <?php endif; ?>
    
    // Download
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "report_<?= $startDate ?>_<?= $endDate ?>.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportToPDF() {
    // Simple approach - print to PDF
    window.print();
}
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>