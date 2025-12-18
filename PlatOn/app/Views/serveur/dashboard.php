<?php
// Récupérer les données passées par le contrôleur
$tables = $tables ?? [];
$reservations = $reservations ?? [];
$stats = $stats ?? [];
?>

<h1><i class="bi bi-chevron-right"></i> Dashboard Serveur</h1>
<p class="lead">Service Platon</p>

<!-- Statistiques rapides -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-success border-2">
            <div class="card-body text-center">
                <h5 class="text-muted">Tables libres</h5>
                <h2 class="text-success"><?= $stats['libres'] ?? 0 ?></h2>
                <small>sur <?= $stats['total'] ?? 0 ?></small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-danger border-2">
            <div class="card-body text-center">
                <h5>Tables occupées</h5>
                <h2 class="text-danger"><?= $stats['occupees'] ?? 0 ?></h2>
                <small><?= ($stats['total'] ?? 0) > 0 ? round(($stats['occupees'] / $stats['total']) * 100) : 0 ?>%</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-warning border-2">
            <div class="card-body text-center">
                <h5>Réservées</h5>
                <h2 class="text-warning"><?= $stats['reservees'] ?? 0 ?></h2>
                <small>à venir</small>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-info border-2">
            <div class="card-body text-center">
                <h5>À assigner</h5>
                <h2 class="text-info"><?= $stats['reservations_pending'] ?? 0 ?></h2>
                <small>réservations</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Plan des tables -->
    <div class="col-lg-8">
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-grid-3x3-gap"></i> Plan des Tables</h5>
                <div>
                    <button class="btn btn-sm btn-light me-2" data-bs-toggle="modal" data-bs-target="#addClientModal">
                        <i class="bi bi-person-plus"></i> Nouveau Client
                    </button>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-success">Libre</button>
                        <button class="btn btn-sm btn-danger">Occupée</button>
                        <button class="btn btn-sm btn-warning">Réservée</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">

                <!-- Légende -->
                <div class="row mb-4">
                    <div class="d-flex justify-content-center flex-wrap">
                        <div class="legend-item mx-3">
                            <div class="legend-color libre"></div>
                            <span class="legend-text">Libre (<?= $stats['libres'] ?? 0 ?>)</span>
                        </div>
                        <div class="legend-item mx-3">
                            <div class="legend-color occupee"></div>
                            <span class="legend-text">Occupée (<?= $stats['occupees'] ?? 0 ?>)</span>
                        </div>
                        <div class="legend-item mx-3">
                            <div class="legend-color reservee"></div>
                            <span class="legend-text">Réservée (<?= $stats['reservees'] ?? 0 ?>)</span>
                        </div>
                    </div>
                </div>

                <!-- Grille des zones -->
                <div class="table-grid-container">
                    <?php  
                    $zones = [
                        'Terrasse' => [1,2,3,6,9,10],
                        'Intérieur' => [4,5,7,11],
                        'Salon' => [8,12]
                    ];

                    foreach ($zones as $zone => $tables_zone):
                        $tables_in_zone = array_filter($tables, fn($t) =>
                            in_array($t['num'], $tables_zone)
                        );
                    ?>

                    <div class="zone-section mb-5">
                        <h5 class="zone-title mb-3">
                            <i class="bi bi-geo-alt"></i> <?= $zone ?>
                            <span class="badge bg-secondary"><?= count($tables_in_zone) ?> tables</span>
                        </h5>

                        <div class="table-grid">
                            <?php foreach ($tables_in_zone as $table):
                                
                                $client = $table['client'] ?? null;
                                $persons = $table['persons'] ?? null;
                                $time = $table['time'] ?? null;
                                $status = $table['status'] ?? 'libre';

                                $status_classes = [
                                    'libre' => 'table-libre',
                                    'occupee' => 'table-occupee',
                                    'reservee' => 'table-reservee'
                                ];

                                $badge_color = [
                                    'libre' => 'bg-success',
                                    'occupee' => 'bg-danger',
                                    'reservee' => 'bg-warning'
                                ];

                                $status_icon = [
                                    'libre' => 'bi-check-circle',
                                    'occupee' => 'bi-person-fill',
                                    'reservee' => 'bi-calendar'
                                ];
                            ?>

                            <div class="table-card <?= $status_classes[$status] ?? '' ?>"
                                 onclick="showTableActions(<?= $table['id'] ?>, <?= $table['num'] ?>, '<?= $status ?>')"
                                 data-bs-toggle="tooltip"
                                 data-bs-html="true"
                                 title="<strong>Table <?= $table['num'] ?></strong><br>
                                        <?= $table['places'] ?> places<br>
                                        Statut: <?= ucfirst($status) ?>
                                        <?php if (!empty($client)): ?><br>Client: <?= $client ?><?php endif; ?>
                                        <?php if (!empty($persons)): ?><br><?= $persons ?> personnes<?php endif; ?>
                                        <?php if (!empty($time)): ?><br>Depuis: <?= $time ?><?php endif; ?>">

                                <div class="table-number"><?= $table['num'] ?></div>

                                <div class="table-status-icon">
                                    <i class="bi <?= $status_icon[$status] ?>"></i>
                                </div>

                                <div class="table-capacity">
                                    <span class="badge <?= $badge_color[$status] ?>">
                                        <?= $table['places'] ?> <i class="bi bi-people"></i>
                                    </span>
                                </div>

                                <?php if (!empty($client)): ?>
                                <div class="table-client">
                                    <small><i class="bi bi-person"></i> <?= $client ?></small>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($persons)): ?>
                                <div class="table-persons">
                                    <small><?= $persons ?> pers.</small>
                                </div>
                                <?php endif; ?>

                                <?php if (in_array($table['num'], [5,8])): ?>
                                <div class="table-urgent">
                                    <span class="badge bg-dark">⚠</span>
                                </div>
                                <?php endif; ?>

                            </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Panneau latéral -->
    <div class="col-lg-4">

        <!-- Réservations à assigner -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-calendar-check"></i> Réservations en attente</h5>
            </div>
            <div class="card-body">

                <?php if (!empty($reservations) && ($stats['reservations_pending'] ?? 0) > 0): ?>

                    <?php foreach ($reservations as $reservation):
                        if (!$reservation['assigned']):
                            $r_client = $reservation['client'] ?? 'Client';
                            $r_persons = $reservation['persons'] ?? 0;
                            $r_time = $reservation['time'] ?? '--:--';
                    ?>

                    <div class="reservation-card mb-3 p-3 border-start border-4 border-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6><i class="bi bi-person-circle"></i> <?= $r_client ?></h6>
                                <div class="reservation-details">
                                    <span class="badge bg-info me-2">
                                        <i class="bi bi-people"></i> <?= $r_persons ?>
                                    </span>
                                    <span class="text-muted">
                                        <i class="bi bi-clock"></i> <?= $r_time ?>
                                    </span>
                                </div>
                            </div>
                            <span class="badge bg-danger">À assigner</span>
                        </div>

                    <div class="mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label small mb-0">Assigner une table :</label>
        <span class="badge bg-info">
            <i class="bi bi-people"></i> <?= $r_persons ?> personnes
        </span>
    </div>
    
    <!-- Tables disponibles -->
    <div class="mb-2">
        <small class="text-muted">Cliquez sur une table :</small>
    </div>
    
    <div class="d-flex flex-wrap gap-2 mb-3" id="tablesContainer<?= $reservation['id'] ?>">
        <?php
        $tablesDisponibles = array_filter($tables, fn($t) =>
            ($t['status'] ?? '') === 'libre' &&
            ($t['places'] ?? 0) >= $r_persons
        );
        
        if (!empty($tablesDisponibles)):
            foreach ($tablesDisponibles as $t):
        ?>
        <button type="button" 
                class="btn btn-outline-success btn-sm table-choice"
                data-reservation="<?= $reservation['id'] ?>"
                data-table-id="<?= $t['id'] ?>"
                data-table-num="<?= $t['num'] ?>"
                data-table-capacity="<?= $t['places'] ?>"
                onclick="selectTable(this, <?= $reservation['id'] ?>, <?= $t['id'] ?>, <?= $t['num'] ?>, <?= $t['places'] ?>)">
            Table <?= $t['num'] ?>
            <span class="badge bg-success ms-1"><?= $t['places'] ?>p</span>
        </button>
        <?php 
            endforeach;
        else:
        ?>
        <div class="alert alert-warning py-2 w-100">
            <small><i class="bi bi-exclamation-triangle"></i> Aucune table disponible pour <?= $r_persons ?> personnes</small>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Bouton d'assignation -->
    <div class="d-grid">
        <button class="btn btn-success btn-sm assign-btn" 
                id="assignBtn<?= $reservation['id'] ?>"
                data-reservation-id="<?= $reservation['id'] ?>"
                onclick="assignReservation(<?= $reservation['id'] ?>)"
                disabled>
            <i class="bi bi-check-lg"></i> Assigner la table sélectionnée
        </button>
    </div>
