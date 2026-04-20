<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/User.php';

class AdminAuthController extends BaseController
{
    private User $userModel;

    public function __construct(array $config, PDO $db)
    {
        parent::__construct($config);
        $this->userModel = new User($db);
    }

    public function loginForm(): void
    {
        $this->view('admin/auth/login', ['config' => $this->config]);
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect(url('admin/index.php?page=dashboard'));
        }

        $_SESSION['auth_error'] = 'Invalid credentials';
        redirect(url('admin/index.php?page=login'));
    }

    public function logout(): void
    {
        session_destroy();
        redirect(url('admin/index.php?page=login'));
    }
}
