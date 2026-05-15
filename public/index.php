<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/NoticeController.php';
require_once __DIR__ . '/../app/controllers/GalleryController.php';

if (isset($_GET['set_lang']) && in_array($_GET['set_lang'], ['np', 'en'], true)) {
    $_SESSION['lang'] = $_GET['set_lang'];
    $returnTo = $_GET['return_to'] ?? 'home';
    redirect('public/index.php?page=' . urlencode((string) $returnTo));
}

$page = $_GET['page'] ?? 'home';
$homeController = new HomeController($config, $db->pdo());

switch ($page) {
    case 'introduction':
        $homeController->introduction();
        break;
    case 'services':
        $homeController->services();
        break;
    case 'publications':
        $homeController->publications();
        break;
    case 'downloads':
        $homeController->downloads();
        break;
    case 'contact':
        $homeController->contact();
        break;
    case 'notices':
        (new NoticeController($config, $db->pdo()))->index();
        break;
    case 'gallery':
        (new GalleryController($config, $db->pdo()))->index();
        break;
    case 'home':
    default:
        
        $homeController->index();
        break;
}

