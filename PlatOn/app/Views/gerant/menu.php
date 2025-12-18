<?php
// Récupérer les données depuis le contrôleur
$categories = $categories ?? [];
$plats = $plats ?? [];
$statsMenu = $statsMenu ?? [];
?>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2"><i class="bi bi-menu-button-wide"></i> Gestion du Menu</h1>
            <p class="lead mb-0">Restaurant PlatOn - Création et modification des plats</p>
        </div>
        <button class="btn btn-primary" onclick="ouvrirModalNouveauPlat()">
            <i class="bi bi-plus-circle"></i> Nouveau plat
        </button>
    </div>

    <!-- Statistiques du menu -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <h5 class="text-muted">Plats actifs</h5>
                    <h2 class="text-primary"><?= $statsMenu['plats_actifs'] ?? 0 ?></h2>
                    <small class="text-muted">Disponibles</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="text-muted">Catégories</h5>
                    <h2 class="text-success"><?= $statsMenu['categories'] ?? 0 ?></h2>
                    <small class="text-muted">Sections</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <h5 class="text-muted">Plats populaires</h5>
                    <h2 class="text-warning"><?= $statsMenu['plats_populaires'] ?? 0 ?></h2>
                    <small class="text-muted">+10 commandes/jour</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <h5 class="text-muted">Stock faible</h5>
                    <h2 class="text-info"><?= $statsMenu['stock_faible'] ?? 0 ?></h2>
                    <small class="text-muted">À réapprovisionner</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Catégorie</label>
                    <select class="form-select" id="filtreCategorie" onchange="filtrerPlats()">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select class="form-select" id="filtreStatut" onchange="filtrerPlats()">
                        <option value="">Tous les statuts</option>
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                        <option value="epuise">Épuisé</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="recherchePlat" placeholder="Nom du plat, ingrédients..." onkeyup="filtrerPlats()">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" onclick="reinitialiserFiltres()">
                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des plats -->
    <div class="row">
        <!-- Catégories -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-tags"></i> Catégories</h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="ouvrirModalCategorie()">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                <div class="list-group list-group-flush" id="listeCategories">
                    <?php foreach ($categories as $categorie): ?>
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-item"
                         data-category-id="<?= $categorie['id'] ?>"
                         onclick="filtrerParCategorie(<?= $categorie['id'] ?>)">
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($categorie['nom']) ?></h6>
                            <small class="text-muted"><?= $categorie['plats_count'] ?? 0 ?> plats</small>
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-warning" onclick="editerCategorie(event, <?= $categorie['id'] ?>)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="supprimerCategorie(event, <?= $categorie['id'] ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Plats -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-egg-fried"></i> Plats</h5>
                    <span class="badge bg-primary" id="platCount"><?= count($plats) ?> plats</span>
                </div>
                <div class="card-body">
                    <div class="row" id="listePlats">
                        <?php foreach ($plats as $plat): ?>
                        <div class="col-md-6 col-lg-4 mb-4 plat-card" 
                             data-category="<?= $plat['categorie_id'] ?>"
                             data-statut="<?= $plat['statut'] ?>"
                             data-nom="<?= strtolower($plat['nom']) ?>">
                            <div class="card h-100 border <?= $plat['statut'] === 'actif' ? 'border-success' : ($plat['statut'] === 'epuise' ? 'border-danger' : 'border-secondary') ?>">
                                <?php if (!empty($plat['image'])): ?>
                                <img src="<?= $plat['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($plat['nom']) ?>" style="height: 150px; object-fit: cover;">
                                <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <i class="bi bi-egg-fried display-4 text-secondary"></i>
                                </div>
                                <?php endif; ?>
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0"><?= htmlspecialchars($plat['nom']) ?></h5>
                                        <span class="badge <?= $plat['statut'] === 'actif' ? 'bg-success' : ($plat['statut'] === 'epuise' ? 'bg-danger' : 'bg-secondary') ?>">
                                            <?= $plat['statut'] === 'actif' ? 'Actif' : ($plat['statut'] === 'epuise' ? 'Épuisé' : 'Inactif') ?>
                                        </span>
                                    </div>
                                    
                                    <p class="card-text text-muted small mb-2">
                                        <?= !empty($plat['description']) ? htmlspecialchars(substr($plat['description'], 0, 80)) . '...' : 'Aucune description' ?>
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="h5 text-primary mb-0"><?= number_format($plat['prix'], 2, ',', ' ') ?> €</span>
                                        <span class="badge bg-info"><?= $plat['categorie_nom'] ?></span>
                                    </div>
                                    
                                    <div class="plat-info small mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <i class="bi bi-clock"></i> <?= $plat['temps_preparation'] ?> min
                                            </div>
                                            <div class="col-6 text-end">
                                                <i class="bi bi-bar-chart"></i> <?= $plat['ventes'] ?? 0 ?> ventes
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-outline-warning" onclick="editerPlat(<?= $plat['id'] ?>)">
                                            <i class="bi bi-pencil"></i> Modifier
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="supprimerPlat(<?= $plat['id'] ?>)">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                        <button class="btn btn-sm btn-outline-info" onclick="dupliquerPlat(<?= $plat['id'] ?>)">
                                            <i class="bi bi-copy"></i> Dupliquer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nouveau/Édition Plat -->
