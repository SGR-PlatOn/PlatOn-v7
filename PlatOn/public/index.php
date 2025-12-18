<?php
// Démarrer la session
session_start();

// Définir constantes
define('BASE_URL', 'http://localhost/PlatOn');
define('BASE_PATH', dirname(__DIR__));

// Autoloader simple
spl_autoload_register(function ($className) {
    $paths = [
        BASE_PATH . '/app/Models/',
        BASE_PATH . '/app/controllers/',
        BASE_PATH . '/app/models/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Charger la configuration
require_once BASE_PATH . '/config/database.php';

// Charger et exécuter le routeur
require_once BASE_PATH . '/app/Models/Router.php';
$router = new Router();
$router->dispatch();
?>