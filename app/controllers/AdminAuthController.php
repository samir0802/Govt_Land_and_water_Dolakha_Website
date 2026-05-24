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
            session_regenerate_id(true);
            rotate_csrf_token();
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['login_attempts'] = 0;
            $_SESSION['login_locked_until'] = null;
            redirect('admin/index.php?page=dashboard');
        }

        $_SESSION['login_attempts'] = (int) ($_SESSION['login_attempts'] ?? 0) + 1;
        if ($_SESSION['login_attempts'] >= 5) {
            $_SESSION['login_locked_until'] = time() + (10 * 60);
        }
        $_SESSION['auth_error'] = 'Invalid credentials';
        redirect('admin/index.php?page=login');
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
        }
        session_destroy();
        session_start();
        session_regenerate_id(true);
        rotate_csrf_token();
        redirect('admin/index.php?page=login');
    }
}