<div class="modal fade" id="platModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="platModalTitle"><i class="bi bi-egg-fried"></i> Nouveau plat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="platForm">
                <div class="modal-body">
                    <input type="hidden" id="platId" name="id">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="platNom" class="form-label">Nom du plat *</label>
                                <input type="text" class="form-control" id="platNom" name="nom" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="platDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="platDescription" name="description" rows="3"></textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="platPrix" class="form-label">Prix (€) *</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="platPrix" name="prix" step="0.01" min="0" required>
                                            <span class="input-group-text">€</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="platTemps" class="form-label">Temps de préparation (min)</label>
                                        <input type="number" class="form-control" id="platTemps" name="temps_preparation" min="1" value="15">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="platCategorie" class="form-label">Catégorie *</label>
                                        <select class="form-select" id="platCategorie" name="categorie_id" required>
                                            <option value="">Sélectionner une catégorie</option>
                                            <?php foreach ($categories as $categorie): ?>
                                            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="platStatut" class="form-label">Statut *</label>
                                        <select class="form-select" id="platStatut" name="statut" required>
                                            <option value="actif">Actif</option>
                                            <option value="inactif">Inactif</option>
                                            <option value="epuise">Épuisé</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Image du plat</label>
                                <div class="image-upload-container">
                                    <div class="image-preview mb-2" id="imagePreview">
                                        <img src="" alt="Aperçu" class="img-fluid rounded" style="display: none;">
                                        <div class="no-image text-center py-4 text-muted">
                                            <i class="bi bi-image display-4"></i>
                                            <p class="mt-2 mb-0">Aucune image</p>
                                        </div>
                                    </div>
                                    <input type="file" class="form-control" id="platImage" name="image" accept="image/*" onchange="previewImage(this)">
                                    <small class="text-muted">JPG, PNG - Max 2MB</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Allergènes</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergenes[]" value="gluten" id="allergeneGluten">
                                    <label class="form-check-label" for="allergeneGluten">Gluten</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergenes[]" value="lactose" id="allergeneLactose">
                                    <label class="form-check-label" for="allergeneLactose">Lactose</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergenes[]" value="arachides" id="allergeneArachides">
                                    <label class="form-check-label" for="allergeneArachides">Arachides</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allergenes[]" value="crustaces" id="allergeneCrustaces">
                                    <label class="form-check-label" for="allergeneCrustaces">Crustacés</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ingrédients -->
                    <div class="mb-3">
                        <label class="form-label">Ingrédients</label>
                        <div class="ingredients-container">
                            <div id="ingredientsList"></div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="ajouterIngredient()">
                                <i class="bi bi-plus"></i> Ajouter un ingrédient
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="platSubmitBtn">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Catégorie -->
<div class="modal fade" id="categorieModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-tag"></i> Nouvelle catégorie</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="categorieForm">
                <input type="hidden" id="categorieId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categorieNom" class="form-label">Nom de la catégorie *</label>
                        <input type="text" class="form-control" id="categorieNom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="categorieDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categorieDescription" name="description" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categorieOrdre" class="form-label">Ordre d'affichage</label>
                        <input type="number" class="form-control" id="categorieOrdre" name="ordre" min="1" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Variables
