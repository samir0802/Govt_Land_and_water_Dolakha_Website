<?php

declare(strict_types=1);

$detectedScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$detectedHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$normalizedPath = preg_replace('#/(public|admin)/index\.php$#', '', $scriptName);
$normalizedPath = preg_replace('#/index\.php$#', '', (string) $normalizedPath);
$normalizedPath = rtrim((string) $normalizedPath, '/');
$autoBaseUrl = $detectedScheme . '://' . $detectedHost . ($normalizedPath === '' ? '/' : $normalizedPath . '/');

return [
    'app' => [
        'name_np' => 'नेपाल सरकार | खानेपानी, सिंचाइ तथा जलस्रोत कार्यालय, दोलखा',
        'name_en' => 'Government of Nepal | Land and Water Resources Office, Dolakha',
        'base_url' => getenv('APP_URL') ?: $autoBaseUrl,
        'timezone' => 'Asia/Kathmandu',
    ],
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_NAME') ?: 'dolakha_office',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],
    'security' => [
        'allowed_upload_types' => ['image/jpeg', 'image/png', 'application/pdf'],
        'max_upload_size' => 5 * 1024 * 1024,
    ],
];
