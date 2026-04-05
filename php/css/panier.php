<?php 
require_once 'includes/panier_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-profil">
        <h1>Mon Panier</h1>

        <?php if (isset($message_succes)): ?>
            <div class="message-succes"><?php echo htmlspecialchars($message_succes); ?></div>
        <?php endif; ?>

        <div class="grille-profil">
            <section class="carte-profil" style="flex: 2;">
                <h2>Récapitulatif de la commande</h2>
                
                <table class="table-commandes">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($_SESSION['panier'])): ?>
                            <tr>
                                <td colspan="4" class="cellule-vide">Votre panier est vide.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($_SESSION['panier'] as $article): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($article['nom']); ?></strong></td>
                                    <td><?php echo number_format($article['prix'], 2, ',', ' '); ?> €</td>
                                    <td><?php echo htmlspecialchars($article['quantite']); ?></td>
                                    <td><strong><?php echo number_format($article['prix'] * $article['quantite'], 2, ',', ' '); ?> €</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (!empty($_SESSION['panier'])): ?>
                    <form action="panier.php" method="POST" class="mt-15">
                        <input type="hidden" name="action" value="vider">
                        <button type="submit" class="btn-action btn-abandon">Vider le panier</button>
                    </form>
                <?php endif; ?>
            </section>

            <section class="carte-profil" style="flex: 1;">
                <h2>Validation & Paiement</h2>
                
                <div class="total-panier">
                    Total : <span><?php echo number_format($total_panier, 2, ',', ' '); ?> €</span>
                </div>

                <?php if (!empty($_SESSION['panier'])): ?>
                    <form action="panier.php" method="POST" class="formulaire-paiement">
                        <input type="hidden" name="action" value="payer">
                        
                        <div class="groupe-champ">
                            <label for="mode_consommation">Mode de consommation :</label>
                            <select id="mode_consommation" name="mode_consommation" required>
                                <option value="livraison">Livraison à domicile</option>
                                <option value="sur_place">Sur place</option>
                                <option value="a_emporter">À emporter</option>
                            </select>
                        </div>

                        <div class="groupe-champ">
                            <label for="moment_preparation">Moment de préparation :</label>
                            <select id="moment_preparation" name="moment_preparation" required>
                                <option value="immediat">Immédiatement</option>
                                <option value="planifie">Planifier pour plus tard</option>
                            </select>
                        </div>

                        <div class="groupe-double">
                            <div class="groupe-champ">
                                <label for="date_prevue">Date prévue :</label>
                                <input type="date" id="date_prevue" name="date_prevue" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="groupe-champ">
                                <label for="heure_prevue">Heure prévue :</label>
                                <input type="time" id="heure_prevue" name="heure_prevue">
                            </div>
                        </div>

                        <div class="groupe-champ" id="bloc-adresse">
                            <label for="adresse">Adresse de livraison <small class="texte-normal">(Si livraison)</small> :</label>
                            <textarea id="adresse" name="adresse" rows="2" placeholder="Votre adresse..."><?php echo htmlspecialchars($adresse_client); ?></textarea>
                        </div>

                        <button type="submit" class="btn-valider mt-20">Valider et Payer</button>
                    </form>
                <?php else: ?>
                    <p class="cellule-vide">Votre panier doit contenir des articles pour valider la commande.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>