let ingredientsCounter = 0;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le compteur de plats
    updatePlatCount();
});

// Filtrer les plats
function filtrerPlats() {
    const categorie = document.getElementById('filtreCategorie').value;
    const statut = document.getElementById('filtreStatut').value;
    const recherche = document.getElementById('recherchePlat').value.toLowerCase();
    
    const plats = document.querySelectorAll('.plat-card');
    let visibleCount = 0;
    
    plats.forEach(plat => {
        const platCategorie = plat.getAttribute('data-category');
        const platStatut = plat.getAttribute('data-statut');
        const platNom = plat.getAttribute('data-nom');
        
        let visible = true;
        
        if (categorie && platCategorie !== categorie) visible = false;
        if (statut && platStatut !== statut) visible = false;
        if (recherche && !platNom.includes(recherche)) visible = false;
        
        plat.style.display = visible ? 'block' : 'none';
        if (visible) visibleCount++;
    });
    
    updatePlatCount(visibleCount);
}

function filtrerParCategorie(categorieId) {
    document.getElementById('filtreCategorie').value = categorieId;
    filtrerPlats();
    
    // Mettre en évidence la catégorie sélectionnée
    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-category-id') == categorieId) {
            item.classList.add('active');
        }
    });
}

function reinitialiserFiltres() {
    document.getElementById('filtreCategorie').value = '';
    document.getElementById('filtreStatut').value = '';
    document.getElementById('recherchePlat').value = '';
    filtrerPlats();
    
    // Désélectionner les catégories
    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('active');
    });
}

function updatePlatCount(count = null) {
    const total = count !== null ? count : document.querySelectorAll('.plat-card').length;
    document.getElementById('platCount').textContent = total + ' plats';
}

// Gestion des plats
function ouvrirModalNouveauPlat() {
    document.getElementById('platModalTitle').textContent = 'Nouveau plat';
    document.getElementById('platForm').reset();
    document.getElementById('platId').value = '';
    document.getElementById('imagePreview').querySelector('img').style.display = 'none';
    document.getElementById('imagePreview').querySelector('.no-image').style.display = 'block';
    document.getElementById('ingredientsList').innerHTML = '';
    ingredientsCounter = 0;
    
    const modal = new bootstrap.Modal(document.getElementById('platModal'));
    modal.show();
}

function editerPlat(id) {
    // Charger les données du plat
    fetch(`?url=gerant/getPlat/${id}`)
        .then(response => response.json())
        .then(plat => {
            document.getElementById('platModalTitle').textContent = 'Modifier le plat';
            document.getElementById('platId').value = plat.id;
            document.getElementById('platNom').value = plat.nom;
            document.getElementById('platDescription').value = plat.description || '';
            document.getElementById('platPrix').value = plat.prix;
            document.getElementById('platTemps').value = plat.temps_preparation || 15;
            document.getElementById('platCategorie').value = plat.categorie_id;
            document.getElementById('platStatut').value = plat.statut;
            
            // Image
            const imagePreview = document.getElementById('imagePreview');
            if (plat.image) {
                imagePreview.querySelector('img').src = plat.image;
                imagePreview.querySelector('img').style.display = 'block';
                imagePreview.querySelector('.no-image').style.display = 'none';
            }
            
            // Allergènes
            document.querySelectorAll('input[name="allergenes[]"]').forEach(cb => {
                cb.checked = plat.allergenes && plat.allergenes.includes(cb.value);
            });
            
            // Ingrédients
            document.getElementById('ingredientsList').innerHTML = '';
            ingredientsCounter = 0;
            if (plat.ingredients && plat.ingredients.length > 0) {
                plat.ingredients.forEach(ing => {
                    ajouterIngredient(ing.nom, ing.quantite, ing.unite);
                });
            }
            
            const modal = new bootstrap.Modal(document.getElementById('platModal'));
            modal.show();
        });
}

