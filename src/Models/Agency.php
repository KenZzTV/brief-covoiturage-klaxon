<?php

namespace App\Models;

use App\Database;
use PDO;

class Agency {
    
    /**
     * Récupère la liste de toutes les agences de la base de données.
     * * @return array
     */
    public static function getAll() {
        // 1. On récupère l'instance unique de notre connexion PDO
        $db = Database::getInstance();
        
        // 2. On prépare la requête SQL
        $query = "SELECT * FROM agencies ORDER BY name ASC";
        
        // 3. On exécute la requête
        $statement = $db->query($query);
        
        // 4. On retourne tous les résultats sous forme de tableau
        return $statement->fetchAll();
    }
}