</div>
                

                    <?php endif; endforeach; ?>

                <?php else: ?>

                <div class="text-center py-4">
                    <i class="bi bi-check-circle text-success" style="font-size:3rem;"></i>
                    <h6 class="mt-3">Toutes assignées !</h6>
                    <p class="text-muted small">Aucune réservation en attente</p>
                </div>

                <?php endif; ?>

            </div>
        </div>

        <!-- Modal Nouveau Client -->
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addClientModalLabel">
                    <i class="bi bi-person-plus"></i> Nouveau Client
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="addClientForm">
                <div class="modal-body">
                    
                    <!-- Nom du client -->
                    <div class="mb-3">
                        <label for="clientName" class="form-label">Nom du client *</label>
                        <input type="text" class="form-control" id="clientName" name="nom" required
                               placeholder="Ex: Dupont, Martin...">
                    </div>
                    
                    <div class="row">
                        <!-- Nombre de personnes -->
                        <div class="col-md-6 mb-3">
                            <label for="clientPersons" class="form-label">Nombre de personnes *</label>
                            <select class="form-select" id="clientPersons" name="personnes" required>
                                <option value="">Choisir...</option>
                                <option value="1">1 personne</option>
                                <option value="2">2 personnes</option>
                                <option value="3">3 personnes</option>
                                <option value="4" selected>4 personnes</option>
                                <option value="5">5 personnes</option>
                                <option value="6">6 personnes</option>
                                <option value="7">7 personnes</option>
                                <option value="8">8 personnes</option>
                                <option value="9">9+ personnes</option>
                            </select>
                        </div>
                        
                        <!-- Heure d'arrivée -->
                        <div class="col-md-6 mb-3">
                            <label for="clientTime" class="form-label">Heure d'arrivée *</label>
                            <input type="time" class="form-control" id="clientTime" name="heure" 
                                   value="<?= date('H:i') ?>" required>
                        </div>
                    </div>
                    
                    <!-- Téléphone -->
                    <div class="mb-3">
                        <label for="clientPhone" class="form-label">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="tel" class="form-control" id="clientPhone" name="telephone"
                                   placeholder="0601020304">
                        </div>
                    </div>
                    
                    <!-- Type de service -->
                    <div class="mb-3">
                        <label class="form-label">Type de service *</label>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check service-type-card">
                                    <input class="form-check-input" type="radio" name="type_service" 
                                           id="typeSurPlace" value="sur_place" checked>
                                    <label class="form-check-label w-100" for="typeSurPlace">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-shop display-6 text-primary"></i>
                                            <h6 class="mt-2">Sur place</h6>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check service-type-card">
                                    <input class="form-check-input" type="radio" name="type_service" 
                                           id="typeEmporter" value="a_emporter">
                                    <label class="form-check-label w-100" for="typeEmporter">
                                        <div class="text-center p-3 border rounded">
                                            <i class="bi bi-bag display-6 text-success"></i>
                                            <h6 class="mt-2">À emporter</h6>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="clientNotes" class="form-label">Notes (allergies, préférences...)</label>
                        <textarea class="form-control" id="clientNotes" name="notes" 
                                  rows="2" placeholder="Ex: Allergie aux arachides, préfère table calme..."></textarea>
                    </div>
                    
                    <!-- Message d'alerte pour tables disponibles -->
                    <div id="availableTablesAlert" class="alert alert-info d-none">
                        <i class="bi bi-info-circle"></i>
                        <span id="availableTablesText"></span>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer le client
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Tables libres -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-list-check"></i> Tables Libres (<?= $stats['libres'] ?? 0 ?>)</h5>
            </div>

            <div class="card-body">
                <div class="free-tables-grid">

                    <?php  
                    $tablesLibres = array_filter($tables, fn($t) =>
                        ($t['status'] ?? '') === 'libre'
                    );

                    if (!empty($tablesLibres)):
                        foreach ($tablesLibres as $t):
                    ?>
                        <div class="free-table-item"
                             onclick="showTableActions(<?= $t['id'] ?>, <?= $t['num'] ?>, 'libre')">
                            <div class="free-table-number"><?= $t['num'] ?></div>
                            <div class="free-table-info"><small><?= $t['places'] ?> places</small></div>
                        </div>
                    <?php endforeach; else: ?>

                        <div class="text-center py-3">
                            <i class="bi bi-emoji-frown text-muted" style="font-size:2rem;"></i>
                            <p class="mt-2 text-muted small">Aucune table disponible</p>
                        </div>

                    <?php endif; ?>
                </div>

                <div class="mt-3">
                    <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#addClientModal">
                        <i class="bi bi-lightning"></i> Ajouter client rapide
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
// Gestion du formulaire Nouveau Client
document.addEventListener('DOMContentLoaded', function() {
    
    // Récupérer les éléments
    const addClientForm = document.getElementById('addClientForm');
    const clientPersonsSelect = document.getElementById('clientPersons');
    const availableTablesAlert = document.getElementById('availableTablesAlert');
    const availableTablesText = document.getElementById('availableTablesText');
    const typeSurPlaceRadio = document.getElementById('typeSurPlace');
    const typeEmporterRadio = document.getElementById('typeEmporter');
    const selectedTables = {};
    
    // Vérifier les tables disponibles quand le nombre de personnes change
    clientPersonsSelect.addEventListener('change', checkAvailableTables);
    
    // Vérifier les tables disponibles quand le type de service change
    typeSurPlaceRadio.addEventListener('change', checkAvailableTables);
    typeEmporterRadio.addEventListener('change', checkAvailableTables);
    
    // Fonction pour vérifier les tables disponibles
    function checkAvailableTables() {
        const persons = parseInt(clientPersonsSelect.value);
        const isSurPlace = typeSurPlaceRadio.checked;
        
        if (isSurPlace && persons > 0) {
            // Compter les tables libres qui ont assez de places
            let availableCount = 0;
            const freeTables = document.querySelectorAll('.free-table-item');
            
            freeTables.forEach(table => {
                // Récupérer le nombre de places de la table (tu devras adapter cette logique)
                // Pour l'instant, on suppose que toutes les tables libres peuvent accueillir le client
                availableCount++;
            });
            
            if (availableCount > 0) {
                availableTablesText.textContent = 
                    `${availableCount} table(s) disponible(s) pour ${persons} personne(s)`;
                availableTablesAlert.classList.remove('d-none', 'alert-danger');
                availableTablesAlert.classList.add('alert-info');
            } else {
                availableTablesText.textContent = 
                    `⚠️ Aucune table disponible pour ${persons} personne(s)`;
                availableTablesAlert.classList.remove('d-none', 'alert-info');
                availableTablesAlert.classList.add('alert-danger');
            }
        } else {
            availableTablesAlert.classList.add('d-none');
        }
    }
    
    // Gérer la soumission du formulaire
    addClientForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Récupérer les données du formulaire
        const formData = new FormData(this);
        const clientData = {
            nom: formData.get('nom'),
            personnes: formData.get('personnes'),
            heure: formData.get('heure'),
            telephone: formData.get('telephone'),
            notes: formData.get('notes'),
            type_service: formData.get('type_service')
        };
        
        // Validation simple
        if (!clientData.nom || !clientData.personnes || !clientData.heure) {
            showAlert('Veuillez remplir tous les champs obligatoires', 'danger');
            return;
        }
        
        // Afficher un indicateur de chargement
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Enregistrement...';
        submitBtn.disabled = true;
        
        // CORRECTION ICI : Utiliser l'URL correcte pour ton système de routage
        const url = '?url=serveur/ajouterClient';
        
        // Envoyer les données au serveur
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(clientData)
        })
        .then(response => {
            // D'abord vérifier si la réponse est OK
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Afficher un message de succès
                showAlert('Client ajouté avec succès !', 'success');
                
                // Fermer la modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addClientModal'));
                if (modal) {
                    modal.hide();
                }
                
                // Réinitialiser le formulaire
                addClientForm.reset();
                
                // Recharger la page après 1 seconde
                setTimeout(() => {
                    location.reload();
                }, 1000);
                
            } else {
                showAlert('Erreur: ' + (data.message || 'Impossible d\'ajouter le client'), 'danger');
            }
        })
        .catch(error => {
            console.error('Erreur fetch:', error);
            showAlert('Erreur réseau: ' + error.message, 'danger');
        })
        .finally(() => {
            // Restaurer le bouton
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Fonction pour afficher une alerte
    function showAlert(message, type) {
        // Créer l'alerte
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        alertDiv.innerHTML = `
            <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Ajouter au document
        document.body.appendChild(alertDiv);
        
        // Supprimer automatiquement après 5 secondes
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    function selectTable(buttonElement, reservationId, tableId, tableNum, tableCapacity) {
    console.log('Sélection:', {reservationId, tableId, tableNum, tableCapacity});
    
    // Stocker la sélection
    selectedTables[reservationId] = {
        tableId: tableId,
        tableNum: tableNum,
        tableCapacity: tableCapacity,
        button: buttonElement
    };
    
    // Réinitialiser tous les boutons pour cette réservation
    document.querySelectorAll(`[data-reservation="${reservationId}"]`).forEach(btn => {
        btn.classList.remove('btn-success', 'active');
        btn.classList.add('btn-outline-success');
    });
    
    // Mettre en évidence la table sélectionnée
    buttonElement.classList.remove('btn-outline-success');
    buttonElement.classList.add('btn-success', 'active');
    
    // Activer le bouton d'assignation
    const assignBtn = document.getElementById(`assignBtn${reservationId}`);
    if (assignBtn) {
        assignBtn.disabled = false;
        assignBtn.setAttribute('data-table-id', tableId);
        assignBtn.setAttribute('data-table-num', tableNum);
    }
    
    // Feedback visuel
    showTempMessage(`Table ${tableNum} sélectionnée`, 'success');
}

// Assigner la réservation
function assignReservation(reservationId) {
    const assignBtn = document.getElementById(`assignBtn${reservationId}`);
    const tableId = assignBtn.getAttribute('data-table-id');
    const tableNum = assignBtn.getAttribute('data-table-num');
    
    if (!tableId) {
        alert('Veuillez d\'abord sélectionner une table');
        return;
    }
    
    // Récupérer le nom du client
    const reservationCard = assignBtn.closest('.reservation-card');
    const clientName = reservationCard.querySelector('h6').textContent;
    
    // Confirmation
    if (!confirm(`Confirmer l'assignation de la Table ${tableNum} à ${clientName} ?`)) {
        return;
    }
    
    // Désactiver le bouton pendant l'envoi
    assignBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> En cours...';
    assignBtn.disabled = true;
    
    // Envoyer la requête
    fetch('?url=serveur/assignerTable', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            reservation_id: reservationId,
            table_id: tableId,
            client_name: clientName,
            table_num: tableNum
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Succès
            assignBtn.innerHTML = '<i class="bi bi-check-all"></i> Assignée';
            assignBtn.classList.remove('btn-success');
            assignBtn.classList.add('btn-secondary');
            
            // Mettre à jour le badge
            const badge = reservationCard.querySelector('.badge.bg-danger');
            if (badge) {
                badge.classList.remove('bg-danger');
                badge.classList.add('bg-success');
                badge.innerHTML = '<i class="bi bi-check-lg"></i> Assignée';
            }
            
            // Afficher un message de succès
            showTempMessage(`Table ${tableNum} assignée à ${clientName}`, 'success');
            
            // Recharger après 2 secondes
            setTimeout(() => location.reload(), 2000);
        } else {
            // Erreur
            assignBtn.innerHTML = '<i class="bi bi-check-lg"></i> Assigner la table';
            assignBtn.disabled = false;
            alert('Erreur: ' + (data.message || 'Échec de l\'assignation'));
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        assignBtn.innerHTML = '<i class="bi bi-check-lg"></i> Assigner la table';
        assignBtn.disabled = false;
        alert('Erreur réseau: ' + error.message);
    });
}

