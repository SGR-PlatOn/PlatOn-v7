    </div> <!-- Ferme le container -->
    
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="bi bi-geo-alt"></i> PlatOn Restaurant</h5>
                    <p>15 Rue de la Paix<br>75002 Paris, France</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5><i class="bi bi-telephone"></i> Contact</h5>
                    <p>+33 1 23 45 67 89<br>contact@platon-restaurant.fr</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5><i class="bi bi-clock"></i> Horaires</h5>
                    <p>Mardi - Samedi<br>12h00 - 14h30 / 19h00 - 23h00</p>
                </div>
            </div>
            <hr class="bg-light">
            <p class="text-center mb-0">&copy; <?php echo date('Y'); ?> PlatOn Restaurant</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js (pour les graphiques) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
    // Scripts communs
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh pour les dashboards
        if (window.location.href.includes('dashboard')) {
            setInterval(() => {
                // Simuler un rafraîchissement léger
                console.log('Auto-refresh...');
            }, 30000);
        }
    });
    </script>
</body>
</html>