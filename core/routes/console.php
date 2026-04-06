<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('admin:reset-password', function () {
    $password = 'Admin@4560';
    $hashedPassword = Hash::make($password);
    
    // Log the hashed password
    Log::info('Admin Password Reset - Generated Hash', [
        'plain_password' => $password,
        'hashed_password' => $hashedPassword,
        'timestamp' => now()->toDateTimeString()
    ]);
    
    // Update admin with email dembedenisjb@gmail.com (username: sheillah)
    $admin1 = Admin::where('email', 'dembedenisjb@gmail.com')->first();
    if ($admin1) {
        $admin1->password = $hashedPassword;
        $admin1->save();
        $this->info("Password updated for admin: {$admin1->email} (username: {$admin1->username})");
    } else {
        $this->warn("Admin with email dembedenisjb@gmail.com not found");
    }
    
    // Update admin with email sheilla@gmail.com (username: Atukunda)
    $admin2 = Admin::where('email', 'sheilla@gmail.com')->first();
    if ($admin2) {
        $admin2->password = $hashedPassword;
        $admin2->save();
        $this->info("Password updated for admin: {$admin2->email} (username: {$admin2->username})");
    } else {
        $this->warn("Admin with email sheilla@gmail.com not found");
    }
    
    $this->info("Hashed password has been logged to laravel.log");
    $this->info("Hashed Password: {$hashedPassword}");
    
})->purpose('Reset admin passwords to Admin@4560 and log the hash');
