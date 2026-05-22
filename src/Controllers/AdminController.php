<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Models\Agency;
use App\Database; // Correction apportée ici pour cibler src/Database.php
use PDO;

class AdminController {

    /**
     * Constructeur : Sécurise l'accès à la zone admin
     */
    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /login');
            exit();
        }
    }

    /**
     * Page d'accueil du tableau de bord admin
     */
    public function dashboard() {
        $db = Database::getInstance(); 
        
        // 1. Charger tous les trajets
        $stmt = $db->query("SELECT t.*, u.firstname, u.lastname, dep.name as departure_agency, arr.name as arrival_agency 
                            FROM trips t
                            JOIN users u ON t.user_id = u.id
                            JOIN agencies dep ON t.departure_agency_id = dep.id
                            JOIN agencies arr ON t.arrival_agency_id = arr.id
                            ORDER BY t.departure_time DESC");
        $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Charger les agences
        $agencies = Agency::getAll();

        // 3. Charger le personnel
        $stmtUser = $db->query("SELECT id, lastname, firstname, email, phone, role FROM users");
        $users = $stmtUser->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Ajoute une nouvelle agence
     */
    public function storeAgency() {
        $name = trim($_POST['name'] ?? '');
        if (!empty($name)) {
            $db = Database::getInstance();
            $stmt = $db->prepare("INSERT INTO agencies (name) VALUES (:name)");
            $stmt->execute(['name' => $name]);
        }
        header('Location: /admin');
        exit();
    }

    /**
     * Supprime une agence
     */
    public function deleteAgency($params) {
        $id = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM agencies WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header('Location: /admin');
        exit();
    }

    /**
     * Supprime n'importe quel trajet
     */
    public function deleteTrip($params) {
        $id = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        Trip::delete($id);

        header('Location: /admin');
        exit();
    }
}