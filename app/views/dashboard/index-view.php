<div class="neo-dashboard-container">
    <div class="neo-dashboard-header">
        <h1>Tableau de bord</h1>
    </div>

    <div class="neo-dashboard-content">
        <!-- Carte utilisateur (cachée par défaut) -->
        <div class="neo-card" id="userCard">
            <div class="neo-card-header">
                <h2>Bienvenue, <?=$_SESSION['username'] ?></h2>
            </div>
            <div class="neo-card-body">
                <div class="neo-info-item">
                </div>
            </div>
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