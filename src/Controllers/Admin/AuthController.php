<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Database;
use Core\Security;

class AuthController extends Controller {
    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = Security::sanitize($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user OR email = :user");
            $stmt->execute(['user' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged'] = true;
                $_SESSION['admin_user'] = $user['username'];
                session_regenerate_id(true);
                $this->redirect('/admin/dashboard');
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        $this->render('admin/login', [
            'error' => $error ?? null
        ], 'layouts/admin');
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        $this->redirect('/admin/login');
    }
}