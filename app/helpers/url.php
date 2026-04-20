<?php

declare(strict_types=1);

function url(string $path = ''): string
{
    global $config;

    $baseUrl = rtrim($config['app']['base_url'] ?? '', '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

function asset(string $path): string
{
    $docRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
    $assetsPrefix = basename((string) $docRoot) === 'public'
        ? 'assets/'
        : 'public/assets/';

    return url($assetsPrefix . ltrim($path, '/'));
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}
