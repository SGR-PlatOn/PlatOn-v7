<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'PlatOn Restaurant'; ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table-card { 
            width: 80px; height: 80px; 
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; margin: 10px; cursor: pointer;
            color: white; font-weight: bold;
            transition: transform 0.2s;
        }
        .table-card:hover { transform: scale(1.05); }
        .table-free { background: #28a745; }
        .table-busy { background: #dc3545; }
        .table-reserved { background: #ffc107; color: #000; }
        .stat-card { border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/home">
                <i class="bi bi-egg-fried"></i> PlatOn
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/home">
                    <i class="bi bi-house"></i> Accueil
                </a>
                
                <?php if (isset($_SESSION['role'])): ?>
                    <span class="nav-link">
                        <i class="bi bi-person-circle"></i> <?php echo ucfirst($_SESSION['role']); ?>
                    </span>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/<?php echo $_SESSION['role']; ?>/dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/logout">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </a>
                <?php else: ?>
                    <a class="nav-link" href="<?php echo BASE_URL; ?>/auth/login">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion Staff
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">