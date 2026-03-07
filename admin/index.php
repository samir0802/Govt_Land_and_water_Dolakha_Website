<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/controllers/AdminAuthController.php';
require_once __DIR__ . '/../app/controllers/AdminNoticeController.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$authController = new AdminAuthController($config, $db->pdo());
$noticeController = new AdminNoticeController($config, $db->pdo());

if ($page !== 'login' && !isLoggedIn()) {
    redirect('/admin/index.php?page=login');
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

$placeholderViews = ['downloads', 'services', 'employees', 'gallery', 'settings'];
if (in_array($page, $placeholderViews, true)) {
    require __DIR__ . '/../app/views/admin/' . $page . '/index.php';
    exit;
}

redirect('/admin/index.php?page=dashboard');
