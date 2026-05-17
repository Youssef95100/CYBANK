<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

$id_commande = $_GET['id'] ?? null;
$fichier_commandes = 'data/commandes.json';
$commande_eligible = false;
$message_erreur = '';
$message_succes = '';

if (!$id_commande) {
    header("Location: profil.php");
    exit();
}

if (file_exists($fichier_commandes)) {
    $donnees = json_decode(file_get_contents($fichier_commandes), true);
    foreach ($donnees['commandes'] as $cmd) {
        if ($cmd['id'] === $id_commande && $cmd['client_id'] === $_SESSION['id']) {
            if ($cmd['statut_commande'] === 'livree') {
                if (isset($cmd['evaluation'])) {
                    $message_erreur = "Vous avez déjà transmis une évaluation pour cette commande.";
                } else {
                    $commande_eligible = true;
                }
            } else {
                $message_erreur = "Vous ne pouvez évaluer qu'une commande ayant le statut livré.";
            }
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $commande_eligible) {
    $note_livraison = intval($_POST['note-livraison'] ?? 0);
    $note_qualite = intval($_POST['note-qualite'] ?? 0);
    $commentaire = htmlspecialchars(strip_tags(trim($_POST['commentaire'] ?? '')));

    if ($note_livraison >= 1 && $note_livraison <= 5 && $note_qualite >= 1 && $note_qualite <= 5) {
        $donnees = json_decode(file_get_contents($fichier_commandes), true);
        
        foreach ($donnees['commandes'] as &$cmd) {
            if ($cmd['id'] === $id_commande && $cmd['client_id'] === $_SESSION['id']) {
                $cmd['evaluation'] = [
                    "note_livraison" => $note_livraison,
                    "note_qualite" => $note_qualite,
                    "commentaire" => $commentaire,
                    "date_notation" => date('d/m/2026 H:i')
                ];
                break;
            }
        }
        
        if (file_put_contents($fichier_commandes, json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            $message_succes = "Merci ! Votre avis a été enregistré avec succès.";
            $commande_eligible = false; 
        } else {
            $message_erreur = "Une erreur technique est survenue lors de l'enregistrement.";
        }
    } else {
        $message_erreur = "Veuillez attribuer des notes valides comprises entre 1 et 5.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-formulaire">
        <h1>Évaluer votre commande</h1>
        <p>Votre avis compte ! Aidez-nous à améliorer notre savoir-faire.</p>

        <?php if (!empty($message_erreur)): ?>
            <div class="message-erreur"><?php echo $message_erreur; ?></div>
        <?php endif; ?>

        <?php if (!empty($message_succes)): ?>
            <div class="message-succes">
                <?php echo $message_succes; ?><br><br>
                <a href="profil.php" class="lien-connexion-succes">Retourner à mon tableau de bord</a>
            </div>
        <?php endif; ?>

        <?php if ($commande_eligible): ?>
            <form action="notation.php?id=<?php echo urlencode($id_commande); ?>" method="POST">

                <div class="groupe-champ">
                    <label for="note-livraison">Note de la livraison (sur 5) :</label>
                    <select id="note-livraison" name="note-livraison" required>
                        <option value="">Sélectionnez une note</option>
                        <option value="5">5 - Excellente</option>
                        <option value="4">4 - Bonne</option>
                        <option value="3">3 - Moyenne</option>
                        <option value="2">2 - Mauvaise</option>
                        <option value="1">1 - Très mauvaise</option>
                    </select>
                </div>

                <div class="groupe-champ">
                    <label for="note-qualite">Note de la qualité des plats (sur 5) :</label>
                    <select id="note-qualite" name="note-qualite" required>
                        <option value="">Sélectionnez une note</option>
                        <option value="5">5 - Délicieux</option>
                        <option value="4">4 - Très bon</option>
                        <option value="3">3 - Correct</option>
                        <option value="2">2 - Décevant</option>
                        <option value="1">1 - Immangeable</option>
                    </select>
                </div>

                <div class="groupe-champ">
                    <label for="commentaire">Un commentaire ? (Optionnel) :</label>
                    <textarea id="commentaire" name="commentaire" rows="4" placeholder="Dites-nous ce que vous avez pensé de votre repas..."></textarea>
                </div>

                <button type="submit" class="btn-valider">Envoyer mon avis</button>
            </form>
        <?php endif; ?>
    </main>

</body>

</html>