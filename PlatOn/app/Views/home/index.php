<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="text-center mb-5">
            <h1 class="display-4">Réservez votre table</h1>
            <p class="lead">Contactez-nous pour réserver ou pour toute demande d'information</p>
        </div>
        
        <div class="row">
            <!-- Informations pratiques -->
            <div class="col-md-5 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="bi bi-info-circle"></i> Informations pratiques</h4>
                        
                        <div class="mb-3">
                            <h6><i class="bi bi-geo-alt"></i> Adresse</h6>
                            <p>15 Rue de la Paix<br>75002 Paris, France</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="bi bi-telephone"></i> Téléphone</h6>
                            <p>+33 1 23 45 67 89</p>
                        </div>
                        
                        <div class="mb-3">
                            <h6><i class="bi bi-envelope"></i> Email</h6>
                            <p>contact@platon-restaurant.fr</p>
                        </div>
                        
                        <div>
                            <h6><i class="bi bi-clock"></i> Horaires</h6>
                            <p>Mardi - Samedi : 12h00 - 14h30 / 19h00 - 23h00<br>
                               Dimanche - Lundi : Fermé</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire de réservation -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4"><i class="bi bi-calendar-check"></i> Formulaire de réservation</h4>
                        
                        <form action="<?php echo BASE_URL; ?>/home/reserve" method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Prénom</label>
                                    <input type="text" class="form-control" name="prenom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom</label>
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="telephone" required>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date souhaitée</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre de personnes</label>
                                    <select class="form-select" name="personnes" required>
                                        <?php for ($i = 1; $i <= 8; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo $i == 2 ? 'selected' : ''; ?>>
                                                <?php echo $i; ?> personne<?php echo $i > 1 ? 's' : ''; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Message (allergies, occasion spéciale...)</label>
                                <textarea class="form-control" name="message" rows="3"></textarea>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <small>Pour garantir votre place, nous vous conseillons de réserver au moins 48h à l'avance.</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send"></i> Envoyer la demande de réservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>