// Message temporaire
function showTempMessage(message, type = 'info') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type} position-fixed`;
    messageDiv.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        animation: fadeIn 0.3s, fadeOut 0.3s 2.7s;
    `;
    messageDiv.textContent = message;
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 3000);
}


    
    // Initialiser la vérification des tables disponibles
    checkAvailableTables();
});
</script>

<!-- =========================
     STYLES CSS INTÉGRÉS
========================= -->
<style>
/* ================================
   GLOBAL
================================ */
body {
    font-family: "Poppins", sans-serif;
    background: #f5f6fa;
    margin: 0;
    padding: 0;
}

/* Légende */
.legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    margin-right: 8px;
}
.legend-color.libre { background-color: #28a745; border: 2px solid #218838; }
.legend-color.occupee { background-color: #dc3545; border: 2px solid #c82333; }
.legend-color.reservee { background-color: #ffc107; border: 2px solid #e0a800; }
.legend-text {
    font-size: 0.9rem;
    font-weight: 500;
}

/* Zones */
.zone-title {
    color: #495057;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 10px;
    font-weight: 600;
}
.table-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

/* Table cards */
.table-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    position: relative;
    border: 3px solid transparent;
    min-height: 140px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.table-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}
.table-libre {
    border-color: #28a745;
    background: linear-gradient(135deg, #f8fff9 0%, #e8f5e9 100%);
}
.table-occupee {
    border-color: #dc3545;
    background: linear-gradient(135deg, #fff8f8 0%, #ffebee 100%);
    animation: pulse 2s infinite;
}
.table-reservee {
    border-color: #ffc107;
    background: linear-gradient(135deg, #fffdf0 0%, #fff9e6 100%);
    animation: shimmer 3s infinite linear;
}

/* Numéro de table */
.table-number {
    font-size: 2rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 8px;
}

/* Icône */
.table-status-icon { font-size: 1.5rem; margin-bottom: 10px; }
.table-libre .table-status-icon { color: #28a745; }
.table-occupee .table-status-icon { color: #dc3545; }
.table-reservee .table-status-icon { color: #ffc107; }

/* Capacité */
.table-capacity { margin-bottom: 8px; }

/* Client et personnes */
.table-client {
    background: rgba(0,0,0,0.05);
    border-radius: 6px;
    padding: 4px 8px;
    margin-top: 5px;
    max-width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.table-persons {
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 4px;
    padding: 2px 6px;
    font-size: 0.8rem;
    margin-top: 5px;
}

/* Urgent badge */
.table-urgent { position: absolute; top: 8px; right: 8px; }

/* Free tables grid */
.free-tables-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
    gap: 10px;
}
.free-table-item {
    background: #28a745;
    color: white;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
}
.free-table-item:hover {
    background: #218838;
    transform: scale(1.05);
}
.free-table-number { font-size: 1.5rem; font-weight: bold; }
.free-table-info { font-size: 0.8rem; opacity: 0.9; }

/* ================================
   MODAL NOUVEAU CLIENT
================================ */
#addClientModal .modal-dialog {
    max-width: 500px;
}

.service-type-card .form-check-input {
    display: none;
}

.service-type-card .form-check-label {
    cursor: pointer;
    transition: all 0.3s ease;
}

.service-type-card .form-check-label > div {
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
}

.service-type-card .form-check-input:checked + .form-check-label > div {
    border-color: var(--bs-primary);
    background-color: rgba(var(--bs-primary-rgb), 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.service-type-card .form-check-input:checked + .form-check-label .text-primary {
    color: var(--bs-primary) !important;
}

.service-type-card .form-check-input:checked + .form-check-label .text-success {
    color: var(--bs-success) !important;
}

/* Animation pour les cartes de service */
.service-type-card:hover .form-check-label > div {
    border-color: #adb5bd;
    transform: translateY(-1px);
}

/* Style pour les champs obligatoires */
.form-label:after {
    content: " *";
    color: #dc3545;
}

/* Style pour l'alerte de tables disponibles */
#availableTablesAlert {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Bouton de soumission */
#addClientForm button[type="submit"]:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Animations */
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}
@keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: 200px 0; }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-20px); }
}

/* Style pour les boutons sélectionnés */
.btn-outline-success.active {
    background-color: #198754 !important;
    color: white !important;
    border-color: #198754 !important;
}

/* Désactiver les autres boutons après sélection */
.table-choice:not(.active) {
    opacity: 0.7;
}

/* Responsive */
@media (max-width: 768px) {
    .table-grid { grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; }
    .table-card { padding: 10px; min-height: 120px; }
    .table-number { font-size: 1.5rem; }
}
</style>