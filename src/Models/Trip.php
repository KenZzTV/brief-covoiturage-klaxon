<?php

namespace App\Models;

use App\Database;
use PDO;

class Trip {

    /**
     * Récupère la liste de tous les trajets futurs qui possèdent encore des places disponibles
     * Triée par date de départ croissante (Brief 3.4)
     * @return array Liste des trajets avec les détails des agences et du conducteur
     */
    public static function getAllWithDetails() {
        $db = Database::getInstance();
        
        // Requête SQL avec double jointure pour les agences + jointure utilisateur
        // Filtrage : places disponibles > 0 ET date de départ supérieure ou égale à maintenant (NOW())
        $query = "SELECT t.*, 
                         u.firstname, u.lastname, u.email, u.phone,
                         dep.name as departure_agency, 
                         arr.name as arrival_agency
                  FROM trips t
                  JOIN users u ON t.user_id = u.id
                  JOIN agencies dep ON t.departure_agency_id = dep.id
                  JOIN agencies arr ON t.arrival_agency_id = arr.id
                  WHERE t.seats_available > 0 
                    AND t.departure_time >= NOW()
                  ORDER BY t.departure_time ASC";
                  
        $stmt = $db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet spécifique par son identifiant unique
     * @param int $id Identifiant du trajet
     * @return array|false Données du trajet ou false si introuvable
     */
    public static function getById($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM trips WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Enregistre un nouveau trajet en base de données (Brief 3.6)
     * @param array $data Données brutes du formulaire
     * @return bool True en cas de succès, false sinon
     */
    public static function create($data) {
        $db = Database::getInstance();
        $query = "INSERT INTO trips (user_id, departure_agency_id, arrival_agency_id, departure_time, arrival_time, seats_total, seats_available) 
                  VALUES (:user_id, :departure_agency_id, :arrival_agency_id, :departure_time, :arrival_time, :seats_total, :seats_total)";
        
        $stmt = $db->prepare($query);
        return $stmt->execute([
            'user_id'             => $data['user_id'],
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id'   => $data['arrival_agency_id'],
            'departure_time'      => $data['departure_time'],
            'arrival_time'        => $data['arrival_time'],
            'seats_total'         => $data['seats_total']
        ]);
    }

    /**
     * Met à jour un trajet existant (Brief 3.5)
     * @param array $data Données modifiées du trajet
     * @return bool True en cas de succès, false sinon
     */
    public static function update($data) {
        $db = Database::getInstance();
        
        $query = "UPDATE trips 
                  SET departure_agency_id = :departure_agency_id, 
                      arrival_agency_id = :arrival_agency_id, 
                      departure_time = :departure_time, 
                      arrival_time = :arrival_time, 
                      seats_total = :seats_total,
                      seats_available = :seats_total
                  WHERE id = :id";
        
        $stmt = $db->prepare($query);
        return $stmt->execute([
            'id'                  => $data['id'],
            'departure_agency_id' => $data['departure_agency_id'],
            'arrival_agency_id'   => $data['arrival_agency_id'],
            'departure_time'      => $data['departure_time'],
            'arrival_time'        => $data['arrival_time'],
            'seats_total'         => $data['seats_total']
        ]);
    }

    /**
     * Supprime un trajet de la base de données (Brief 3.5)
     * @param int $id Identifiant du trajet à supprimer
     * @return bool True en cas de succès, false sinon
     */
    public static function delete($id) {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM trips WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Décrémente une place disponible sur un trajet
     * @param int $tripId Identifiant du trajet
     * @return bool True si la réservation a été effectuée, false sinon
     */
    public static function bookPlace($tripId) {
        $db = Database::getInstance();
        $query = "UPDATE trips 
                  SET seats_available = seats_available - 1 
                  WHERE id = :trip_id AND seats_available > 0";
                  
        $stmt = $db->prepare($query);
        return $stmt->execute(['trip_id' => $tripId]);
    }
}