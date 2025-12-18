<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3><i class="bi bi-egg-fried text-primary"></i> PlatOn</h3>
                    <p class="text-muted">Connexion Staff</p>
                </div>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo BASE_URL; ?>/auth/check" method="POST">
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person-badge"></i> Rôle</label>
                        <select name="role" class="form-select" required>
                            <option value="chef">Chef de cuisine</option>
                            <option value="serveur">Serveur</option>
                            <option value="gerant">Gérant</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-key"></i> Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </button>
                </form>
                
                <div class="mt-3 text-center">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Mots de passe : chef123, serveur123, gerant123
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>