<?php

namespace App\Controllers;

use App\Models\Trip;
use App\Models\Agency;

class TripController {

    /**
     * Affiche la liste des trajets disponibles
     */
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $trips = Trip::getAllWithDetails();
        require_once __DIR__ . '/../Views/trips/index.php';
    }

    /**
     * Affiche le formulaire de création de trajet
     */
    public function createForm() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $agencies = Agency::getAll();
        require_once __DIR__ . '/../Views/trips/create.php';
    }

    /**
     * Traite l'envoi du formulaire de création de trajet
     */
    public function store() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $data = [
            'user_id'             => $_SESSION['user_id'],
            'departure_agency_id' => $_POST['departure_agency_id'] ?? '',
            'arrival_agency_id'   => $_POST['arrival_agency_id'] ?? '',
            'departure_time'      => $_POST['departure_time'] ?? '',
            'arrival_time'        => $_POST['arrival_time'] ?? '',
            'seats_total'         => intval($_POST['seats_total'] ?? 0)
        ];

        // CONTRÔLE 1 : Agences différentes
        if ($data['departure_agency_id'] === $data['arrival_agency_id']) {
            $error = "L'agence de départ doit être différente de l'agence d'arrivée !";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/create.php';
            return;
        }

        // CONTRÔLE 2 : Cohérence des dates (Brief : "on ne peut arriver avant de partir")
        if (strtotime($data['arrival_time']) <= strtotime($data['departure_time'])) {
            $error = "La date et heure d'arrivée doivent être postérieures à celles de départ !";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/create.php';
            return;
        }

        if (Trip::create($data)) {
            header('Location: /trips');
            exit();
        } else {
            $error = "Une erreur est survenue lors de l'enregistrement du trajet.";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/create.php';
        }
    }

    /**
     * Affiche le formulaire de modification d'un trajet (Auteur uniquement)
     * @param array|int $params
     */
    public function editForm($params) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $tripId = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        $trip = Trip::getById($tripId);

        // Sécurité : Vérifier si le trajet existe et si l'utilisateur connecté en est bien l'auteur
        if (!$trip || $trip['user_id'] !== $_SESSION['user_id']) {
            header('Location: /trips');
            exit();
        }

        $agencies = Agency::getAll();
        require_once __DIR__ . '/../Views/trips/edit.php';
    }

    /**
     * Traite la mise à jour d'un trajet (Auteur uniquement)
     * @param array|int $params
     */
    public function update($params) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $tripId = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        $trip = Trip::getById($tripId);

        if (!$trip || $trip['user_id'] !== $_SESSION['user_id']) {
            header('Location: /trips');
            exit();
        }

        $data = [
            'id'                  => $tripId,
            'departure_agency_id' => $_POST['departure_agency_id'] ?? '',
            'arrival_agency_id'   => $_POST['arrival_agency_id'] ?? '',
            'departure_time'      => $_POST['departure_time'] ?? '',
            'arrival_time'        => $_POST['arrival_time'] ?? '',
            'seats_total'         => intval($_POST['seats_total'] ?? 0)
        ];

        // Même contrôles qu'à la création
        if ($data['departure_agency_id'] === $data['arrival_agency_id']) {
            $error = "L'agence de départ doit être différente de l'agence d'arrivée !";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/edit.php';
            return;
        }

        if (strtotime($data['arrival_time']) <= strtotime($data['departure_time'])) {
            $error = "La date d'arrivée doit être après la date de départ !";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/edit.php';
            return;
        }

        if (Trip::update($data)) {
            header('Location: /trips');
            exit();
        } else {
            $error = "Erreur lors de la modification.";
            $agencies = Agency::getAll();
            require_once __DIR__ . '/../Views/trips/edit.php';
        }
    }

    /**
     * Supprime un trajet (Auteur uniquement)
     * @param array|int $params
     */
    public function delete($params) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $tripId = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        $trip = Trip::getById($tripId);

        // Sécurité : On vérifie que le trajet appartient bien à la personne connectée
        if ($trip && $trip['user_id'] === $_SESSION['user_id']) {
            Trip::delete($tripId);
        }

        header('Location: /trips');
        exit();
    }

    /**
     * Traite la réservation d'une place (Gardé en bonus/sécurité si besoin)
     */
    public function book($params) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $tripId = is_array($params) && isset($params['id']) ? intval($params['id']) : intval($params);
        Trip::bookPlace($tripId);

        header('Location: /trips');
        exit();
    }
}