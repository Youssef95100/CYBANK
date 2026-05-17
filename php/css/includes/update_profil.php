<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['connecte']) || $_SESSION['connecte'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data)) {
    echo json_encode(['success' => false, 'message' => 'Aucune donnée à modifier']);
    exit();
}

$id_utilisateur = $_SESSION['id'];
$fichier_users = '../data/utilisateurs.json';

if (file_exists($fichier_users)) {
    $contenu = file_get_contents($fichier_users);
    $donnees_json = json_decode($contenu, true);
    $mis_a_jour = false;

    foreach ($donnees_json['utilisateurs'] as &$user) {
        if ($user['id'] === $id_utilisateur) {
            foreach ($data as $cle => $valeur) {
                if (isset($user['informations'][$cle]) || $cle === 'infos_complementaires') {
                    $user['informations'][$cle] = htmlspecialchars(strip_tags($valeur));
                    $mis_a_jour = true;
                }
            }
            break;
        }
    }

    if ($mis_a_jour) {
        file_put_contents($fichier_users, json_encode($donnees_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucune modification détectée']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Fichier de données introuvable']);
}
?>