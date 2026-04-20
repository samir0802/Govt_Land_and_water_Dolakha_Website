<?php

declare(strict_types=1);

session_start();

$config = require __DIR__ . '/../config/config.php';

date_default_timezone_set($config['app']['timezone']);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers/url.php';
require_once __DIR__ . '/models/BaseModel.php';
require_once __DIR__ . '/controllers/BaseController.php';

$db = null;
$dbError = null;

try {
    $db = new Database($config['db']);

    $requiredTables = ['users', 'notices', 'downloads', 'services', 'employees', 'gallery', 'contact_messages'];
    foreach ($requiredTables as $requiredTable) {
        $statement = $db->pdo()->prepare('SHOW TABLES LIKE :table_name');
        $statement->execute(['table_name' => $requiredTable]);

        if (!$statement->fetchColumn()) {
            throw new RuntimeException(sprintf('Required database table `%s` was not found. Import `database/schema.sql` to finish setup.', $requiredTable));
        }
    }
} catch (Throwable $exception) {
    $dbError = $exception;
}

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}
