<?php 
require_once 'includes/commande_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-admin">
        <h1>Tableau de bord - Cuisines & Livraisons</h1>

        <section class="carte-profil pleine-largeur espace-bas">
            <h2 class="titre-attente">Commandes en attente (À préparer)</h2>
            
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date & Heure</th>
                        <th>Détails de la commande</th>
                        <th>Lieu de Consommation</th>
                        <th>Paiement</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($commandes_a_preparer)): ?>
                        <tr>
                            <td colspan="6" class="cellule-vide">Aucune commande en attente. Beau travail !</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($commandes_a_preparer as $cmd): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cmd['id']); ?></td>
                                <td><?php echo htmlspecialchars($cmd['date_heure']); ?></td>
                                <td>
                                    <?php 
                                        $details_articles = [];
                                        foreach ($cmd['articles'] as $article) {
                                            $details_articles[] = $article['quantite'] . 'x ' . $article['nom'];
                                        }
                                        echo htmlspecialchars(implode(', ', $details_articles));
                                    ?>
                                </td>
                                <td>
                                    <strong><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($cmd['mode_consommation']))); ?></strong>
                                    <?php if ($cmd['mode_consommation'] === 'livraison' && !empty($cmd['adresse_livraison'])): ?>
                                        <br><span class="texte-adresse"><?php echo htmlspecialchars($cmd['adresse_livraison']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge-paiement <?php echo htmlspecialchars($cmd['statut_paiement']); ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($cmd['statut_paiement']))); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail_commande.php?id=<?php echo urlencode($cmd['id']); ?>" class="btn-action btn-livraison bouton-lien">
                                        Gérer la commande
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section class="carte-profil pleine-largeur">
            <h2 class="titre-en-cours">Commandes en cours de livraison</h2>
            
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date & Heure</th>
                        <th>Lieu de Consommation</th>
                        <th>Paiement</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($commandes_en_livraison)): ?>
                        <tr>
                            <td colspan="5" class="cellule-vide">Aucune livraison en cours.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($commandes_en_livraison as $cmd): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cmd['id']); ?></td>
                                <td><?php echo htmlspecialchars($cmd['date_heure']); ?></td>
                                <td><?php echo htmlspecialchars($cmd['adresse_livraison'] ?? 'Non renseignée'); ?></td>
                                <td>
                                    <span class="badge-paiement <?php echo htmlspecialchars($cmd['statut_paiement']); ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($cmd['statut_paiement']))); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detail_commande.php?id=<?php echo urlencode($cmd['id']); ?>" class="btn-action btn-livraison bouton-lien">
                                        Gérer la commande
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

    </main>

</body>

</html>