<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = Illuminate\Support\Facades\DB::table('frontends')->where('id', 24)->value('data_values');
file_put_contents('about_content_raw.json', $data);
echo "Content exported successfully\n";
