<?php
// Course registration handler in pages/ directory
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/payment_config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/email_functions.php';

// Session je už spustená v config.php
$currentUser = getCurrentUser();

if (!$currentUser) {
    $_SESSION['flash_message'] = 'Pre registráciu na kurz sa musíte prihlásiť.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/login.php'));
    exit;
}

// Only handle POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_message'] = 'Neplatná metóda požiadavky.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/courses.php'));
    exit;
}

$courseId = (int)($_POST['course_id'] ?? 0);

if (!$courseId) {
    $_SESSION['flash_message'] = 'Neplatné ID kurzu.';
    $_SESSION['flash_type'] = 'error';
    header('Location: ' . url('pages/courses.php'));
    exit;
}

try {
    // Get course details
    $course = db()->fetch("
        SELECT c.*, COUNT(cr.id) as registered_count
        FROM courses c
        LEFT JOIN course_registrations cr ON c.id = cr.course_id AND cr.status = 'confirmed'
        WHERE c.id = ?
        GROUP BY c.id
    ", [$courseId]);
    
    if (!$course) {
        throw new Exception('Kurz nenájdený.');
    }
    
    // Check if course is full
    if ($course['registered_count'] >= $course['capacity']) {
        throw new Exception('Kurz je plný.');
    }
    
    // Check if user is already registered (only active registrations)
    $existing = db()->fetch("
        SELECT id, status FROM course_registrations 
        WHERE course_id = ? AND user_id = ? AND status IN ('confirmed', 'pending')
    ", [$courseId, $currentUser['id']]);
    if ($existing) {
        throw new Exception('Na tento kurz ste už prihlásený.');
    }
    
    // Clean up any cancelled registrations before creating new one
    db()->query("
        DELETE FROM course_registrations 
        WHERE course_id = ? AND user_id = ? AND status = 'cancelled'
    ", [$courseId, $currentUser['id']]);
    
    // Get notes from form
    $notes = trim($_POST['notes'] ?? '');
    
    // Course cannot be paid with credit - always requires external payment
    $price = $course['price'];
    $paymentStatus = 'pending';
    
    // Create course registration with basic required columns
    $registrationId = db()->query("
        INSERT INTO course_registrations (course_id, user_id, status, payment_amount, notes)
        VALUES (?, ?, 'confirmed', ?, ?)
    ", [
        $courseId, 
        $currentUser['id'], 
        $price,
        $notes
    ]);
    
    // Create payment request for course
    $variableSymbol = generateVariableSymbol($currentUser['id'], $courseId);
    
    db()->query("
        INSERT INTO payment_requests (user_id, package_id, course_id, amount, eur_amount, variable_symbol, 
                                    status, payment_method, notes, created_at, updated_at) 
        VALUES (?, 'COURSE', ?, ?, ?, ?, 'pending', 'bank_transfer', ?, NOW(), NOW())
    ", [
        $currentUser['id'], 
        $courseId,
        $price, 
        $price, 
        $variableSymbol,
        'Registrácia na kurz: ' . $course['name'] . ($notes ? '; Poznámka: ' . $notes : '')
    ]);
    
    $paymentRequestId = db()->lastInsertId();
    
    // Auto-register for all course lessons
    try {
        $lessons = db()->fetchAll("
            SELECT id FROM yoga_classes 
            WHERE course_id = ? 
            ORDER BY date ASC
        ", [$courseId]);
        
        foreach ($lessons as $lesson) {
            // Check if already registered for this lesson - use registrations table
            $existing = db()->fetch("
                SELECT id FROM registrations 
                WHERE class_id = ? AND user_id = ? AND status IN ('confirmed', 'pending')
            ", [$lesson['id'], $currentUser['id']]);
            
            if (!$existing) {
                // Register for lesson using registrations table
                db()->query("
                    INSERT INTO registrations (class_id, user_id, status, registered_on, paid_with_credit)
                    VALUES (?, ?, 'confirmed', NOW(), 0)
                ", [$lesson['id'], $currentUser['id']]);
            }
        }
    } catch (Exception $lessonError) {
        // Continue even if lesson registration fails - course registration is still valid
        error_log("Course lesson registration failed: " . $lessonError->getMessage());
    }
    
    // Redirect to payment confirmation page like lessons do
    header('Location: ' . url('pages/course-payment-confirmation.php?request_id=' . $paymentRequestId));
    exit;
    
} catch (Exception $e) {
    if (db()->inTransaction()) {
        db()->rollBack();
    }
    
    $_SESSION['flash_message'] = $e->getMessage();
    $_SESSION['flash_type'] = 'error';
    
    // Redirect back to course detail or courses list
    if ($courseId) {
        header('Location: ' . url('pages/course-detail.php?id=' . $courseId));
    } else {
        header('Location: ' . url('pages/courses.php'));
    }
    exit;
}
?>