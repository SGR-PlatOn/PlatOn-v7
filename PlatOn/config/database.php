<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'platon_restaurant';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Pour le développement, afficher l'erreur
    die("Erreur de connexion : " . $e->getMessage());
}
?>