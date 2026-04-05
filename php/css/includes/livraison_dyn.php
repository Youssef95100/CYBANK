<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'livreur')) {
    header("Location: ../index.php");
    exit();
}

$mes_livraisons = [];
$fichier_commandes = 'data/commandes.json';

if (file_exists($fichier_commandes)) {
    $donnees = json_decode(file_get_contents($fichier_commandes), true);
    
    foreach ($donnees['commandes'] as $cmd) {
        if ($cmd['statut_commande'] === 'en_livraison') {
            
            if ($_SESSION['role'] === 'admin' || (isset($cmd['livreur_assigne']) && $cmd['livreur_assigne'] === $_SESSION['id'])) {
                $mes_livraisons[] = $cmd;
            }
        }
    }
}
?>