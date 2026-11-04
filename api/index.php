<?php

// Forward Vercel Serverless requests to Laravel's public/index.php

// 1. Ensure required storage directories exist in writable /tmp
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Set default environment variables if not present in Vercel
if (! getenv('APP_KEY')) {
    putenv('APP_KEY=base64:7R1K80lHobj4e5z/ZeRFPlaX6up8m2QQ2ldpTfVnGtE=');
    $_ENV['APP_KEY'] = 'base64:7R1K80lHobj4e5z/ZeRFPlaX6up8m2QQ2ldpTfVnGtE=';
}

if (! getenv('APP_ENV')) {
    putenv('APP_ENV=production');
    $_ENV['APP_ENV'] = 'production';
}

if (! getenv('VIEW_COMPILED_PATH')) {
    putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
    $_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
}

// 3. Setup SQLite database in /tmp
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__.'/../database/database.sqlite';

if (! file_exists($tmpDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $tmpDb);
} elseif (! file_exists($tmpDb)) {
    @touch($tmpDb);
}

putenv('DB_CONNECTION=sqlite');
$_ENV['DB_CONNECTION'] = 'sqlite';
putenv("DB_DATABASE={$tmpDb}");
$_ENV['DB_DATABASE'] = $tmpDb;

// 4. Delegate to Laravel's public/index.php
require __DIR__.'/../public/index.php';
