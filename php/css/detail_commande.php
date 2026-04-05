<?php 
require_once 'includes/detail_commande_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail Commande - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-admin">
        <a href="commande.php" class="lien-retour">Retour aux commandes</a>
        
        <h1>Gestion de la commande <?php echo htmlspecialchars($la_commande['id']); ?></h1>

        <div class="grille-profil">
            <section class="carte-profil">
                <h2>Informations de la commande</h2>
                <ul class="liste-infos">
                    <li><strong>Date & Heure :</strong> <?php echo htmlspecialchars($la_commande['date_heure']); ?></li>
                    <li>
                        <strong>Mode :</strong> 
                        <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($la_commande['mode_consommation']))); ?>
                    </li>
                    <?php if (!empty($la_commande['adresse_livraison'])): ?>
                        <li><strong>Adresse :</strong> <?php echo htmlspecialchars($la_commande['adresse_livraison']); ?></li>
                    <?php endif; ?>
                    <li>
                        <strong>Paiement :</strong> 
                        <span class="badge-paiement <?php echo htmlspecialchars($la_commande['statut_paiement']); ?>">
                            <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($la_commande['statut_paiement']))); ?>
                        </span>
                    </li>
                </ul>

                <h3 class="sous-titre-detail">Contenu de la commande :</h3>
                <ul class="liste-articles-detail">
                    <?php foreach ($la_commande['articles'] as $article): ?>
                        <li>
                            <span class="quantite-badge"><?php echo htmlspecialchars($article['quantite']); ?>x</span> 
                            <?php echo htmlspecialchars($article['nom']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <section class="carte-profil">
                <h2>Modifier l'état</h2>
                
                <form action="#" method="POST" class="formulaire-detail">
                    <div class="groupe-champ">
                        <label for="statut">Statut de la commande :</label>
                        <select id="statut" name="statut" class="select-admin pleine-largeur">
                            <option value="a_preparer" <?php echo ($la_commande['statut_commande'] === 'a_preparer') ? 'selected' : ''; ?>>À préparer</option>
                            <option value="en_livraison" <?php echo ($la_commande['statut_commande'] === 'en_livraison') ? 'selected' : ''; ?>>En livraison</option>
                            <option value="livree" <?php echo ($la_commande['statut_commande'] === 'livree') ? 'selected' : ''; ?>>Livrée / Terminée</option>
                        </select>
                    </div>

                    <?php if ($la_commande['mode_consommation'] === 'livraison'): ?>
                    <div class="groupe-champ">
                        <label for="livreur">Attribuer un livreur :</label>
                        <select id="livreur" name="livreur" class="select-admin pleine-largeur">
                            <option value="">Aucun livreur assigné</option>
                            <?php foreach ($liste_livreurs as $livreur): ?>
                                <option value="<?php echo htmlspecialchars($livreur['id']); ?>">
                                    <?php echo htmlspecialchars($livreur['informations']['prenom'] . ' ' . $livreur['informations']['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="btn-action btn-valider">Mettre à jour la commande</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>