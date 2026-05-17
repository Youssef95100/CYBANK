<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'client') {
    header("Location: connexion.php");
    exit();
}

$id_commande = $_GET['id'] ?? null;
$la_commande = null;

$fichier_commandes = 'data/commandes.json';
if (file_exists($fichier_commandes)) {
    $donnees_cmd = json_decode(file_get_contents($fichier_commandes), true);
    foreach ($donnees_cmd['commandes'] as $cmd) {
        if ($cmd['id'] === $id_commande && $cmd['client_id'] === $_SESSION['id']) {
            if (in_array(strtolower($cmd['statut_commande']), ['payé', 'paye', 'a_preparer', 'planifie'])) {
                $la_commande = $cmd;
            }
            break;
        }
    }
}

if (!$la_commande) {
    header("Location: profil.php");
    exit();
}

$plats_disponibles = [];
if (file_exists('data/plats.json')) {
    $donnees_plats = json_decode(file_get_contents('data/plats.json'), true);
    $plats_disponibles = $donnees_plats['plats'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier ma Commande - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-profil" id="conteneur-modification" data-articles="<?php echo htmlspecialchars(json_encode($la_commande['articles']), ENT_QUOTES, 'UTF-8'); ?>">
        <a href="profil.php" class="lien-retour">← Retour à mon profil</a>
        <h1>Modifier la commande <span id="cmd-id"><?php echo htmlspecialchars($la_commande['id']); ?></span></h1>

        <div class="grille-profil">
            <section class="carte-profil" style="flex: 2;">
                <h2>Articles de votre commande</h2>
                
                <table class="table-commandes" id="table-modification">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>Prix Unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="liste-articles-modif">
                        </tbody>
                </table>

                <div class="groupe-champ mt-20">
                    <label for="ajout-nouveau-plat">Ajouter un produit à cette commande :</label>
                    <select id="ajout-nouveau-plat" class="select-admin pleine-largeur">
                        <option value="">-- Choisir un produit à ajouter --</option>
                        <?php foreach ($plats_disponibles as $plat): ?>
                            <option value="<?php echo $plat['id']; ?>" data-nom="<?php echo htmlspecialchars($plat['nom']); ?>" data-prix="<?php echo $plat['prix']; ?>">
                                <?php echo htmlspecialchars($plat['nom'] . " (" . number_format($plat['prix'], 2, ',', ' ') . " €)"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </section>

            <section class="carte-profil" style="flex: 1;">
                <h2>Ajustement Financier</h2>
                
                <ul class="liste-infos">
                    <li>Ancien total : <span id="ancien-total">0.00</span> €</li>
                    <li>Nouveau total : <span id="nouveau-total">0.00</span> €</li>
                </ul>

                <div id="zone-finance" class="indicateur-finance finance-neutre">
                    Différence : <span id="difference-montant">0.00</span> €
                    <p id="explication-finance" style="font-size: 12px; margin-top: 5px; font-weight: normal;"></p>
                </div>

                <button id="btn-valider-modif" class="btn-valider mt-20">Enregistrer les modifications</button>
            </section>
        </div>
    </main>

    <script src="modifier_commande.js"></script>
</body>
</html>