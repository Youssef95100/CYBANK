<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'client') {
    header("Location: ../connexion.php");
    exit();
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$fichier_commandes = 'data/commandes.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        
        if ($_POST['action'] === 'vider') {
            $_SESSION['panier'] = [];
        }
        
        if ($_POST['action'] === 'payer' && !empty($_SESSION['panier'])) {
            
            $donnees = json_decode(file_get_contents($fichier_commandes), true);
            $nb_commandes = count($donnees['commandes']);
            $nouvel_id = "CMD-" . str_pad($nb_commandes + 1, 3, "0", STR_PAD_LEFT);

            $moment = $_POST['moment_preparation'];
            
            if ($moment === 'planifie' && !empty($_POST['date_prevue']) && !empty($_POST['heure_prevue'])) {
                $date_formatee = date("d/m/Y", strtotime($_POST['date_prevue']));
                $echeance = $date_formatee . " " . $_POST['heure_prevue'];
                $statut_depart = "planifie";
            } else {
                $echeance = date('d/m/2026 H:i');
                $statut_depart = "a_preparer"; 
            }

            $nouvelle_commande = [
                "id" => $nouvel_id,
                "client_id" => $_SESSION['id'],
                "articles" => $_SESSION['panier'],
                "mode_consommation" => $_POST['mode_consommation'],
                "moment_preparation" => $moment,
                "date_heure_prevue" => $echeance,
                "adresse_livraison" => ($_POST['mode_consommation'] === 'livraison') ? $_POST['adresse'] : "",
                "statut_paiement" => "payé",
                "statut_commande" => $statut_depart,
                "date_heure_achat" => date('d/m/2026 H:i'),
                "livreur_assigne" => ""
            ];

            $donnees['commandes'][] = $nouvelle_commande;
            file_put_contents($fichier_commandes, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $_SESSION['panier'] = [];
            $message_succes = "Commande " . $nouvel_id . " enregistrée pour le " . $echeance . " !";
        }
    }
}

$adresse_client = '';
$fichier_users = 'data/utilisateurs.json';
if (file_exists($fichier_users)) {
    $donnees_users = json_decode(file_get_contents($fichier_users), true);
    foreach ($donnees_users['utilisateurs'] as $user) {
        if ($user['id'] === $_SESSION['id']) {
            $adresse_client = $user['informations']['adresse'] ?? '';
            break;
        }
    }
}

$total_panier = 0;
foreach ($_SESSION['panier'] as $article) {
    $total_panier += $article['prix'] * $article['quantite'];
}
?>