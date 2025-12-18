<?php
class ChefController extends Controller {
    
    public function dashboard() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'chef') {
            $this->redirect('auth/login');
        }
        
        // Chemin du fichier JSON
        $commandesFile = BASE_PATH . '/app/data/commandes.json';
        
        // Charger les commandes depuis le fichier
        if (file_exists($commandesFile)) {
            $commandes = json_decode(file_get_contents($commandesFile), true);
        } else {
            // Commandes par défaut si le fichier n'existe pas
            $commandes = [
                ['id' => 1, 'table' => 5, 'time' => '18:30', 'items' => '2x Filet de Bœuf Rossini (Cuisson saignante), 1x Bar de Ligne Rôti', 'status' => 'en_attente'],
                ['id' => 2, 'table' => 3, 'time' => '18:40', 'items' => '2x Tartare de Saumon, 1x Carpaccio de Bœuf', 'status' => 'en_attente'],
                ['id' => 3, 'table' => 12, 'time' => '18:35', 'items' => '1x Foie Gras de Canard, 2x Saint-Jacques Snackées', 'status' => 'en_preparation'],
                ['id' => 4, 'table' => 8, 'time' => '18:25', 'items' => '1x Suprême de Volaille, 1x Homard Breton', 'status' => 'prete']
            ];
            
            // Créer le fichier avec les données par défaut
            if (!is_dir(dirname($commandesFile))) {
                mkdir(dirname($commandesFile), 0777, true);
            }
            file_put_contents($commandesFile, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
        
        // Convertir en tableau associatif avec ID comme clé
        $commandesAssoc = [];
        foreach ($commandes as $commande) {
            $commandesAssoc[$commande['id']] = $commande;
        }
        
        // Filtrer les commandes par statut
        $en_attente = array_filter($commandesAssoc, function($cmd) {
            return $cmd['status'] === 'en_attente';
        });
        
        $en_preparation = array_filter($commandesAssoc, function($cmd) {
            return $cmd['status'] === 'en_preparation';
        });
        
        $prete = array_filter($commandesAssoc, function($cmd) {
            return $cmd['status'] === 'prete';
        });
        
        // Passer les données à la vue
        $this->view('chef/dashboard', [
            'title' => 'Dashboard Chef - PlatOn',
            'en_attente' => $en_attente,
            'en_preparation' => $en_preparation,
            'prete' => $prete,
            'total_commandes' => count($commandesAssoc)
        ]);
    }
    
    public function update() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'chef') {
            $this->redirect('auth/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = (int)($_POST['order_id'] ?? 0);
            $action = $_POST['action'] ?? '';
            
            if ($order_id > 0 && $action) {
                // Chemin du fichier JSON
                $commandesFile = BASE_PATH . '/app/data/commandes.json';
                
                // Charger les commandes existantes
                if (file_exists($commandesFile)) {
                    $commandes = json_decode(file_get_contents($commandesFile), true);
                    
                    // Trouver la commande par ID
                    foreach ($commandes as &$commande) {
                        if ($commande['id'] == $order_id) {
                            // Mettre à jour le statut selon l'action
                            switch ($action) {
                                case 'start':
                                    $commande['status'] = 'en_preparation';
                                    break;
                                case 'ready':
                                    $commande['status'] = 'prete';
                                    break;
                                case 'served':
                                    // Marquer pour suppression (disparaît au prochain chargement)
                                    $commande['status'] = 'servie';
                                    break;
                            }
                            break;
                        }
                    }
                    
                    // Sauvegarder les modifications
                    file_put_contents($commandesFile, json_encode($commandes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                }
            }
            
            // Rediriger vers le dashboard (rafraîchissement)
            header('Location: ' . BASE_URL . '/chef/dashboard');
            exit();
        } else {
            $this->redirect('chef/dashboard');
        }
    }
}
?>