<?php 
require_once 'includes/livraison_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Livraisons - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-admin">
        <h1>Livraisons en cours</h1>

        <div id="message-retour-livraison" class="erreur-invisible"></div>

        <?php if (empty($mes_livraisons)): ?>
            <section class="carte-profil pleine-largeur" id="bloc-livraison-vide">
                <p class="message-vide-livraison">
                    Aucune livraison en cours pour le moment.
                </p>
            </section>
        <?php else: ?>
            <div class="grille-profil" id="conteneur-grille-livraison">
                <?php foreach ($mes_livraisons as $cmd): ?>
                    <section class="carte-profil" id="carte-<?php echo htmlspecialchars($cmd['id']); ?>">
                        <div class="en-tete-livraison">
                            <h2>Commande <?php echo htmlspecialchars($cmd['id']); ?></h2>
                            <span class="badge-paiement <?php echo htmlspecialchars($cmd['statut_paiement']); ?>">
                                <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($cmd['statut_paiement']))); ?>
                            </span>
                        </div>

                        <ul class="liste-infos mt-15">
                            <li>
                                <strong>Adresse :</strong><br>
                                <span class="texte-adresse-grand">
                                    <?php echo htmlspecialchars($cmd['adresse_livraison'] ?? 'Adresse non renseignée'); ?>
                                </span>
                            </li>
                            <li>
                                <strong>Contenu :</strong><br>
                                <?php 
                                    $details = [];
                                    foreach ($cmd['articles'] as $article) {
                                        $details[] = $article['quantite'] . 'x ' . $article['nom'];
                                    }
                                    echo htmlspecialchars(implode(', ', $details));
                                ?>
                            </li>
                        </ul>

                        <div class="conteneur-action-maps">
                            <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($cmd['adresse_livraison']); ?>" target="_blank" class="btn-maps pleine-largeur" title="Ouvrir dans le GPS">Ouvrir dans Maps / Waze</a>
                        </div>

                        <div class="actions-livreur-flex">
                            <button class="btn-action btn-valider pleine-largeur btn-statut-livraison" data-id="<?php echo htmlspecialchars($cmd['id']); ?>" data-statut="livree">
                                Livrée
                            </button>
                            <button class="btn-action btn-abandon pleine-largeur btn-statut-livraison" data-id="<?php echo htmlspecialchars($cmd['id']); ?>" data-statut="abandonnee">
                                Abandonnée
                            </button>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script src="livraison.js"></script>
</body>
</html>