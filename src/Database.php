<?php

namespace App;

use PDO;
use PDOException;

class Database {
    // Les informations de connexion à WampServer
    private static $host = 'localhost';
    private static $db_name = 'touche_pas_au_klaxon';
    private static $username = 'root';
    private static $password = '';
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                // On configure l'adresse, le nom de la BDD et l'encodage (utf8mb4)
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db_name . ";charset=utf8mb4";
                
                self::$instance = new PDO($dsn, self::$username, self::$password, [
                    // Option 1 : Active le rapport d'erreurs sous forme d'exceptions (indispensable pour sécuriser)
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Option 2 : Récupère les données sous forme de tableaux associatifs (plus simple à manipuler)
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Option 3 : On passe cette option à true pour harmoniser le dialogue avec MySQL
                    PDO::ATTR_EMULATE_PREPARES => true,
                ]);
            } catch (PDOException $e) {
                // Si la connexion échoue, on arrête tout et on affiche le message d'erreur
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}