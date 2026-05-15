<?php

declare(strict_types=1);

return [
    'app' => [
        'name_np' => 'भू तथा जलाधार व्यवस्थापन कार्यालय,दोलखा',
        'name_en' => 'Government of Nepal | Land and Water Resources Office, Dolakha',
        'base_url' => getenv('APP_URL') ?: rtrim(
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
            . '://' . $_SERVER['HTTP_HOST']
            . dirname(dirname($_SERVER['SCRIPT_NAME'])),
            '/'
        ) . '/',
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

