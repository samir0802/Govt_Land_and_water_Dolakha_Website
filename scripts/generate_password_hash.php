<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Run this command in CLI only.\n");
    exit(1);
}

$password = $argv[1] ?? null;
if (!$password) {
    fwrite(STDERR, "Usage: php scripts/generate_password_hash.php 'YourPasswordHere'\n");
    exit(1);
}

echo password_hash($password, PASSWORD_DEFAULT) . PHP_EOL;
