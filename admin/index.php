<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/AdminAuthController.php';
require_once __DIR__ . '/../app/controllers/AdminNoticeController.php';
require_once __DIR__ . '/../app/controllers/AdminDownloadController.php';
require_once __DIR__ . '/../app/controllers/AdminEmployeeController.php';
require_once __DIR__ . '/../app/controllers/AdminGalleryController.php';
require_once __DIR__ . '/../app/controllers/AdminSettingController.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$authController = new AdminAuthController($config, $db->pdo());
$noticeController = new AdminNoticeController($config, $db->pdo());
$downloadController = new AdminDownloadController($config, $db->pdo());
$employeeController = new AdminEmployeeController($config, $db->pdo());
$galleryController = new AdminGalleryController($config, $db->pdo());
$settingController = new AdminSettingController($config, $db->pdo());

if ($page !== 'login' && !isLoggedIn()) {
    redirect($config['app']['base_url'] . 'admin/index.php?page=login');
}

if ($page === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $authController->login();
    }
    $authController->loginForm();
    exit;
}

if ($page === 'logout') {
    $authController->logout();
}

if ($page === 'dashboard') {
    require __DIR__ . '/../app/views/admin/dashboard/index.php';
    exit;
}

if ($page === 'notices') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($action === 'create') {
            $noticeController->create();
        }
        if ($action === 'update' && $id) {
            $noticeController->update($id);
        }
        if ($action === 'delete' && $id) {
            $noticeController->delete($id);
        }
    }

    if ($action === 'create') {
        $noticeController->createForm();
        exit;
    }

    if ($action === 'edit' && $id) {
        $noticeController->editForm($id);
        exit;
    }

    $noticeController->index();
    exit;
}

if ($page === 'downloads') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
        $downloadController->create();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete' && $id) {
        $downloadController->delete($id);
    }
    $downloadController->index();
    exit;
}

if ($page === 'employees') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
        $employeeController->create();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete' && $id) {
        $employeeController->delete($id);
    }
    $employeeController->index();
    exit;
}

if ($page === 'gallery') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
        $galleryController->createAlbum();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload' && $id) {
        $galleryController->uploadMedia($id);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete' && $id) {
        $galleryController->deleteAlbum($id);
    }

    if ($action === 'view' && $id) {
        $galleryController->viewAlbum($id);
        exit;
    }

    $galleryController->index();
    exit;
}

if ($page === 'settings') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'save') {
        $settingController->save();
    }
    $settingController->index();
    exit;
}

if ($page === 'services') {
    require __DIR__ . '/../app/views/admin/services/index.php';
    exit;
}

redirect($config['app']['base_url'] . 'admin/index.php?page=dashboard');
