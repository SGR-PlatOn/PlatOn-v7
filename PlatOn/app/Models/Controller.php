<?php
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once BASE_PATH . "/app/views/shared/header.php";
        require_once BASE_PATH . "/app/views/$view.php";
        require_once BASE_PATH . "/app/views/shared/footer.php";
    }
    
    protected function redirect($url) {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit();
    }
}
?>