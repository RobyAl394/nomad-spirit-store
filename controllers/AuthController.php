<?php
require_once __DIR__ . '/../models/User.php';
class AuthController
{
    private PDO $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function login()
    {
        $userModel = new User($this->pdo);
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                $error = 'Ce champ est obligatoire.';
            } else {
                $user = $userModel->findByEmail($email);

                if ($user && $userModel->verifyPassword($password, $user['password'])) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header('Location: index.php?page=admin');
                    } else {
                        header('Location: index.php?page=home&msg=login');
                    }
                    exit;
                } else {
                    $error = 'Email ou mot de passe incorrect.';
                }
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function signup()
    {
        $userModel = new User($this->pdo);
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';
            $phone    = trim($_POST['phone'] ?? '');

            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Ce champ est obligatoire.';
            } elseif ($password !== $confirm) {
                $error = 'Les mots de passe ne correspondent pas.';
            } elseif ($userModel->findByEmail($email)) {
                $error = 'Cet email est déjà utilisé.';
            } else {
                $newId = $userModel->create($name, $email, $password, $phone);

                $_SESSION['user_id']   = $newId;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_role'] = 'client';

                header('Location: index.php?page=home&msg=register');
                exit;
            }
        }

        require __DIR__ . '/../views/auth/signup.php';
    }

    public function logout()
    {
        $_SESSION = [];
        setcookie(session_name(), '', time() - 3600, '/');
        session_destroy();
        header('Location: index.php?page=home&msg=logout');
        exit;
    }
}
