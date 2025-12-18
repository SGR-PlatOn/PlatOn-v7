<?php
class HomeController extends Controller {
    public function index() {
        $this->view('home/index', [
            'title' => 'PlatOn - Réservation'
        ]);
    }
    
    public function reserve() {
        require_once BASE_PATH . '/app/views/process/reserve.php';
    }
}
?>