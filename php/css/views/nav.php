<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="presentation.php">Présentation</a></li>

        <?php if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true): ?>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>

        <?php else: ?>
            <li><a href="profil.php">Profil</a></li>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li><a href="admin.php">Administrateur</a></li>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'restaurateur'): ?>
                <li><a href="commande.php">Commandes</a></li>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'livreur'): ?>
                <li><a href="livraison.php">Livraison</a></li>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'client'): ?>
                <li><a href="notation.php">Notes</a></li>
            <?php endif; ?>

            <?php if (isset($_SESSION['connecte']) && $_SESSION['role'] === 'client'): ?>
                <li><a href="panier.php">Mon Panier</a></li>
            <?php endif; ?>

            <li><a href="includes/logout.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>