-- Suppression des tables si elles existent déjà
DROP TABLE IF EXISTS trips;
DROP TABLE IF EXISTS agencies;
DROP TABLE IF EXISTS users;

-- 1. Création de la table des utilisateurs (Employés)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stocké de manière hachée pour la sécurité
    phone VARCHAR(20) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user' -- 'user' ou 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Création de la table des agences (Villes)
CREATE TABLE agencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Création de la table des trajets
CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departure_agency_id INT NOT NULL,
    arrival_agency_id INT NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    seats_total INT NOT NULL,
    seats_available INT NOT NULL,
    user_id INT NOT NULL, -- L'auteur du trajet
    FOREIGN KEY (departure_agency_id) REFERENCES agencies(id),
    FOREIGN KEY (arrival_agency_id) REFERENCES agencies(id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;