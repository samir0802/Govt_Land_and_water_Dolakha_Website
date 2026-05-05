<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config/config.php';

date_default_timezone_set($config['app']['timezone']);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/controllers/BaseController.php';

$db = new Database($config['db']);

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        global $config;
        return rtrim($config['app']['base_url'], '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return url('public/assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('e')) {
    function e(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        $target = preg_match('#^https?://#i', $path) ? $path : url($path);
        header('Location: ' . $target);
        exit;
    }
}

if (!function_exists('loadSettings')) {
    function loadSettings(PDO $pdo): array
    {
        $stmt = $pdo->query("SHOW TABLES LIKE 'site_settings'");
        if (!(bool) $stmt->fetchColumn()) {
            return [];
        }

        return $pdo->query('SELECT setting_key, setting_value FROM site_settings')->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
    }
}

$siteSettings = loadSettings($db->pdo());

if (!function_exists('setting')) {
    function setting(string $key, ?string $default = null): ?string
    {
        global $siteSettings;
        return $siteSettings[$key] ?? $default;
    }
}
