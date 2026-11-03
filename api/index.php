<?php

// Pastikan folder writable di /tmp tersedia untuk cache Blade view, session, dan log di lingkungan serverless Vercel
$directories = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';

