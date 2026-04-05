<?php
session_start();

if (!isset($_SESSION['connecte']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'restaurateur')) {
    header("Location: index.php");
    exit();
}

$fichier_commandes = 'data/commandes.json';
$commandes_a_preparer = [];
$commandes_en_livraison = [];

if (file_exists($fichier_commandes)) {
    $donnees = json_decode(file_get_contents($fichier_commandes), true);
    
    foreach ($donnees['commandes'] as $cmd) {
        if ($cmd['statut_commande'] === 'a_preparer') {
            $commandes_a_preparer[] = $cmd;
        } elseif ($cmd['statut_commande'] === 'en_livraison') {
            $commandes_en_livraison[] = $cmd;
        }
    }
}
?>