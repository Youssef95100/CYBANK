<?php
session_start();

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$fichier_users = 'data/utilisateurs.json';
$liste_utilisateurs = [];

if (file_exists($fichier_users)) {
    $donnees = json_decode(file_get_contents($fichier_users), true);
    $liste_utilisateurs = $donnees['utilisateurs'];
}
?>