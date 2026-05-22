<?php

namespace App\Controllers;

use App\Models\Agency;

class HomeController {

    /**
     * Affiche la page d'accueil
     * @return void
     */
    public function index() {
        // On récupère les agences
        $agencies = Agency::getAll();
        
        // On charge la vue
        require_once __DIR__ . '/../Views/home/index.php';
    }
}