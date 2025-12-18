<?php
class GerantController extends Controller {
    public function dashboard() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gerant') {
            $this->redirect('auth/login');
        }
        
        // Récupérer les statistiques
        $stats = $this->getStats();
        
        // Récupérer les réservations du jour
        $reservations = $this->getReservationsDuJour();
        
        $this->view('gerant/dashboard', [
            'title' => 'Dashboard Gérant - PlatOn',
            'stats' => $stats,
            'reservations' => $reservations
        ]);
    }
    
    private function getStats() {
        // Récupérer depuis la base de données ou simuler
        return [
            'reservations_aujourdhui' => $this->countReservationsToday(),
            'personnel_service' => $this->countPersonnelEnService(),
            'taux_occupation' => $this->calculateTauxOccupation(),
            'chiffre_affaires' => $this->getChiffreAffairesDuJour(),
            'clients_salle' => rand(15, 40),
            'commandes_cours' => rand(5, 20)
        ];
    }
    
    private function getReservationsDuJour() {
        // Simuler des données pour l'exemple
        return [
            ['id' => 1, 'client' => 'Martin', 'personnes' => 2, 'heure' => '19:30', 'table' => 9, 'statut' => 'confirme'],
            ['id' => 2, 'client' => 'Bernard', 'personnes' => 4, 'heure' => '20:00', 'table' => null, 'statut' => 'attente'],
            ['id' => 3, 'client' => 'Dubois', 'personnes' => 6, 'heure' => '20:30', 'table' => null, 'statut' => 'attente'],
            ['id' => 4, 'client' => 'Leroy', 'personnes' => 3, 'heure' => '19:00', 'table' => 3, 'statut' => 'confirme']
        ];
    }
    
    // API endpoints
    public function getReservations() {
        header('Content-Type: application/json');
        echo json_encode($this->getReservationsDuJour());
    }
    
    public function getTablesOccupation() {
        header('Content-Type: application/json');
        echo json_encode([
            'tables' => [
                ['numero' => 1, 'places' => 2, 'statut' => 'libre'],
                ['numero' => 2, 'places' => 2, 'statut' => 'occupee'],
                ['numero' => 3, 'places' => 2, 'statut' => 'occupee'],
                ['numero' => 4, 'places' => 4, 'statut' => 'libre'],
                ['numero' => 5, 'places' => 4, 'statut' => 'occupee'],
                ['numero' => 6, 'places' => 2, 'statut' => 'libre'],
                ['numero' => 7, 'places' => 4, 'statut' => 'occupee'],
                ['numero' => 8, 'places' => 8, 'statut' => 'occupee'],
                ['numero' => 9, 'places' => 2, 'statut' => 'reservee'],
                ['numero' => 10, 'places' => 4, 'statut' => 'reservee'],
                ['numero' => 11, 'places' => 2, 'statut' => 'occupee'],
                ['numero' => 12, 'places' => 6, 'statut' => 'occupee']
            ]
        ]);
    }
    
    public function getNotifications() {
        header('Content-Type: application/json');
        echo json_encode([
            'notifications' => [
                ['titre' => 'Nouvelle réservation', 'message' => 'Martin - 2 personnes à 19:30', 'heure' => '18:45'],
                ['titre' => 'Commande terminée', 'message' => 'Table 3 - 72.50€', 'heure' => '18:30'],
                ['titre' => 'Stock faible', 'message' => 'Vin rouge - 3 bouteilles restantes', 'heure' => '17:15']
            ]
        ]);
    }
    
    
    public function ajouterReservation() {
        header('Content-Type: application/json');
        // Ici, insérer dans la base de données
        echo json_encode(['success' => true, 'message' => 'Réservation ajoutée']);
    }
    
    public function assignerReservation() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        // Ici, mettre à jour la réservation avec la table
        echo json_encode(['success' => true, 'message' => 'Réservation assignée']);
    }
    
    public function modifierReservation() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        // Ici, modifier la réservation
        echo json_encode(['success' => true, 'message' => 'Réservation modifiée']);
    }
    
    public function supprimerReservation() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        // Ici, supprimer la réservation
        echo json_encode(['success' => true, 'message' => 'Réservation supprimée']);
    }
    
    public function getTablesDisponibles() {
        header('Content-Type: application/json');
        echo json_encode([
            ['id' => 1, 'numero' => 1, 'places' => 2],
            ['id' => 4, 'numero' => 4, 'places' => 4],
            ['id' => 6, 'numero' => 6, 'places' => 2],
            ['id' => 10, 'numero' => 10, 'places' => 4]
        ]);
    }
    
    // Méthodes de simulation
    private function countReservationsToday() {
        return rand(8, 20);
    }
    
    private function countPersonnelEnService() {
        return 8; // 8 personnes en service
    }
    
    private function calculateTauxOccupation() {
        return rand(60, 90);
    }
    
    private function getChiffreAffairesDuJour() {
        return rand(1500, 3500);
    }
    
    // Autres pages
    public function personnel() {
        // Afficher la page gestion du personnel
        echo '<h4>Gestion du personnel</h4><p>Interface de gestion à implémenter...</p>';
    }
    
    public function menu() {
        $this->redirect('gerant/menu');
    }
    
    public function statistiques() {
        $this->redirect('gerant/statistiques');
    }
    
    public function tables() {
        $this->redirect('gerant/tables');
    }
    
    public function parametres() {
        $this->redirect('gerant/parametres');
    }
    
    public function export() {
        // Générer un fichier CSV
        $csv = "Date,Client,Personnes,Heure,Table,Montant\n";
        $csv .= date('Y-m-d') . ",Martin,2,19:30,9,45.50\n";
        $csv .= date('Y-m-d') . ",Bernard,4,20:00,,0\n";
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export_' . date('Y-m-d') . '.csv"');
        echo $csv;
        exit;
    }
}
?>