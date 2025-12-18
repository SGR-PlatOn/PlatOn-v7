<?php
// Activer les erreurs pour debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupérer les données depuis le contrôleur
$stats = $stats ?? [
    'reservations_aujourdhui' => 12,
    'personnel_service' => 8,
    'taux_occupation' => 75,
    'clients_salle' => 24,
    'commandes_cours' => 15
];

$reservations = $reservations ?? [];
$tables = $tables ?? [];
?>

<h1><i class="bi bi-chevron-right"></i> Dashboard Gérant</h1>
<p class="lead">Restaurant PlatOn - <?= date('d/m/Y') ?></p>

<!-- Statistiques améliorées -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stat-card border-top border-primary">
            <div class="card-body text-center">
                <h5 class="text-muted">Réservations</h5>
                <h2 class="text-primary"><?= $stats['reservations_aujourdhui'] ?></h2>
                <small class="text-muted">Aujourd'hui</small>
                <button class="btn btn-sm btn-outline-primary mt-2" onclick="nouvelleReservation()">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card border-top border-success">
            <div class="card-body text-center">
                <h5 class="text-muted">Personnel</h5>
                <h2 class="text-success"><?= $stats['personnel_service'] ?></h2>
                <small class="text-muted">En service</small>
                <button class="btn btn-sm btn-outline-success mt-2" onclick="gererPersonnel()">
                    <i class="bi bi-people"></i> Gérer
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card stat-card border-top border-info">
            <div class="card-body text-center">
                <h5 class="text-muted">Taux occupation</h5>
                <h2 class="text-info"><?= $stats['taux_occupation'] ?>%</h2>
                <small class="text-muted">Tables occupées</small>
                <button class="btn btn-sm btn-outline-info mt-2" onclick="voirStatistiques()">
                    <i class="bi bi-bar-chart"></i> Détails
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-primary w-100 h-100" onclick="nouvelleReservation()">
                            <i class="bi bi-calendar-plus display-6 mb-2"></i><br>
                            Nouvelle réservation
                        </button>
                    </div>
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-success w-100 h-100" onclick="gererMenu()">
                            <i class="bi bi-menu-button-wide display-6 mb-2"></i><br>
                            Gérer menu
                        </button>
                    </div>
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-warning w-100 h-100" onclick="voirStatistiques()">
                            <i class="bi bi-graph-up display-6 mb-2"></i><br>
                            Statistiques
                        </button>
                    </div>
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-info w-100 h-100" onclick="gererTables()">
                            <i class="bi bi-grid-3x3-gap display-6 mb-2"></i><br>
                            Gérer tables
                        </button>
                    </div>
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-secondary w-100 h-100" onclick="exporterDonnees()">
                            <i class="bi bi-download display-6 mb-2"></i><br>
                            Exporter
                        </button>
                    </div>
                    <div class="col-md-2 col-6">
                        <button class="btn btn-outline-dark w-100 h-100" onclick="parametresRestaurant()">
                            <i class="bi bi-gear display-6 mb-2"></i><br>
                            Paramètres
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Gestion des réservations -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar3"></i> Réservations du jour</h5>
                <button class="btn btn-primary btn-sm" onclick="nouvelleReservation()">
                    <i class="bi bi-plus-circle"></i> Ajouter
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Heure</th>
                                <th>Client</th>
                                <th>Personnes</th>
                                <th>Table</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="reservationsTable">
                            <!-- Les données seront chargées dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau de bord latéral -->
    <div class="col-lg-4">
        <!-- Tables occupées -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-grid-3x3"></i> Occupation des tables</h5>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                            <h3 class="text-success mb-0"><?= $stats['taux_occupation'] ?>%</h3>
                            <small>Occupées</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-danger bg-opacity-10 rounded">
                            <h3 class="text-danger mb-0"><?= 100 - $stats['taux_occupation'] ?>%</h3>
                            <small>Libres</small>
                        </div>
                    </div>
                </div>
                
                <div id="tablesOccupation" class="d-flex flex-wrap gap-2">
                    <!-- Tables seront chargées ici -->
                </div>
                
                <button class="btn btn-outline-secondary btn-sm w-100 mt-3" onclick="gererTables()">
                    <i class="bi bi-pencil"></i> Modifier configuration
                </button>
            </div>
        </div>

        <!-- Notifications -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bell"></i> Notifications</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush" id="notificationsList">
                    <!-- Notifications en temps réel -->
                </div>
                <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="voirToutesNotifications()">
                    <i class="bi bi-list"></i> Voir toutes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modals et scripts -->
