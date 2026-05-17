<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['connecte']) || !in_array($_SESSION['role'], ['admin', 'restaurateur', 'livreur'])) {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_commande']) || !isset($data['statut'])) {
    echo json_encode(['success' => false, 'message' => 'Données incomplètes']);
    exit();
}

$id_commande = $data['id_commande'];
$nouveau_statut = $data['statut'];
$nouveau_livreur = isset($data['livreur']) ? $data['livreur'] : '';

if ($_SESSION['role'] === 'livreur' && !in_array($nouveau_statut, ['livree', 'abandonnee'])) {
    echo json_encode(['success' => false, 'message' => 'Action interdite pour votre rôle.']);
    exit();
}

$fichier_commandes = '../data/commandes.json';

if (file_exists($fichier_commandes)) {
    $contenu = file_get_contents($fichier_commandes);
    $donnees = json_decode($contenu, true);
    $modifie = false;

    foreach ($donnees['commandes'] as &$cmd) {
        if ($cmd['id'] === $id_commande) {
            $cmd['statut_commande'] = $nouveau_statut;
            if ($nouveau_livreur !== '') {
                $cmd['livreur_assigne'] = $nouveau_livreur;
                $cmd['livreur-assigne'] = $nouveau_livreur; 
            }
            $modifie = true;
            break;
        }
    }

    if ($modifie) {
        file_put_contents($fichier_commandes, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Commande introuvable']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Fichier de commandes introuvable']);
}
?>