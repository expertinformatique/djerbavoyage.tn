<?php
namespace App\Controllers\Admin;

use Core\Controller;
use Core\Security;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UsersAdminController extends Controller {
    public function __construct(private UserRepositoryInterface $userRepo) {}

    private function requireAuth(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }
    }

    public function index(): void {
        $this->requireAuth();
        $page  = max(1, (int)($_GET['page'] ?? 1));
        $limit = 10;

        $data  = $this->userRepo->getPaginated($page, $limit);
        $total = $data['total'] ?? 0;

        $flashSuccess = $_SESSION['admin_flash_success'] ?? null;
        $flashError   = $_SESSION['admin_flash_error'] ?? null;
        unset($_SESSION['admin_flash_success'], $_SESSION['admin_flash_error']);

        $this->render('admin/users', [
            'users'        => $data['items'] ?? [],
            'total'        => $total,
            'page'         => $page,
            'limit'        => $limit,
            'totalPages'   => $total > 0 ? (int)ceil($total / $limit) : 1,
            'currentAdmin' => $_SESSION['admin_user'] ?? '',
            'flashSuccess' => $flashSuccess,
            'flashError'   => $flashError
        ], 'layouts/admin');
    }

    public function create(): void {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
        }

        $username = trim(Security::sanitize($_POST['username'] ?? ''));
        $email    = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $password = $_POST['password'] ?? '';
        $role     = trim(Security::sanitize($_POST['role'] ?? 'admin'));

        if (strlen($username) < 3 || !preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $_SESSION['admin_flash_error'] = "Identifiant invalide (min 3 caractères alphanumériques).";
            $this->redirect('/admin/users');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['admin_flash_error'] = "Adresse e-mail invalide.";
            $this->redirect('/admin/users');
        }

        if (strlen($password) < 6) {
            $_SESSION['admin_flash_error'] = "Le mot de passe doit contenir au moins 6 caractères.";
            $this->redirect('/admin/users');
        }

        if (!in_array($role, ['admin', 'editor', 'agent'])) {
            $role = 'admin';
        }

        if ($this->userRepo->findByUsername($username)) {
            $_SESSION['admin_flash_error'] = "Cet identifiant est déjà utilisé.";
            $this->redirect('/admin/users');
        }

        if ($this->userRepo->findByEmail($email)) {
            $_SESSION['admin_flash_error'] = "Cette adresse e-mail est déjà associée à un compte.";
            $this->redirect('/admin/users');
        }

        $user = new User(
            id: null,
            username: $username,
            email: $email,
            password: password_hash($password, PASSWORD_BCRYPT),
            role: $role
        );

        if ($this->userRepo->create($user)) {
            $_SESSION['admin_flash_success'] = "Utilisateur {$username} créé avec succès.";
        } else {
            $_SESSION['admin_flash_error'] = "Erreur lors de la création de l'utilisateur.";
        }

        $this->redirect('/admin/users');
    }

    public function update(): void {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/users');
        }

        $id       = (int)($_POST['id'] ?? 0);
        $username = trim(Security::sanitize($_POST['username'] ?? ''));
        $email    = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $password = trim($_POST['password'] ?? '');
        $role     = trim(Security::sanitize($_POST['role'] ?? 'admin'));

        $user = $this->userRepo->findById($id);
        if (!$user) {
            $_SESSION['admin_flash_error'] = "Utilisateur introuvable.";
            $this->redirect('/admin/users');
        }

        if (strlen($username) < 3) {
            $_SESSION['admin_flash_error'] = "Identifiant trop court.";
            $this->redirect('/admin/users');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['admin_flash_error'] = "Adresse e-mail invalide.";
            $this->redirect('/admin/users');
        }

        // Vérification unicité username
        $existingUser = $this->userRepo->findByUsername($username);
        if ($existingUser && $existingUser->id !== $id) {
            $_SESSION['admin_flash_error'] = "Cet identifiant est déjà pris par un autre compte.";
            $this->redirect('/admin/users');
        }

        // Vérification unicité email
        $existingEmail = $this->userRepo->findByEmail($email);
        if ($existingEmail && $existingEmail->id !== $id) {
            $_SESSION['admin_flash_error'] = "Cet e-mail est déjà utilisé par un autre compte.";
            $this->redirect('/admin/users');
        }

        $user->username = $username;
        $user->email    = $email;
        $user->role     = in_array($role, ['admin', 'editor', 'agent']) ? $role : $user->role;

        $newPasswordHash = null;
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $_SESSION['admin_flash_error'] = "Le nouveau mot de passe doit comporter au moins 6 caractères.";
                $this->redirect('/admin/users');
            }
            $newPasswordHash = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($this->userRepo->update($user, $newPasswordHash)) {
            if ($_SESSION['admin_user'] === $user->username) {
                $_SESSION['admin_user'] = $username;
            }
            $_SESSION['admin_flash_success'] = "Utilisateur {$username} mis à jour.";
        } else {
            $_SESSION['admin_flash_error'] = "Erreur lors de la mise à jour.";
        }

        $this->redirect('/admin/users');
    }

    public function delete(): void {
        $this->requireAuth();

        $id = (int)($_POST['id'] ?? 0);
        $user = $this->userRepo->findById($id);

        if (!$user) {
            $_SESSION['admin_flash_error'] = "Utilisateur introuvable.";
            $this->redirect('/admin/users');
        }

        if ($user->username === ($_SESSION['admin_user'] ?? '')) {
            $_SESSION['admin_flash_error'] = "Action interdite : vous ne pouvez pas supprimer votre propre compte connecté.";
            $this->redirect('/admin/users');
        }

        if ($this->userRepo->count() <= 1) {
            $_SESSION['admin_flash_error'] = "Action impossible : au moins un compte administrateur doit être conservé.";
            $this->redirect('/admin/users');
        }

        if ($this->userRepo->delete($id)) {
            $_SESSION['admin_flash_success'] = "Compte {$user->username} supprimé avec succès.";
        } else {
            $_SESSION['admin_flash_error'] = "Erreur lors de la suppression du compte.";
        }

        $this->redirect('/admin/users');
    }
}