<!-- Modal Nouvelle Réservation -->
<div class="modal fade" id="nouvelleReservationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-calendar-plus"></i> Nouvelle Réservation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formNouvelleReservation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom du client *</label>
                        <input type="text" class="form-control" name="nom_client" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre de personnes *</label>
                            <input type="number" class="form-control" name="personnes" min="1" max="12" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heure *</label>
                            <input type="time" class="form-control" name="heure" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" name="telephone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'assignation des tables -->
<div class="modal fade" id="assignerTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="assignerTableModalLabel">
                    <i class="bi bi-geo-alt"></i> Assigner une table
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <!-- Informations de la réservation -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-person-badge"></i> Informations de la réservation</h6>
                    </div>
                    <div class="card-body">
                        <div class="row" id="reservationInfo">
                            <!-- Rempli dynamiquement -->
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Plan des tables -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-grid-3x3"></i> Plan des tables disponibles</h6>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-success active" data-filter="all">Toutes</button>
                                    <button class="btn btn-outline-success" data-filter="enough">Capacité OK</button>
                                    <button class="btn btn-outline-success" data-filter="near">Proches</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Légende -->
                                <div class="d-flex justify-content-center mb-3">
                                    <div class="d-flex align-items-center me-3">
                                        <div class="legend-dot bg-success"></div>
                                        <small class="ms-1">Libre</small>
                                    </div>
                                    <div class="d-flex align-items-center me-3">
                                        <div class="legend-dot bg-danger"></div>
                                        <small class="ms-1">Occupée</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="legend-dot bg-warning"></div>
                                        <small class="ms-1">Réservée</small>
                                    </div>
                                </div>
                                
                                <!-- Grille des tables -->
                                <div class="table-assign-grid" id="tableGrid">
                                    <!-- Tables chargées dynamiquement -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Détails et actions -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Table sélectionnée</h6>
                            </div>
                            <div class="card-body text-center" id="selectedTableInfo">
                                <div class="py-4 text-muted">
                                    <i class="bi bi-table display-4"></i>
                                    <p class="mt-2 mb-0">Aucune table sélectionnée</p>
                                    <small>Cliquez sur une table disponible</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-lightning"></i> Actions rapides</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-success" id="btnAssigner" disabled>
                                        <i class="bi bi-check-lg"></i> Assigner cette table
                                    </button>
                                    <button class="btn btn-outline-primary" id="btnAutoAssign">
                                        <i class="bi bi-magic"></i> Assigner automatiquement
                                    </button>
                                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x"></i> Annuler
                                    </button>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notifyClient">
                                        <label class="form-check-label small" for="notifyClient">
                                            Notifier le client par SMS
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="printTicket" checked>
                                        <label class="form-check-label small" for="printTicket">
                                            Imprimer le ticket de table
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gestion Personnel -->
<div class="modal fade" id="personnelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-people"></i> Gestion du Personnel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="personnelContent">
                <!-- Contenu chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<script>
// Variables globales
let currentReservation = null;
let selectedTable = null;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    chargerReservations();
    chargerTablesOccupation();
    chargerNotifications();
    setupEventListeners();
});

