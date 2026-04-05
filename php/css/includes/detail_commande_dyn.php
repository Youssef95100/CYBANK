<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'restaurateur')) {
    header("Location: ../index.php");
    exit();
}

$id_commande = $_GET['id'] ?? null;
$la_commande = null;
$liste_livreurs = [];

if ($id_commande) {
    $fichier_commandes = 'data/commandes.json';
    if (file_exists($fichier_commandes)) {
        $donnees_cmd = json_decode(file_get_contents($fichier_commandes), true);
        foreach ($donnees_cmd['commandes'] as $cmd) {
            if ($cmd['id'] === $id_commande) {
                $la_commande = $cmd;
                break;
            }
        }
    }

    $fichier_users = 'data/utilisateurs.json';
    if (file_exists($fichier_users)) {
        $donnees_users = json_decode(file_get_contents($fichier_users), true);
        foreach ($donnees_users['utilisateurs'] as $user) {
            if ($user['role'] === 'livreur') {
                $liste_livreurs[] = $user;
            }
        }
    }
}

if (!$la_commande) {
    header("Location: ../commande.php");
    exit();
}
?>