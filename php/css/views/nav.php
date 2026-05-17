<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['connecte']) && $_SESSION['connecte'] === true) {
    $fichier_json = 'data/utilisateurs.json';
    if (file_exists($fichier_json)) {
        $donnees = json_decode(file_get_contents($fichier_json), true);
        foreach ($donnees['utilisateurs'] as $u) {
            if ($u['id'] === $_SESSION['id'] && isset($u['bloque']) && $u['bloque'] === true) {
                session_destroy();
                header("Location: connexion.php");
                exit();
            }
        }
    }
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
        
        <li><button id="theme-toggle" class="btn-theme">Thème</button></li>
    </ul>
</nav>

<script src="theme.js"></script>