<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config/config.php';

date_default_timezone_set($config['app']['timezone']);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/controllers/BaseController.php';

$db = new Database($config['db']);

function asset(string $path): string
{
    return '/assets/' . ltrim($path, '/');
}

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}
