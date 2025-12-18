<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/home');
    exit();
}

// Récupérer les données
$prenom = htmlspecialchars($_POST['prenom'] ?? '');
$nom = htmlspecialchars($_POST['nom'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$telephone = htmlspecialchars($_POST['telephone'] ?? '');
$date = htmlspecialchars($_POST['date'] ?? '');
$personnes = htmlspecialchars($_POST['personnes'] ?? '');
$message = htmlspecialchars($_POST['message'] ?? '');

// Simuler l'enregistrement en base
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation confirmée - PlatOn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/home">PlatOn</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0"><i class="bi bi-check-circle"></i> Réservation confirmée !</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    <h5>Merci <?php echo $prenom . ' ' . $nom; ?> !</h5>
                    <p>Votre réservation a été enregistrée avec succès.</p>
                </div>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Détails de votre réservation :</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($date)); ?></li>
                            <li class="list-group-item"><strong>Nombre de personnes :</strong> <?php echo $personnes; ?></li>
                            <li class="list-group-item"><strong>Téléphone :</strong> <?php echo $telephone; ?></li>
                            <li class="list-group-item"><strong>Email :</strong> <?php echo $email; ?></li>
                            <?php if (!empty($message)): ?>
                                <li class="list-group-item"><strong>Message :</strong> <?php echo $message; ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                
                <p class="text-muted">
                    <i class="bi bi-info-circle"></i> Un email de confirmation a été envoyé à <?php echo $email; ?>
                </p>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                    <a href="<?php echo BASE_URL; ?>/home" class="btn btn-primary">
                        <i class="bi bi-house"></i> Retour à l'accueil
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-printer"></i> Imprimer
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>