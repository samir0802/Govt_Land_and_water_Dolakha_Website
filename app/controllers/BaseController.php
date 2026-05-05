<?php

declare(strict_types=1);

abstract class BaseController
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    protected function view(string $view, array $data = []): void
    {
        if (!function_exists('lang')) {
            function lang(): string
            {
                $value = $_SESSION['lang'] ?? 'np';
                return in_array($value, ['np', 'en'], true) ? $value : 'np';
            }
        }

        if (!function_exists('trField')) {
            function trField(array $row, string $baseKey): string
            {
                $current = lang();
                $primary = $row[$baseKey . '_' . $current] ?? '';
                $fallback = $row[$baseKey . '_np'] ?? '';

                return trim((string) ($primary !== '' ? $primary : $fallback));
            }
        }

        extract($data);
        require __DIR__ . '/../views/' . $view . '.php';
    }
}
