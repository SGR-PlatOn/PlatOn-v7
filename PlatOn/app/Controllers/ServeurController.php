<?php
class ServeurController extends Controller {
    public function dashboard() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'serveur') {
            $this->redirect('auth/login');
        }
        
        // Données de test (à remplacer par une vraie base de données)
        $tables = $this->getTablesData();
        $reservations = $this->getReservationsData();
        
        // Calculer les statistiques
        $stats = [
            'total' => count($tables),
            'libres' => count(array_filter($tables, fn($t) => $t['status'] === 'libre')),
            'occupees' => count(array_filter($tables, fn($t) => $t['status'] === 'occupee')),
            'reservees' => count(array_filter($tables, fn($t) => $t['status'] === 'reservee')),
            'reservations_pending' => count(array_filter($reservations, fn($r) => !$r['assigned']))
        ];
        
        $this->view('serveur/dashboard', [
            'title' => 'Dashboard Serveur - PlatOn',
            'tables' => $tables,
            'reservations' => $reservations,
            'stats' => $stats
        ]);
    }
    
    private function getTablesData() {
        // Données de test - À REMPLACER par une vraie requête à la base de données
        return [
            ['id' => 1, 'num' => 1, 'places' => 2, 'status' => 'libre'],
            ['id' => 2, 'num' => 2, 'places' => 2, 'status' => 'occupee', 'client' => 'Dupont', 'persons' => 2, 'time' => '19:00'],
            ['id' => 3, 'num' => 3, 'places' => 2, 'status' => 'occupee', 'client' => 'Martin', 'persons' => 3, 'time' => '18:45'],
            ['id' => 4, 'num' => 4, 'places' => 4, 'status' => 'occupee'],
            ['id' => 5, 'num' => 5, 'places' => 4, 'status' => 'libre'],
            ['id' => 6, 'num' => 6, 'places' => 2, 'status' => 'libre'],
            ['id' => 7, 'num' => 7, 'places' => 4, 'status' => 'occupee', 'client' => 'Robert', 'persons' => 4, 'time' => '19:00'],
            ['id' => 8, 'num' => 8, 'places' => 8, 'status' => 'occupee', 'client' => 'Dubois', 'persons' => 7, 'time' => '18:15'],
            ['id' => 9, 'num' => 9, 'places' => 2, 'status' => 'reservee', 'client' => 'Martin', 'persons' => 2, 'time' => '19:30'],
            ['id' => 10, 'num' => 10, 'places' => 4, 'status' => 'reservee', 'client' => 'Bernard', 'persons' => 4, 'time' => '19:30'],
            ['id' => 11, 'num' => 11, 'places' => 2, 'status' => 'occupee', 'client' => 'Simon', 'persons' => 2, 'time' => '18:00'],
            ['id' => 12, 'num' => 12, 'places' => 6, 'status' => 'occupee', 'client' => 'Leroy', 'persons' => 5, 'time' => '19:15']
        ];
    }
    
    private function getReservationsData() {
        // Données de test - À REMPLACER par une vraie requête à la base de données
        return [
            ['id' => 1, 'client' => 'Bernard', 'persons' => 4, 'time' => '20:00', 'assigned' => false],
            ['id' => 2, 'client' => 'Dubois', 'persons' => 6, 'time' => '20:30', 'assigned' => false]
        ];
    }
    
    // Méthode pour ajouter un nouveau client
public function ajouterClient() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'serveur') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Non autorisé']);
        return;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données JSON
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        // DEBUG: Afficher ce qui est reçu
        error_log("Données reçues: " . print_r($data, true));
        
        // Valider les données
        if (empty($data['nom']) || empty($data['personnes']) || empty($data['heure'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false, 
                'message' => 'Données manquantes: nom, personnes ou heure'
            ]);
            return;
        }
        
        try {
            // SIMULATION - Pour tester sans base de données
            $clientId = rand(1000, 9999);
            
            // Stocker en session pour l'exemple
            if (!isset($_SESSION['clients'])) {
                $_SESSION['clients'] = [];
            }
            
            $_SESSION['clients'][] = [
                'id' => $clientId,
                'nom' => $data['nom'],
                'personnes' => $data['personnes'],
                'heure' => $data['heure'],
                'telephone' => $data['telephone'] ?? '',
                'notes' => $data['notes'] ?? '',
                'type_service' => $data['type_service'] ?? 'sur_place',
                'date_creation' => date('Y-m-d H:i:s')
            ];
            
            // DEBUG: Afficher la session
            error_log("Session après ajout: " . print_r($_SESSION['clients'], true));
            
            // Réponse de succès
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Client ajouté avec succès',
                'client_id' => $clientId,
                'client' => $data['nom'],
                'personnes' => $data['personnes'],
                'heure' => $data['heure']
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false, 
                'message' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false, 
            'message' => 'Méthode non autorisée'
        ]);
    }
}
    
    // ... autres méthodes ...
}
?>