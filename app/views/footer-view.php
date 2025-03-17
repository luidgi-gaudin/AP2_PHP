</main>
<footer class="neo-footer">
    <div class="neo-container">
        <div class="footer-content">
            <div class="footer-info">
                <p>&copy; <?= date('Y') ?> GSB - Tous droits réservés</p>
            </div>
        </div>
    </div>
</footer>

<style>
    .neo-footer {
        background-color: var(--primary-bg);
        padding: 1.5rem 1rem;
        margin-top: 2rem;
        box-shadow: 0 -8px 16px var(--shadow-dark);
        border-radius: 15px 15px 0 0;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .footer-info p {
        color: var(--text-color);
        margin: 0;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        box-shadow: inset 2px 2px 5px var(--shadow-dark), inset -2px -2px 5px var(--shadow-light);
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
    }
</style>

</body>
</html>