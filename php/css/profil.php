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

        <div class="grille-profil">

            <section class="carte-profil">
                <h2>Mes Informations</h2>
                <ul class="liste-infos">
                    <li>
                        <span><strong>Nom :</strong>
                            <?php echo htmlspecialchars($infos_user['informations']['prenom'] . ' ' . $infos_user['informations']['nom'] ?? ''); ?>
                        </span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Email :</strong>
                            <?php echo htmlspecialchars($infos_user['login'] ?? ''); ?>
                        </span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Téléphone :</strong>
                            <?php echo htmlspecialchars($infos_user['informations']['telephone'] ?? ''); ?>
                        </span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Adresse :</strong>
                            <?php echo htmlspecialchars($infos_user['informations']['adresse'] ?? ''); ?>
                        </span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Informations Complémentaires :</strong>
                            <?php echo htmlspecialchars($infos_user['informations']['infos_complementaires'] ?? 'Aucune informations supplémentaire'); ?>
                        </span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                </ul>
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

</body>

</html>