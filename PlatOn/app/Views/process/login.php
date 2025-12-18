<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/auth/login');
    exit();
}

$role = $_POST['role'] ?? '';
$password = $_POST['password'] ?? '';

// Mots de passe de test
$validPasswords = [
    'chef' => 'chef123',
    'serveur' => 'serveur123',
    'gerant' => 'gerant123'
];

if (isset($validPasswords[$role]) && $validPasswords[$role] === $password) {
    $_SESSION['role'] = $role;
    $_SESSION['user'] = $role . '@platon.com';
    
    // Rediriger vers le dashboard approprié
    header('Location: ' . BASE_URL . '/' . $role . '/dashboard');
    exit();
} else {
    header('Location: ' . BASE_URL . '/auth/login?error=Mot+de+passe+incorrect');
    exit();
}
?>