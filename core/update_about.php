<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$record = Illuminate\Support\Facades\DB::table('frontends')->where('id', 24)->first();
$data = json_decode($record->data_values, true);

// Old image tag with fixed width
$oldTag = '<img src="https://i.imgur.com/rdYHRaH.png" width="913" alt="rdYHRaH.png" />';
// New responsive image tag
$newTag = '<img src="https://i.imgur.com/rdYHRaH.png" style="max-width: 100%; height: auto;" alt="Certificate of Registration" />';

$data['details'] = str_replace($oldTag, $newTag, $data['details']);

Illuminate\Support\Facades\DB::table('frontends')->where('id', 24)->update([
    'data_values' => json_encode($data)
]);

echo "Database updated successfully\n";
