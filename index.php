<?php

// Inclure manuellement la classe Autoloader
require_once '../app/core/Autoloader.php';

// Enregistrement de l'autoloader
App\Core\Autoloader::register();

// Démarrage de la session
session_start();

// Charger les variables d'environnement
$dotenv = parse_ini_file('.env');
foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

// Charger l'application
$app = new App\Core\App();