<?php

/**
 * Standalone Admin Password Reset Script
 * 
 * This script resets admin passwords to "Admin@4560" and logs the hashed password.
 * Works with PHP 7.4+ and doesn't require Laravel bootstrap.
 * 
 * Run with: php reset_admin_passwords_standalone.php
 */

// Try to load .env file if it exists
$envFile = __DIR__ . '/.env';
$dbConfig = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'solvertech_solvershop',
    'username' => 'root',
    'password' => ''
];

if (file_exists($envFile)) {
    $envContent = file_get_contents($envFile);
    preg_match('/DB_HOST=(.+)/', $envContent, $hostMatch);
    preg_match('/DB_PORT=(.+)/', $envContent, $portMatch);
    preg_match('/DB_DATABASE=(.+)/', $envContent, $dbMatch);
    preg_match('/DB_USERNAME=(.+)/', $envContent, $userMatch);
    preg_match('/DB_PASSWORD=(.+)/', $envContent, $passMatch);
    
    if (!empty($hostMatch[1])) $dbConfig['host'] = trim($hostMatch[1]);
    if (!empty($portMatch[1])) $dbConfig['port'] = trim($portMatch[1]);
    if (!empty($dbMatch[1])) $dbConfig['database'] = trim($dbMatch[1]);
    if (!empty($userMatch[1])) $dbConfig['username'] = trim($userMatch[1]);
    if (!empty($passMatch[1])) $dbConfig['password'] = trim($passMatch[1]);
}

echo "========================================\n";
echo "Admin Password Reset Script\n";
echo "========================================\n\n";

$password = 'Admin@4560';
// Use the EXACT same hashing method as Laravel's Hash::make()
// Laravel's BcryptHasher::make() calls: password_hash($value, PASSWORD_BCRYPT, ['cost' => $this->cost($options)])
// Using cost 10 to match existing password format in database ($2y$10$)
// This is the same underlying PHP function that Laravel uses internally
$hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

echo "Generated hashed password: {$hashedPassword}\n\n";

// Connect to database
try {
    $dsn = "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "Connected to database: {$dbConfig['database']}\n\n";
    
    // Update admin with email dembedenisjb@gmail.com
    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE email = ?");
    $result1 = $stmt->execute([$hashedPassword, 'dembedenisjb@gmail.com']);
    $affected1 = $stmt->rowCount();
    
    if ($affected1 > 0) {
        $stmt2 = $pdo->prepare("SELECT username FROM admins WHERE email = ?");
        $stmt2->execute(['dembedenisjb@gmail.com']);
        $admin1 = $stmt2->fetch();
        echo "✓ Password updated for admin: dembedenisjb@gmail.com (username: " . ($admin1['username'] ?? 'N/A') . ")\n";
    } else {
        echo "✗ Admin with email dembedenisjb@gmail.com not found\n";
    }
    
    // Update admin with email sheilla@gmail.com
    $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE email = ?");
    $result2 = $stmt->execute([$hashedPassword, 'sheilla@gmail.com']);
    $affected2 = $stmt->rowCount();
    
    if ($affected2 > 0) {
        $stmt2 = $pdo->prepare("SELECT username FROM admins WHERE email = ?");
        $stmt2->execute(['sheilla@gmail.com']);
        $admin2 = $stmt2->fetch();
        echo "✓ Password updated for admin: sheilla@gmail.com (username: " . ($admin2['username'] ?? 'N/A') . ")\n";
    } else {
        echo "✗ Admin with email sheilla@gmail.com not found\n";
    }
    
    // Log to Laravel log file
    $logFile = __DIR__ . '/storage/logs/laravel.log';
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logEntry = "[" . date('Y-m-d H:i:s') . "] local.INFO: Admin Password Reset - Generated Hash\n";
    $logEntry .= "{\"plain_password\":\"{$password}\",\"hashed_password\":\"{$hashedPassword}\",\"timestamp\":\"" . date('Y-m-d H:i:s') . "\"}\n\n";
    
    file_put_contents($logFile, $logEntry, FILE_APPEND);
    echo "\n✓ Hashed password has been logged to: storage/logs/laravel.log\n";
    
    echo "\n========================================\n";
    echo "Process completed!\n";
    echo "New password for both admins: Admin@4560\n";
    echo "========================================\n";
    
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your database configuration.\n";
    echo "Trying to connect to: {$dbConfig['host']}:{$dbConfig['port']}/{$dbConfig['database']}\n";
    exit(1);
}

