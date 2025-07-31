<?php
// Testovací súbor pre email verifikáciu
require_once 'php-version/config/config.php';
require_once 'php-version/config/database.php';
require_once 'php-version/includes/functions.php';
require_once 'php-version/includes/email_functions.php';

// Test email verifikácie
function testEmailVerification() {
    $testEmail = 'test@example.com';
    $testName = 'Test User';
    $testToken = bin2hex(random_bytes(32));
    
    echo "<h2>🧪 Test Email Verifikácie</h2>";
    echo "<p><strong>Email:</strong> $testEmail</p>";
    echo "<p><strong>Meno:</strong> $testName</p>";
    echo "<p><strong>Token:</strong> " . substr($testToken, 0, 20) . "...</p>";
    
    // Test odoslania emailu
    try {
        $result = sendEmailVerification($testEmail, $testName, $testToken);
        
        if ($result) {
            echo "<div style='color: green;'>✅ Email verifikácia úspešne odoslaná!</div>";
        } else {
            echo "<div style='color: red;'>❌ Chyba pri odosielaní email verifikácie</div>";
        }
        
        // Zobraz vygenerovaný HTML pre kontrolu
        $html = generateEmailVerificationHtml($testName, 'https://www.laskavypriestor.eu/pages/verify-email.php?token=' . urlencode($testToken));
        echo "<h3>Vygenerovaný HTML:</h3>";
        echo "<textarea style='width: 100%; height: 200px;'>" . htmlspecialchars($html) . "</textarea>";
        
    } catch (Exception $e) {
        echo "<div style='color: red;'>❌ Výnimka: " . $e->getMessage() . "</div>";
    }
}

// Test základnej email funkcie
function testBasicEmail() {
    echo "<h2>📧 Test základnej email funkcie</h2>";
    
    $testSubject = "Test Email - Láskavý Priestor";
    $testBody = "<h1>Test Email</h1><p>Toto je testovací email z yoga štúdia.</p>";
    $testEmail = "test@example.com";
    
    try {
        $result = sendEmail($testEmail, $testSubject, $testBody);
        
        if ($result) {
            echo "<div style='color: green;'>✅ Základný email úspešne odoslaný!</div>";
        } else {
            echo "<div style='color: red;'>❌ Chyba pri odosielaní základného emailu</div>";
        }
        
    } catch (Exception $e) {
        echo "<div style='color: red;'>❌ Výnimka: " . $e->getMessage() . "</div>";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Test - Láskavý Priestor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #8db3a0; }
        div { padding: 10px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>🧘‍♀️ Email System Test - Láskavý Priestor</h1>
    
    <?php
    testBasicEmail();
    echo "<hr>";
    testEmailVerification();
    ?>
    
    <h2>📝 Poznámky pre debugging:</h2>
    <ul>
        <li>Skontrolujte PHP error log pre detaily</li>
        <li>Overte nastavenie mail() funkcie na serveri</li>
        <li>Skontrolujte SMTP nastavenia ak používate externí provider</li>
        <li>Možno budete potrebovať konfigurovať sendmail alebo postfix</li>
    </ul>
    
    <h2>🔧 Riešenie problémov:</h2>
    <ul>
        <li><strong>mail() vracia false:</strong> Server nemá nakonfigurovaný email systém</li>
        <li><strong>Email sa nedostane:</strong> Môže byť v spam priečinku</li>
        <li><strong>Session warnings:</strong> Už opravené v config.php</li>
    </ul>
</body>
</html>