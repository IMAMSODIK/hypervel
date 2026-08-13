<?php

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Illuminate\Support\Facades\Mail::raw('Test OTP via Gmail', function ($m) {
    $m->to('youremail@gmail.com')->subject('OTP Test');
});

echo "Sent\n";