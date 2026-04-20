<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/NoticeController.php';
require_once __DIR__ . '/../app/controllers/PageController.php';

$page = $_GET['page'] ?? 'home';

if ($dbError instanceof Throwable || $db === null) {
    require __DIR__ . '/../app/views/system/database-error.php';
    exit;
}

$pageController = new PageController($config, $db->pdo());

switch ($page) {
    case 'introduction':
        $pageController->introduction();
        break;
    case 'services':
        $pageController->services();
        break;
    case 'notices':
        (new NoticeController($config, $db->pdo()))->index();
        break;
    case 'publications':
        $pageController->publications();
        break;
    case 'downloads':
        $pageController->downloads();
        break;
    case 'gallery':
        $pageController->gallery();
        break;
    case 'contact':
        $pageController->contact();
        break;
    case 'home':
    default:
        (new HomeController($config, $db->pdo()))->index();
        break;
}
