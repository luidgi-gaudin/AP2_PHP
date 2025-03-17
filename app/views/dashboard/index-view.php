<?php use App\Utils\Crypto; ?>

            <div class="neo-dashboard-container">
                <div class="neo-dashboard-header">
                    <h1>Tableau de bord</h1>
                </div>

                <div class="neo-dashboard-content">
                    <!-- Carte utilisateur (cachée par défaut) -->
                    <div class="neo-card" id="userCard" style="display: none;">
                        <div class="neo-card-header">
                            <h2>Bienvenue, <span id="username"></span></h2>
                        </div>
                        <div class="neo-card-body">
                            <div class="neo-info-item">
                                <span class="neo-label">Dernière connexion:</span>
                                <span class="neo-value" id="lastLogin"></span>
                            </div>
                            <div class="neo-info-item">
                                <span class="neo-label">Rôle:</span>
                                <span class="neo-value" id="userRole"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Indicateur de chargement -->
                    <div class="neo-loading-card" id="loadingCard">
                        <div class="neo-loading-icon">
                            <div class="neo-spinner"></div>
                        </div>
                        <div class="neo-loading-text">Chargement des données...</div>
                    </div>

                    <!-- Message d'erreur (caché par défaut) -->
                    <div class="neo-error-card" id="errorCard" style="display: none;">
                        <div class="neo-error-icon">!</div>
                        <div class="neo-error-text">Une erreur est survenue lors du chargement des données.</div>
                    </div>
                </div>
            </div>

            <style>
                .neo-dashboard-container {
                    max-width: 1000px;
                    margin: 0 auto;
                    padding: 0 20px;
                }

                .neo-dashboard-header {
                    text-align: center;
                    margin-bottom: 2rem;
                }

                .neo-dashboard-header h1 {
                    color: var(--text-color);
                    font-size: 2rem;
                    padding: 1rem;
                    display: inline-block;
                    border-radius: 15px;
                    box-shadow: 4px 4px 10px var(--shadow-dark), -4px -4px 10px var(--shadow-light);
                }

                .neo-dashboard-content {
                    display: grid;
                    gap: 2rem;
                }

                .neo-card {
                    background-color: var(--primary-bg);
                    border-radius: 15px;
                    overflow: hidden;
                    box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
                }

                .neo-card-header {
                    padding: 1.5rem;
                    border-bottom: 1px solid rgba(0,0,0,0.05);
                    text-align: center;
                }

                .neo-card-header h2 {
                    margin: 0;
                    color: var(--text-color);
                    font-size: 1.5rem;
                }

                .neo-card-body {
                    padding: 1.5rem;
                }

                .neo-info-item {
                    padding: 1rem;
                    margin-bottom: 1rem;
                    border-radius: 10px;
                    box-shadow: inset 4px 4px 8px var(--shadow-dark), inset -4px -4px 8px var(--shadow-light);
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                }

                .neo-label {
                    font-weight: 600;
                    color: var(--text-color);
                    margin-right: 1rem;
                }

                .neo-value {
                    color: var(--accent-color);
                    font-weight: 500;
                }

                .neo-loading-card, .neo-error-card {
                    background-color: var(--primary-bg);
                    border-radius: 15px;
                    padding: 2rem;
                    text-align: center;
                    box-shadow: 8px 8px 16px var(--shadow-dark), -8px -8px 16px var(--shadow-light);
                }

                .neo-loading-icon {
                    margin-bottom: 1rem;
                }

                .neo-spinner {
                    width: 40px;
                    height: 40px;
                    margin: 0 auto;
                    border: 4px solid rgba(0,0,0,0.1);
                    border-radius: 50%;
                    border-left-color: var(--accent-color);
                    animation: spin 1s linear infinite;
                }

                .neo-loading-text {
                    color: var(--text-color);
                    font-weight: 500;
                }

                .neo-error-icon {
                    width: 40px;
                    height: 40px;
                    margin: 0 auto 1rem;
                    line-height: 40px;
                    font-size: 24px;
                    font-weight: bold;
                    color: #e53e3e;
                    background-color: rgba(229, 62, 62, 0.1);
                    border-radius: 50%;
                    box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
                }

                .neo-error-text {
                    color: #e53e3e;
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                @media (max-width: 768px) {
                    .neo-info-item {
                        flex-direction: column;
                        align-items: flex-start;
                    }

                    .neo-label {
                        margin-bottom: 0.5rem;
                    }
                }

                .fade-in {
                    animation: fadeIn 0.5s ease-in;
                }

                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Éléments du DOM
                    const userCard = document.getElementById('userCard');
                    const loadingCard = document.getElementById('loadingCard');
                    const errorCard = document.getElementById('errorCard');
                    const username = document.getElementById('username');
                    const lastLogin = document.getElementById('lastLogin');
                    const userRole = document.getElementById('userRole');

                    // Fonction pour charger les données utilisateur (non asynchrone)
                    function loadUserData() {
                        const encryptedAction = "<?php echo Crypto::encrypt('DashboardController::apiGetUserData'); ?>";

                        // Création de l'objet XMLHttpRequest
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '/api/secure', false); // false pour appel synchrone
                        xhr.setRequestHeader('Content-Type', 'application/json');

                        // Préparation des données
                        const data = JSON.stringify({
                            action: encryptedAction,
                            params: {}
                        });

                        try {
                            // Envoi de la requête (méthode synchrone)
                            xhr.send(data);

                            if (xhr.status === 200) {
                                const response = JSON.parse(xhr.responseText);

                                if (response.success && response.data.success) {
                                    // Mise à jour des éléments du DOM
                                    username.textContent = response.data.userData.username;
                                    lastLogin.textContent = response.data.userData.lastLogin;
                                    userRole.textContent = response.data.userData.role;

                                    // Afficher la carte utilisateur
                                    loadingCard.style.display = 'none';
                                    userCard.style.display = 'block';
                                    userCard.classList.add('fade-in');
                                } else {
                                    showError();
                                }
                            } else {
                                showError();
                            }
                        } catch (e) {
                            showError();
                            console.error('Erreur lors du chargement des données:', e);
                        }
                    }

                    // Fonction pour afficher l'erreur
                    function showError() {
                        loadingCard.style.display = 'none';
                        errorCard.style.display = 'block';
                        errorCard.classList.add('fade-in');
                    }

                    // Charger les données au chargement de la page
                    loadUserData();
                });
            </script>