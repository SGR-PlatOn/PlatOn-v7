<?php
// Récupérer les données passées par le contrôleur
$en_attente = $en_attente ?? [];
$en_preparation = $en_preparation ?? [];
$prete = $prete ?? [];
$total_commandes = $total_commandes ?? 0;

// Compter les commandes
$count_attente = count($en_attente);
$count_preparation = count($en_preparation);
$count_prete = count($prete);
$total = $count_attente + $count_preparation + $count_prete;
?>

<h1><i class="bi bi-chevron-right"></i> Dashboard Chef</h1>
<p class="lead">Quième Platon</p>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <h5 class="text-muted">En attente</h5>
                <h2 class="text-warning"><?php echo $count_attente; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <h5 class="text-muted">En préparation</h5>
                <h2 class="text-primary"><?php echo $count_preparation; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <h5 class="text-muted">Prêtes</h5>
                <h2 class="text-success"><?php echo $count_prete; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body text-center">
                <h5 class="text-muted">Total</h5>
                <h2><?php echo $total; ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Commandes en attente -->
<?php if ($count_attente > 0): ?>
<div class="card mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0"><i class="bi bi-clock"></i> En attente (<?php echo $count_attente; ?>)</h5>
    </div>
    <div class="card-body">
        <?php foreach ($en_attente as $commande): ?>
        <div class="mb-3 p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1">
                        <i class="bi bi-table"></i> Table <?php echo $commande['table']; ?> - <?php echo $commande['time']; ?>
                        <?php if (strpos($commande['items'], 'Filet') !== false): ?>
                            <span class="badge bg-danger">Urgent</span>
                        <?php endif; ?>
                    </h6>
                    <ul class="mb-2">
                        <?php 
                        $items = explode(', ', $commande['items']);
                        foreach ($items as $item): 
                        ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <form action="<?php echo BASE_URL; ?>/chef/update" method="POST" class="ms-3">
                    <input type="hidden" name="order_id" value="<?php echo $commande['id']; ?>">
                    <input type="hidden" name="action" value="start">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-play-circle"></i> Commencer
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Commandes en préparation -->
<?php if ($count_preparation > 0): ?>
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-gear"></i> En préparation (<?php echo $count_preparation; ?>)</h5>
    </div>
    <div class="card-body">
        <?php foreach ($en_preparation as $commande): ?>
        <div class="p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1"><i class="bi bi-table"></i> Table <?php echo $commande['table']; ?> - <?php echo $commande['time']; ?></h6>
                    <ul class="mb-2">
                        <?php 
                        $items = explode(', ', $commande['items']);
                        foreach ($items as $item): 
                        ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <form action="<?php echo BASE_URL; ?>/chef/update" method="POST" class="ms-3">
                    <input type="hidden" name="order_id" value="<?php echo $commande['id']; ?>">
                    <input type="hidden" name="action" value="ready">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-check-circle"></i> Prêt
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Commandes prêtes -->
<?php if ($count_prete > 0): ?>
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Prêtes (<?php echo $count_prete; ?>)</h5>
    </div>
    <div class="card-body">
        <?php foreach ($prete as $commande): ?>
        <div class="p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="mb-1"><i class="bi bi-table"></i> Table <?php echo $commande['table']; ?> - <?php echo $commande['time']; ?></h6>
                    <ul class="mb-2">
                        <?php 
                        $items = explode(', ', $commande['items']);
                        foreach ($items as $item): 
                        ?>
                            <li><?php echo htmlspecialchars($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <form action="<?php echo BASE_URL; ?>/chef/update" method="POST" class="ms-3">
                    <input type="hidden" name="order_id" value="<?php echo $commande['id']; ?>">
                    <input type="hidden" name="action" value="served">
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="bi bi-truck"></i> Servi
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if ($total == 0): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
        <h4 class="mt-3">Toutes les commandes sont traitées !</h4>
        <p class="text-muted">Aucune commande en attente, en préparation ou prête.</p>
    </div>
</div>
<?php endif; ?>

<!-- Auto-refresh et confirmations -->
<script>
// Auto-refresh toutes les 3 secondes
setTimeout(function() {
    window.location.reload();
}, 3000);

// Confirmation pour les actions
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const action = this.querySelector('[name="action"]').value;
            let message = '';
            
            switch(action) {
                case 'start':
                    message = 'Commencer la préparation de cette commande ?';
                    break;
                case 'ready':
                    message = 'Marquer cette commande comme prête ?';
                    break;
                case 'served':
                    message = 'Marquer cette commande comme servie ? (Elle disparaîtra)';
                    break;
            }
            
            if (message && !confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
</script>