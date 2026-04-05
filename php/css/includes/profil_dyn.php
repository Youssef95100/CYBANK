<?php
session_start();

if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
    header("Location: connexion.php");
    exit();
}

$id_cible = $_SESSION['id'];
if ($_SESSION['role'] === 'admin' && isset($_GET['id'])) {
    $id_cible = $_GET['id'];
}

$id_utilisateur = $_SESSION['id'];
$infos_user = null;
$mes_commandes = [] ;

$fichier_users = 'data/utilisateurs.json';
if (file_exists($fichier_users)) {
    $donnees = json_decode(file_get_contents($fichier_users), true);
    foreach ($donnees['utilisateurs'] as $user) {
        if ($user['id'] === $id_cible) {
            $infos_user = $user;
            break;
        }
    }
}

$fichier_commandes = 'data/commandes.json';
if (file_exists($fichier_commandes)) {
    $donnees_cmd = json_decode(file_get_contents($fichier_commandes), true);
    if (isset($donnees_cmd['commandes'])) {
        foreach ($donnees_cmd['commandes'] as $cmd) {
            if (isset($cmd['client_id']) && $cmd['client_id'] === $id_cible) {
                $mes_commandes[] = $cmd;
            }
        }
    }
}
?>