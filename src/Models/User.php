<?php

namespace App\Models;

use App\Database;
use PDO;

class User {

    /**
     * Recherche un utilisateur en base de données par son adresse email.
     * @param string $email
     * @return array|false Returns user data array or false if not found.
     */
    public static function findByEmail($email) {
        $db = Database::getInstance();
        
        // On utilise une requête préparée pour éviter les injections SQL
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $statement = $db->prepare($query);
        
        // On lie le paramètre de façon sécurisée
        $statement->execute(['email' => $email]);
        
        return $statement->fetch();
    }
}