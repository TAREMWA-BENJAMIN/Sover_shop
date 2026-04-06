<?php

/**
 * Admin Password Reset Script
 * 
 * This script resets admin passwords to "Admin@4560" and logs the hashed password.
 * Run with: php reset_admin_passwords.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

echo "========================================\n";
echo "Admin Password Reset Script\n";
echo "========================================\n\n";

$password = 'Admin@4560';
$hashedPassword = Hash::make($password);

// Log the hashed password
Log::info('Admin Password Reset - Generated Hash', [
    'plain_password' => $password,
    'hashed_password' => $hashedPassword,
    'timestamp' => now()->toDateTimeString()
]);

echo "Generated hashed password: {$hashedPassword}\n";
echo "Password has been logged to: storage/logs/laravel.log\n\n";

// Update admin with email dembedenisjb@gmail.com (username: sheillah)
$admin1 = Admin::where('email', 'dembedenisjb@gmail.com')->first();
if ($admin1) {
    $admin1->password = $hashedPassword;
    $admin1->save();
    echo "✓ Password updated for admin: {$admin1->email} (username: {$admin1->username})\n";
} else {
    echo "✗ Admin with email dembedenisjb@gmail.com not found\n";
}

// Update admin with email sheilla@gmail.com (username: Atukunda)
$admin2 = Admin::where('email', 'sheilla@gmail.com')->first();
if ($admin2) {
    $admin2->password = $hashedPassword;
    $admin2->save();
    echo "✓ Password updated for admin: {$admin2->email} (username: {$admin2->username})\n";
} else {
    echo "✗ Admin with email sheilla@gmail.com not found\n";
}

echo "\n========================================\n";
echo "Process completed!\n";
echo "New password for both admins: Admin@4560\n";
echo "========================================\n";

