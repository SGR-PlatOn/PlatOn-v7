<?php
if (!isset($_SESSION['role'])) {
    header('Location: ' . BASE_URL . '/auth/login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/' . $_SESSION['role'] . '/dashboard');
    exit();
}

$order_id = $_POST['order_id'] ?? '';
$action = $_POST['action'] ?? '';
$table_id = $_POST['table_id'] ?? '';

// Simuler la mise à jour
$actions = [
    'start' => 'commencée',
    'ready' => 'prête',
    'served' => 'servie'
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour - PlatOn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL . '/' . $_SESSION['role'] . '/dashboard'; ?>">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-4">
                    <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                
                <h3>Mise à jour effectuée !</h3>
                
                <?php if ($order_id): ?>
                    <p class="lead">Commande #<?php echo $order_id; ?> marquée comme 
                    <span class="badge bg-success"><?php echo $actions[$action] ?? 'mise à jour'; ?></span></p>
                <?php elseif ($table_id): ?>
                    <p class="lead">Table #<?php echo $table_id; ?> mise à jour</p>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="<?php echo BASE_URL . '/' . $_SESSION['role'] . '/dashboard'; ?>" class="btn btn-primary">
                        <i class="bi bi-speedometer2"></i> Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>