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

        <?php if (empty($mes_livraisons)): ?>
            <section class="carte-profil pleine-largeur">
                <p class="message-vide-livraison">
                    Aucune livraison en cours pour le moment.
                </p>
            </section>
        <?php else: ?>
            <div class="grille-profil">
                <?php foreach ($mes_livraisons as $cmd): ?>
                    <section class="carte-profil">
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
                            <a href="#" class="btn-maps pleine-largeur" title="Ouvrir dans le GPS">Ouvrir dans Maps / Waze</a>
                        </div>

                        <div class="actions-livreur-flex">
                            <form action="#" method="POST" class="form-action-livraison">
                                <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($cmd['id']); ?>">
                                <input type="hidden" name="nouveau_statut" value="livree">
                                <button type="submit" class="btn-action btn-valider pleine-largeur">Livrée</button>
                            </form>

                            <form action="#" method="POST" class="form-action-livraison">
                                <input type="hidden" name="id_commande" value="<?php echo htmlspecialchars($cmd['id']); ?>">
                                <input type="hidden" name="nouveau_statut" value="abandonnee">
                                <button type="submit" class="btn-action btn-abandon pleine-largeur">Abandonnée</button>
                            </form>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

</body>

</html>