function ajouterIngredient(nom = '', quantite = '', unite = '') {
    ingredientsCounter++;
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" placeholder="Nom de l'ingrédient" name="ingredients[${ingredientsCounter}][nom]" value="${nom}">
        <input type="text" class="form-control" placeholder="Quantité" name="ingredients[${ingredientsCounter}][quantite]" value="${quantite}" style="max-width: 100px;">
        <select class="form-select" name="ingredients[${ingredientsCounter}][unite]" style="max-width: 120px;">
            <option value="g" ${unite === 'g' ? 'selected' : ''}>g</option>
            <option value="kg" ${unite === 'kg' ? 'selected' : ''}>kg</option>
            <option value="ml" ${unite === 'ml' ? 'selected' : ''}>ml</option>
            <option value="L" ${unite === 'L' ? 'selected' : ''}>L</option>
            <option value="unite" ${unite === 'unite' ? 'selected' : ''}>unité</option>
            <option value="c.a.c" ${unite === 'c.a.c' ? 'selected' : ''}>c.à.c</option>
            <option value="c.a.s" ${unite === 'c.a.s' ? 'selected' : ''}>c.à.s</option>
            <option value="pincee" ${unite === 'pincee' ? 'selected' : ''}>pincée</option>
        </select>
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    `;
    document.getElementById('ingredientsList').appendChild(div);
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = preview.querySelector('img');
    const noImage = preview.querySelector('.no-image');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            img.style.display = 'block';
            noImage.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        img.style.display = 'none';
        noImage.style.display = 'block';
    }
}

function supprimerPlat(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce plat ?')) {
        fetch(`?url=gerant/supprimerPlat/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Plat supprimé avec succès', 'success');
                // Recharger la page
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur: ' + data.message, 'danger');
            }
        });
    }
}

function dupliquerPlat(id) {
    if (confirm('Dupliquer ce plat ?')) {
        fetch(`?url=gerant/dupliquerPlat/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Plat dupliqué avec succès', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        });
    }
}

// Gestion des catégories
function ouvrirModalCategorie() {
    document.getElementById('categorieForm').reset();
    document.getElementById('categorieId').value = '';
    const modal = new bootstrap.Modal(document.getElementById('categorieModal'));
    modal.show();
}

function editerCategorie(event, id) {
    event.stopPropagation();
    
    fetch(`?url=gerant/getCategorie/${id}`)
        .then(response => response.json())
        .then(categorie => {
            document.getElementById('categorieId').value = categorie.id;
            document.getElementById('categorieNom').value = categorie.nom;
            document.getElementById('categorieDescription').value = categorie.description || '';
            document.getElementById('categorieOrdre').value = categorie.ordre || 1;
            
            const modal = new bootstrap.Modal(document.getElementById('categorieModal'));
            modal.show();
        });
}

function supprimerCategorie(event, id) {
    event.stopPropagation();
    
    if (confirm('Supprimer cette catégorie ? Les plats seront déplacés dans "Non classé".')) {
        fetch(`?url=gerant/supprimerCategorie/${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Catégorie supprimée', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        });
    }
}

// Soumission des formulaires
document.getElementById('platForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('platSubmitBtn');
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enregistrement...';
    submitBtn.disabled = true;
    
    const formData = new FormData(this);
    
    fetch('?url=gerant/sauvegarderPlat', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Plat enregistré avec succès', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Erreur: ' + data.message, 'danger');
            submitBtn.innerHTML = 'Enregistrer';
            submitBtn.disabled = false;
        }
    })
    .catch(error => {
        showNotification('Erreur réseau', 'danger');
        submitBtn.innerHTML = 'Enregistrer';
        submitBtn.disabled = false;
    });
});

document.getElementById('categorieForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('?url=gerant/sauvegarderCategorie', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Catégorie enregistrée', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Erreur: ' + data.message, 'danger');
        }
    });
});

// Notification
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
        <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle'} me-2"></i>
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
</script>

<style>
.plat-card {
    transition: transform 0.3s;
}
.plat-card:hover {
    transform: translateY(-5px);
}
.plat-card .card {
    transition: all 0.3s;
}
.plat-card:hover .card {
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.category-item.active {
    background-color: #e3f2fd;
    border-left: 3px solid #2196f3;
}

.category-item:hover {
    background-color: #f8f9fa;
}

.image-preview {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview img {
    max-height: 150px;
    width: auto;
}

.ingredients-container .input-group {
    animation: fadeIn 0.3s;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .plat-card {
        margin-bottom: 1rem;
    }
}
</style>