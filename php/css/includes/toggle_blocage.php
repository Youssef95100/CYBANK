<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Accès refusé']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

$id_cible = $data['id'];
$action = $data['action'];

$fichier_users = '../data/utilisateurs.json';

if (file_exists($fichier_users)) {
    $contenu = file_get_contents($fichier_users);
    $donnees = json_decode($contenu, true);
    $modifie = false;

    foreach ($donnees['utilisateurs'] as &$user) {
        if ($user['id'] === $id_cible) {
            if ($action === 'bloquer') {
                $user['bloque'] = true;
            } else {
                $user['bloque'] = false;
            }
            $modifie = true;
            break;
        }
    }

    if ($modifie) {
        file_put_contents($fichier_users, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Utilisateur introuvable']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Fichier introuvable']);
}
?>