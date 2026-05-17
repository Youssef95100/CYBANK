<?php
header('Content-Type: application/json; charset=utf-8');

$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
$fichier_plats = '../data/plats.json';

if (!file_exists($fichier_plats)) {
    echo json_encode([]);
    exit;
}

$json_data = file_get_contents($fichier_plats);
$donnees = json_decode($json_data, true);

if (!isset($donnees['plats'])) {
    echo json_encode([]);
    exit;
}

$plats_filtres = [];

foreach ($donnees['plats'] as $plat) {
    if ($categorie === '' || strtolower($plat['categorie']) === strtolower($categorie)) {
        $plats_filtres[] = $plat;
    }
}

echo json_encode($plats_filtres);
?>