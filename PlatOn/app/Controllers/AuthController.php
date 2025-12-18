<?php
class AuthController extends Controller {
    public function login() {
        $this->view('auth/login', [
            'title' => 'Connexion - PlatOn'
        ]);
    }
    
    public function check() {
        require_once BASE_PATH . '/app/views/process/login.php';
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
}
?>