<?php
class Router {
    public function dispatch() {
        // Récupérer l'URL
        $url = $_GET['url'] ?? 'home/index';
        $url = rtrim($url, '/');
        $parts = explode('/', $url);
        
        // Contrôleur et action
        $controllerName = ucfirst($parts[0] ?? 'home') . 'Controller';
        $action = $parts[1] ?? 'index';
        
        // Chemin du contrôleur
        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    $this->showError("Action '$action' non trouvée");
                }
            } else {
                $this->showError("Contrôleur '$controllerName' non trouvé");
            }
        } else {
            $this->showError("Page non trouvée");
        }
    }
    
    private function showError($message) {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Erreur - PlatOn</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='container mt-5'>
            <div class='alert alert-danger'>
                <h2>Erreur</h2>
                <p>$message</p>
                <a href='" . BASE_URL . "' class='btn btn-primary'>Accueil</a>
            </div>
        </body>
        </html>";
    }
}
?>