// Charger les réservations
function chargerReservations() {
    fetch('?url=gerant/getReservations')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('reservationsTable');
            tbody.innerHTML = '';
            
            data.forEach(res => {
                const assignButton = res.table ? '' : 
                    `<button class="btn btn-sm btn-outline-success btn-assigner me-1"
                            data-reservation-id="${res.id}"
                            data-client-name="${res.client}"
                            data-persons="${res.personnes}"
                            data-time="${res.heure}">
                        <i class="bi bi-geo-alt"></i> Assigner
                    </button>`;
                
                const row = `
                    <tr>
                        <td>${res.heure}</td>
                        <td><strong>${res.client}</strong></td>
                        <td><span class="badge bg-info">${res.personnes} pers.</span></td>
                        <td>${res.table ? 'Table ' + res.table : '<span class="text-danger">À assigner</span>'}</td>
                        <td>${getStatusBadge(res.statut)}</td>
                        <td>
                            ${assignButton}
                            <button class="btn btn-sm btn-outline-warning me-1" onclick="modifierReservation(${res.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="supprimerReservation(${res.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
            
            // Initialiser les boutons d'assignation
            initAssignButtons();
        })
        .catch(error => console.error('Erreur:', error));
}

// Initialiser les boutons d'assignation
function initAssignButtons() {
    document.querySelectorAll('.btn-assigner').forEach(button => {
        button.addEventListener('click', function() {
            const reservationId = this.getAttribute('data-reservation-id');
            const clientName = this.getAttribute('data-client-name');
            const persons = this.getAttribute('data-persons');
            const time = this.getAttribute('data-time');
            
            ouvrirAssignation(reservationId, clientName, persons, time);
        });
    });
}

// Charger l'occupation des tables
function chargerTablesOccupation() {
    fetch('?url=gerant/getTablesOccupation')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('tablesOccupation');
            container.innerHTML = '';
            
            data.tables.forEach(table => {
                const badge = `
                    <span class="badge ${table.statut === 'libre' ? 'bg-success' : 'bg-danger'} p-2">
                        Table ${table.numero} (${table.places})
                    </span>
                `;
                container.innerHTML += badge;
            });
        });
}

// Charger les notifications
function chargerNotifications() {
    fetch('?url=gerant/getNotifications')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('notificationsList');
            container.innerHTML = '';
            
            data.notifications.forEach(notif => {
                const item = `
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">${notif.titre}</h6>
                            <small class="text-muted">${notif.heure}</small>
                        </div>
                        <p class="mb-1">${notif.message}</p>
                    </div>
                `;
                container.innerHTML += item;
            });
        });
}

// Fonctions des boutons
function nouvelleReservation() {
    const modal = new bootstrap.Modal(document.getElementById('nouvelleReservationModal'));
    modal.show();
}

function gererPersonnel() {
    fetch('?url=gerant/personnel')
        .then(response => response.text())
        .then(html => {
            document.getElementById('personnelContent').innerHTML = html;
            const modal = new bootstrap.Modal(document.getElementById('personnelModal'));
            modal.show();
        });
}

function gererMenu() {
    window.location.href = '?url=gerant/menu';
}

function voirStatistiques() {
    window.location.href = '?url=gerant/statistiques';
}

function gererTables() {
    window.location.href = '?url=gerant/tables';
}

function exporterDonnees() {
    if (confirm('Exporter les données du jour au format CSV ?')) {
        fetch('?url=gerant/export')
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `platon_export_${new Date().toISOString().split('T')[0]}.csv`;
                a.click();
            });
    }
}

function exportReport() {
    if (confirm('Générer un rapport détaillé du jour ?')) {
        fetch('?url=gerant/rapport')
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `rapport_platon_${new Date().toISOString().split('T')[0]}.pdf`;
                a.click();
            });
    }
}

function parametresRestaurant() {
    window.location.href = '?url=gerant/parametres';
}

// Interface d'assignation des tables
function ouvrirAssignation(reservationId, clientName, persons, time) {
    currentReservation = {
        id: reservationId,
        client: clientName,
        persons: persons,
        time: time
    };
    
    // Mettre à jour les infos de réservation
    document.getElementById('reservationInfo').innerHTML = `
        <div class="col-md-4">
            <div class="text-center p-3 bg-primary bg-opacity-10 rounded">
                <h6 class="text-primary mb-1">Client</h6>
                <h4 class="mb-0">${clientName}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center p-3 bg-info bg-opacity-10 rounded">
                <h6 class="text-info mb-1">Personnes</h6>
                <h4 class="mb-0">${persons} <small class="text-muted">pers.</small></h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                <h6 class="text-warning mb-1">Heure</h6>
                <h4 class="mb-0">${time}</h4>
            </div>
        </div>
    `;
    
    // Charger les tables disponibles
    chargerTablesDisponibles(persons);
    
    // Ouvrir la modale
    const modal = new bootstrap.Modal(document.getElementById('assignerTableModal'));
    modal.show();
}

// Charger les tables disponibles
function chargerTablesDisponibles(minCapacity) {
    fetch('?url=gerant/getTablesDisponibles')
        .then(response => response.json())
        .then(tables => {
            const tableGrid = document.getElementById('tableGrid');
            tableGrid.innerHTML = '';
            
            tables.forEach(table => {
                const canAssign = table.statut === 'libre' && table.places >= minCapacity;
                const itemClass = `table-assign-item ${table.statut} ${canAssign ? 'clickable' : ''}`;
                
                const tableItem = document.createElement('div');
                tableItem.className = itemClass;
                tableItem.innerHTML = `
                    <div class="table-number">${table.numero}</div>
                    <div class="table-capacity">${table.places} places</div>
                    ${table.features ? `
                    <div class="table-features">
                        ${table.features.includes('terrasse') ? '<div class="table-feature terrasse" title="Terrasse"></div>' : ''}
                        ${table.features.includes('fenetre') ? '<div class="table-feature fenetre" title="Fenêtre"></div>' : ''}
                        ${table.features.includes('calme') ? '<div class="table-feature calme" title="Zone calme"></div>' : ''}
                    </div>
                    ` : ''}
                `;
                
                if (canAssign) {
                    tableItem.addEventListener('click', () => selectTable(table));
                } else {
                    tableItem.style.cursor = 'not-allowed';
                }
                
                tableGrid.appendChild(tableItem);
            });
            
            // Filtrer par défaut sur capacité suffisante
            filterTables('enough');
        });
}

// Sélectionner une table
function selectTable(table) {
    selectedTable = table;
    
    // Mettre en évidence la table sélectionnée
    document.querySelectorAll('.table-assign-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    event.target.closest('.table-assign-item').classList.add('selected');
    
    // Afficher les infos de la table sélectionnée
    document.getElementById('selectedTableInfo').innerHTML = `
        <div class="selected-table-card border border-primary rounded p-3">
            <div class="table-number-large mb-2" style="font-size: 2rem; font-weight: bold;">${table.numero}</div>
            <div class="mb-3">
                <span class="badge bg-primary">${table.places} places</span>
                ${table.zone ? `<span class="badge bg-secondary ms-1">${table.zone}</span>` : ''}
            </div>
            <div class="table-details">
                <p class="mb-1"><i class="bi bi-check-circle text-success"></i> Capacité suffisante</p>
                <p class="mb-0"><i class="bi bi-clock"></i> Libre depuis ${table.libre_depuis || '--:--'}</p>
            </div>
        </div>
    `;
    
    // Activer le bouton d'assignation
    document.getElementById('btnAssigner').disabled = false;
}

// Assigner la table
document.getElementById('btnAssigner').addEventListener('click', function() {
    if (!currentReservation || !selectedTable) return;
    
    const notifySMS = document.getElementById('notifyClient').checked;
    const printTicket = document.getElementById('printTicket').checked;
    
    // Afficher une confirmation
    if (confirm(`Assigner la Table ${selectedTable.numero} à ${currentReservation.client} ?`)) {
        // Désactiver le bouton pendant l'opération
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Assignation...';
        this.disabled = true;
        
        // Envoyer la requête
        fetch('?url=gerant/assignerTable', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                reservation_id: currentReservation.id,
                table_id: selectedTable.id,
                notify_sms: notifySMS,
                print_ticket: printTicket
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Succès
                showNotification(`Table ${selectedTable.numero} assignée à ${currentReservation.client}`, 'success');
                
                // Fermer la modale
                bootstrap.Modal.getInstance(document.getElementById('assignerTableModal')).hide();
                
                // Rafraîchir la liste des réservations
                setTimeout(() => {
                    chargerReservations();
                    chargerTablesOccupation();
                }, 500);
                
            } else {
                // Erreur
                showNotification('Erreur: ' + (data.message || 'Échec de l\'assignation'), 'danger');
                this.innerHTML = '<i class="bi bi-check-lg"></i> Assigner cette table';
                this.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur réseau', 'danger');
            this.innerHTML = '<i class="bi bi-check-lg"></i> Assigner cette table';
            this.disabled = false;
        });
    }
});

// Assignation automatique
document.getElementById('btnAutoAssign').addEventListener('click', function() {
    if (!currentReservation) return;
    
    this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Recherche...';
    this.disabled = true;
    
    fetch('?url=gerant/autoAssignTable', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            reservation_id: currentReservation.id,
            personnes: currentReservation.persons
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.table) {
            // Simuler la sélection de la table
            selectTable(data.table);
            showNotification(`Table ${data.table.numero} suggérée automatiquement`, 'info');
        } else {
            showNotification('Aucune table disponible pour l\'assignation automatique', 'warning');
        }
        
        this.innerHTML = '<i class="bi bi-magic"></i> Assigner automatiquement';
        this.disabled = false;
    });
});

// Filtrer les tables
document.querySelectorAll('[data-filter]').forEach(button => {
    button.addEventListener('click', function() {
        const filter = this.getAttribute('data-filter');
        
        // Activer le bouton sélectionné
        document.querySelectorAll('[data-filter]').forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        
        filterTables(filter);
    });
});

function filterTables(filterType) {
    const tables = document.querySelectorAll('.table-assign-item');
    const minCapacity = currentReservation ? currentReservation.persons : 0;
    
    tables.forEach(table => {
        const capacity = parseInt(table.querySelector('.table-capacity').textContent);
        const isFree = table.classList.contains('libre');
        
        let show = true;
        
        switch(filterType) {
            case 'enough':
                show = isFree && capacity >= minCapacity;
                break;
            case 'near':
                // Ici tu pourrais ajouter une logique de proximité
                show = isFree && capacity >= minCapacity && capacity <= minCapacity + 2;
                break;
            default: // 'all'
                show = true;
        }
        
        table.style.display = show ? 'flex' : 'none';
    });
}

function modifierReservation(reservationId) {
    const nouveauNom = prompt('Nouveau nom du client:');
    if (nouveauNom) {
        fetch('?url=gerant/modifierReservation', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: reservationId, nom_client: nouveauNom})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Réservation modifiée !', 'success');
                chargerReservations();
            }
        });
    }
}

function supprimerReservation(reservationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        fetch('?url=gerant/supprimerReservation', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: reservationId})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Réservation supprimée !', 'success');
                chargerReservations();
            }
        });
    }
}

function voirToutesNotifications() {
    window.location.href = '?url=gerant/notifications';
}

// Utilitaires
function getStatusBadge(status) {
    const badges = {
        'confirme': '<span class="badge bg-success">Confirmée</span>',
        'attente': '<span class="badge bg-warning">En attente</span>',
        'annule': '<span class="badge bg-danger">Annulée</span>',
        'termine': '<span class="badge bg-secondary">Terminée</span>'
    };
    return badges[status] || '<span class="badge bg-info">' + status + '</span>';
}

// Fonction utilitaire pour les notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s;
    `;
    notification.innerHTML = `
        <i class="bi ${type === 'success' ? 'bi-check-circle' : 
                       type === 'warning' ? 'bi-exclamation-triangle' : 
                       'bi-info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Gestion du formulaire nouvelle réservation
document.getElementById('formNouvelleReservation').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('?url=gerant/ajouterReservation', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showNotification('Réservation ajoutée avec succès !', 'success');
            document.getElementById('nouvelleReservationModal').querySelector('.btn-close').click();
            this.reset();
            chargerReservations();
        } else {
            showNotification('Erreur: ' + result.message, 'danger');
        }
    });
});

// Mise à jour en temps réel
setInterval(() => {
    chargerReservations();
    chargerNotifications();
}, 30000); // Toutes les 30 secondes
</script>

<style>
/* ================================
   STYLES GÉNÉRAUX
================================ */
.stat-card {
    transition: transform 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.btn-action {
    min-height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

#tablesOccupation .badge {
    cursor: pointer;
    transition: all 0.2s;
}
#tablesOccupation .badge:hover {
    transform: scale(1.05);
}

/* ================================
   STYLES POUR LA MODALE D'ASSIGNATION
================================ */
.table-assign-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 12px;
}

.table-assign-item {
    aspect-ratio: 1;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 3px solid transparent;
    position: relative;
}

.table-assign-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.table-assign-item.libre {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    border-color: #4caf50;
}

.table-assign-item.occupee {
    background: linear-gradient(135deg, #ffebee, #ffcdd2);
    border-color: #f44336;
    opacity: 0.6;
    cursor: not-allowed;
}

.table-assign-item.reservee {
    background: linear-gradient(135deg, #fff3e0, #ffe0b2);
    border-color: #ff9800;
    opacity: 0.7;
    cursor: not-allowed;
}

.table-assign-item.selected {
    background: linear-gradient(135deg, #bbdefb, #90caf9);
    border-color: #2196f3;
    transform: scale(1.05);
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.3);
}

.table-number {
    font-size: 1.8rem;
    font-weight: bold;
    color: #2c3e50;
}

.table-capacity {
    font-size: 0.8rem;
    background: rgba(0,0,0,0.1);
    border-radius: 12px;
    padding: 2px 8px;
    margin-top: 5px;
}

.legend-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.table-features {
    position: absolute;
    top: 5px;
    right: 5px;
    display: flex;
    gap: 3px;
}

.table-feature {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #666;
}

.table-feature.terrasse { background: #4caf50; }
.table-feature.fenetre { background: #2196f3; }
.table-feature.calme { background: #9c27b0; }

.selected-table-card {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(33, 150, 243, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(33, 150, 243, 0); }
    100% { box-shadow: 0 0 0 0 rgba(33, 150, 243, 0); }
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .table-assign-grid {
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 8px;
    }
    .table-number {
        font-size: 1.5rem;
    }
}
</style>