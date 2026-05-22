<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {

    /**
     * Affiche le formulaire
     */
    public function showLoginForm() {
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Traite la tentative de connexion
     */
    public function login() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // On cherche l'utilisateur en BDD via son modèle
        $user = User::findByEmail($email);

        // On compare le mot de passe tapé avec le hachage stocké
        if ($user && password_verify($password, $user['password'])) {
            // Succès : Initialisation des données de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
            $_SESSION['user_role'] = $user['role'];

            header('Location: /');
            exit();
        } else {
            // Échec : renvoi à la vue avec une erreur
            $error = "Identifiants incorrects ou compte introuvable.";
            require_once __DIR__ . '/../Views/auth/login.php';
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        session_destroy();
        header('Location: /');
        exit();
    }
}