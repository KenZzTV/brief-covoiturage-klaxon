<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TripController;
use App\Controllers\AdminController;

$router = new Router([
    'debug' => true
]);

// ROUTES PUBLIQUES
$router->get('/', function() {
    $controller = new HomeController();
    $controller->index();
});

// ROUTES AUTHENTIFICATION
$router->get('/login', function() {
    $controller = new AuthController();
    $controller->showLoginForm();
});

$router->post('/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->get('/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// ROUTES TRAJETS (Utilisateurs connectés)
$router->get('/trips', function() {
    $controller = new TripController();
    $controller->index();
});

$router->get('/trips/create', function() {
    $controller = new TripController();
    $controller->createForm();
});

$router->post('/trips/create', function() {
    $controller = new TripController();
    $controller->store();
});

// Route pour afficher le formulaire de modification
$router->get('/trips/edit/:id', function($attributes) {
    $controller = new TripController();
    $controller->editForm($attributes);
});

// Route pour traiter la soumission de la modification
$router->post('/trips/update/:id', function($attributes) {
    $controller = new TripController();
    $controller->update($attributes);
});

// Route pour la suppression d'un trajet
$router->get('/trips/delete/:id', function($attributes) {
    $controller = new TripController();
    $controller->delete($attributes);
});

// Route bonus de réservation
$router->get('/trips/book/:id', function($attributes) {
    $controller = new TripController();
    $controller->book($attributes);
});

// --- ROUTES ADMINISTRATEUR
$router->get('/admin', function() {
    $controller = new \App\Controllers\AdminController();
    $controller->dashboard();
});

$router->post('/admin/agencies/create', function() {
    $controller = new \App\Controllers\AdminController();
    $controller->storeAgency();
});

$router->get('/admin/agencies/delete/:id', function($attributes) {
    $controller = new \App\Controllers\AdminController();
    $controller->deleteAgency($attributes);
});

$router->get('/admin/trips/delete/:id', function($attributes) {
    $controller = new \App\Controllers\AdminController();
    $controller->deleteTrip($attributes);
});

$router->run();