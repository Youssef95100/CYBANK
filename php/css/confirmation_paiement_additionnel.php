<?php
session_start();

if (!isset($_SESSION['modif_attente'])) {
    header("Location: profil.php");
    exit();
}

$id_commande = $_SESSION['modif_attente']['id_commande'];
$articles = $_SESSION['modif_attente']['articles'];
$difference = $_SESSION['modif_attente']['difference'];

$fichier_commandes = 'data/commandes.json';
if (file_exists($fichier_commandes)) {
    $donnees = json_decode(file_get_contents($fichier_commandes), true);
    foreach ($donnees['commandes'] as &$cmd) {
        if ($cmd['id'] === $id_commande) {
            $cmd['articles'] = $articles;
            break;
        }
    }
    file_put_contents($fichier_commandes, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$fichier_paiements = 'data/paiements.json';
if (file_exists($fichier_paiements)) {
    $donnees_pay = json_decode(file_get_contents($fichier_paiements), true);
    $donnees_pay['paiements'][] = [
        "id_transaction" => "TRANS-" . rand(100000, 999999),
        "commande_id" => $id_commande,
        "client_id" => $_SESSION['id'],
        "date_transaction" => date('d/m/2026 H:i'),
        "montant" => $difference,
        "coordonnees_bancaires" => [
            "nom_porteur" => $_SESSION['nom'] ?? 'Client',
            "type_carte" => "Visa",
            "derniers_chiffres" => "4242",
            "expiration" => "08/28"
        ],
        "statut" => "succes",
        "methode" => "CYBank API (Paiement Additionnel)"
    ];
    file_put_contents($fichier_paiements, json_encode($donnees_pay, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

unset($_SESSION['modif_attente']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Complément Réussi - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'views/nav.php'; ?>
    <main class="conteneur-profil" style="text-align: center;">
        <div class="carte-profil">
            <h1>💳 Paiement Additionnel Réussi !</h1>
            <p>Le complément de <strong><?php echo number_format($difference, 2, ',', ' '); ?> €</strong> a bien été validé.</p>
            <p>Les modifications de votre commande <strong><?php echo htmlspecialchars($id_commande); ?></strong> ont été transmises aux cuisines.</p>
            <a href="profil.php" class="btn-valider mt-20" style="display:inline-block; text-decoration:none; width:auto;">Retour au tableau de bord</a>
        </div>
    </main>
</body>
</html>