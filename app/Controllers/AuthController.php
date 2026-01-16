<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

final class AuthController extends Controller
{
    public function showRegisterForm(): void
    {
        $this->render('auth/register', [
            'title' => 'Inscription',
        ]);
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            return;
        }

        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        $errors = [];

        if ($nom === '') {
            $errors[] = 'Le nom est obligatoire.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if (User::findByEmail($email)) {
            $errors[] = 'Un compte existe déjà avec cet email.';
        }

        if (!empty($errors)) {
            $this->render('auth/register', [
                'title'  => 'Inscription',
                'errors' => $errors,
                'old'    => ['nom' => $nom, 'email' => $email],
            ]);
            return;
        }

        $user = new User();
        $user->setNom($nom);
        $user->setEmail($email);
        $user->setMotDePasse($password);

        if ($user->save()) {
            // Connexion automatique après inscription
            $created = User::findByEmail($email);
            $_SESSION['user'] = [
                'id'    => $created['id'],
                'nom'   => $created['nom'],
                'email' => $created['email'],
            ];
            header('Location: /');
        } else {
            $this->render('auth/register', [
                'title'  => 'Inscription',
                'errors' => ['Erreur lors de la création du compte.'],
                'old'    => ['nom' => $nom, 'email' => $email],
            ]);
        }
    }

    public function showLoginForm(): void
    {
        $this->render('auth/login', [
            'title' => 'Connexion',
        ]);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::verifyCredentials($email, $password);
        if (!$user) {
            $this->render('auth/login', [
                'title'  => 'Connexion',
                'error'  => 'Identifiants incorrects.',
                'old'    => ['email' => $email],
            ]);
            return;
        }

        $_SESSION['user'] = [
            'id'    => $user['id'],
            'nom'   => $user['nom'],
            'email' => $user['email'],
        ];

        header('Location: /');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('Location: /');
    }
}


