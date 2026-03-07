<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/NoticeController.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'notices':
        (new NoticeController($config, $db->pdo()))->index();
        break;
    case 'home':
    default:
        (new HomeController($config, $db->pdo()))->index();
        break;
}
