<?php 
require_once 'includes/profil_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-profil">
        <h1>Mon Tableau de Bord</h1>

        <div id="message-retour" class="erreur-invisible"></div>

        <div class="grille-profil">

            <section class="carte-profil">
                <h2>Mes Informations</h2>
                <ul class="liste-infos" id="liste-informations">
                    <li>
                        <span><strong>Prénom :</strong> <span class="info-valeur" data-champ="prenom"><?php echo htmlspecialchars($infos_user['informations']['prenom'] ?? ''); ?></span></span>
                        <button type="button" class="btn-modifier">Modifier</button>
                    </li>
                    <li>
                        <span><strong>Nom :</strong> <span class="info-valeur" data-champ="nom"><?php echo htmlspecialchars($infos_user['informations']['nom'] ?? ''); ?></span></span>
                        <button type="button" class="btn-modifier">Modifier</button>
                    </li>
                    <li>
                        <span><strong>Téléphone :</strong> <span class="info-valeur" data-champ="telephone"><?php echo htmlspecialchars($infos_user['informations']['telephone'] ?? ''); ?></span></span>
                        <button type="button" class="btn-modifier">Modifier</button>
                    </li>
                    <li>
                        <span><strong>Adresse :</strong> <span class="info-valeur" data-champ="adresse"><?php echo htmlspecialchars($infos_user['informations']['adresse'] ?? ''); ?></span></span>
                        <button type="button" class="btn-modifier">Modifier</button>
                    </li>
                    <li>
                        <span><strong>Infos Complémentaires :</strong> <span class="info-valeur" data-champ="infos_complementaires"><?php echo htmlspecialchars($infos_user['informations']['infos_complementaires'] ?? ''); ?></span></span>
                        <button type="button" class="btn-modifier">Modifier</button>
                    </li>
                </ul>
                <button id="btn-sauvegarder" class="btn-valider erreur-invisible mt-15">Enregistrer les modifications</button>
            </section>

            <section class="carte-profil">
                <h2>Mon Compte Fidélité</h2>
                <div class="fidelite-info">
                    <div class="points">150 <span>Points</span></div>
                    <p>Statut actuel : <strong>Gros mangeur</strong></p>
                    <p>Plus que 50 points pour une pizza gratuite !</p>
                    <progress value="150" max="200"></progress>
                </div>
            </section>
        </div>

        <section class="carte-profil pleine-largeur">
            <h2>Mes Anciennes Commandes</h2>

            <table class="table-commandes">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>N° Commande</th>
                        <th>Détails</th> 
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mes_commandes)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Aucune commande passée pour le moment.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($mes_commandes as $cmd): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($cmd['date_heure']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($cmd['id']); ?>
                        </td>
                        <td>
                            <?php 
                                $details = [];
                                if (isset($cmd['articles'])) {
                                    foreach ($cmd['articles'] as $article) {
                                        $details[] = $article['quantite'] . 'x ' . $article['nom'];
                                    }
                                }
                                echo htmlspecialchars(implode(', ', $details));
                            ?>
                        </td>
                        <td>
                            <strong><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($cmd['statut_commande']))); ?></strong>
                        </td>
                        <td>
                            <?php if ($cmd['statut_commande'] === 'livree'): ?>
                                <a href="notation.php?id=<?php echo urlencode($cmd['id']); ?>" class="lien-noter">Noter</a>
                            <?php else: ?>
                                <span class="texte-adresse">Bientôt disponible...</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

    </main>

    <script src="profil.js"></script>
</body>

</html>