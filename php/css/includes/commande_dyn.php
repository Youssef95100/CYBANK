<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'restaurateur')) {
    header("Location: ../connexion.php");
    exit();
}

$commandes_a_preparer = [];
$commandes_en_livraison = [];

$fichier_commandes = 'data/commandes.json';

if (file_exists($fichier_commandes)) {
    $donnees = json_decode(file_get_contents($fichier_commandes), true);
    
    foreach ($donnees['commandes'] as $cmd) {
        $statut = strtolower($cmd['statut_commande']);
        
        if (in_array($statut, ['payé', 'paye', 'en_preparation', 'prete'])) {
            $commandes_a_preparer[] = $cmd;
        } 
        elseif ($statut === 'en_livraison') {
            $commandes_en_livraison[] = $cmd;
        }
    }
}
?>