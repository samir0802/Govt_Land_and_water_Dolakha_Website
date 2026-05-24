<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/AdminAuthController.php';
require_once __DIR__ . '/../app/controllers/AdminNoticeController.php';
require_once __DIR__ . '/../app/controllers/AdminDownloadController.php';
require_once __DIR__ . '/../app/controllers/AdminServiceController.php';
require_once __DIR__ . '/../app/controllers/AdminEmployeeController.php';
require_once __DIR__ . '/../app/controllers/AdminGalleryController.php';
require_once __DIR__ . '/../app/controllers/AdminSettingController.php';
require_once __DIR__ . '/../app/controllers/AdminPublicationController.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$authController = new AdminAuthController($config, $db->pdo());
$noticeController = new AdminNoticeController($config, $db->pdo());
$downloadController = new AdminDownloadController($config, $db->pdo());
$serviceController = new AdminServiceController($config, $db->pdo());
$employeeController = new AdminEmployeeController($config, $db->pdo());
$galleryController = new AdminGalleryController($config, $db->pdo());
$settingController = new AdminSettingController($config, $db->pdo());
$publicationController = new AdminPublicationController($config, $db->pdo());

if ($page !== 'login' && !isLoggedIn()) {
    redirect('admin/index.php?page=login');
}

if ($page === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!verify_csrf_token($_POST['_csrf_token'] ?? null)) {
            $_SESSION['auth_error'] = 'Invalid security token. Please try again.';
            redirect('admin/index.php?page=login');
        }
        $lockedUntil = (int) ($_SESSION['login_locked_until'] ?? 0);
        if ($lockedUntil > time()) {
            $_SESSION['auth_error'] = 'Too many failed attempts. Try again later.';
            redirect('admin/index.php?page=login');
        }
        $authController->login();
    }
    $authController->loginForm();
    exit;
}

if ($page === 'logout') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect('admin/index.php?page=dashboard');
    }
    if (!verify_csrf_token($_POST['_csrf_token'] ?? null)) {
        $_SESSION['admin_error'] = 'Invalid security token for logout.';
        redirect('admin/index.php?page=dashboard');
    }
    $authController->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !verify_csrf_token($_POST['_csrf_token'] ?? null)) {
    $_SESSION['admin_error'] = 'Invalid security token. Please retry your action.';
    $redirectPath = 'admin/index.php?page=' . urlencode((string) $page);
    if ($action !== null && $action !== '') {
        $redirectPath .= '&action=' . urlencode((string) $action);
    }
    if ($id !== null) {
        $redirectPath .= '&id=' . $id;
    }
    redirect($redirectPath);
}

if ($page === 'dashboard') {
    $stats = [
        'notices' => 0,
        'downloads' => 0,
        'employees' => 0,
        'gallery_albums' => 0,
    ];

    foreach (['notices', 'downloads', 'employees'] as $table) {
        $stmt = $db->pdo()->query('SELECT COUNT(*) FROM ' . $table);
        $stats[$table] = (int) $stmt->fetchColumn();
    }

    $galleryTableStmt = $db->pdo()->query(
        "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'gallery_albums'"
    );
    if ((int) $galleryTableStmt->fetchColumn() > 0) {
        $stats['gallery_albums'] = (int) $db->pdo()->query('SELECT COUNT(*) FROM gallery_albums')->fetchColumn();
    } else {
        $stats['gallery_albums'] = (int) $db->pdo()->query('SELECT COUNT(*) FROM gallery')->fetchColumn();
    }

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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
        $serviceController->create();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update' && $id) {
        $serviceController->update($id);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete' && $id) {
        $serviceController->delete($id);
    }
    if ($action === 'edit' && $id) {
        $serviceController->editForm($id);
        exit;
    }

    $serviceController->index();
    exit;
}

if ($page === 'publications') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
        $publicationController->create();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update' && $id) {
        $publicationController->update($id);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete' && $id) {
        $publicationController->delete($id);
    }
    if ($action === 'edit' && $id) {
        $publicationController->editForm($id);
        exit;
    }

    $publicationController->index();
    exit;
}
redirect('admin/index.php?page=dashboard');
