<?php
include 'includes/admin_dyn.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-admin">
        <h1>Gestion des Utilisateurs</h1>

        <section class="barre-outils">
            <div class="recherche-rapide">
                <input type="search" placeholder="Rechercher (nom, email)...">
                <button type="button">Rechercher</button>
            </div>
            
            <div class="filtres">
                <select name="filtre-utilisateurs">
                    <option value="tous">Tous les utilisateurs</option>
                    <option value="avec-commandes">Avec commandes passées</option>
                    <option value="sans-commandes">Sans commandes</option>
                    <option value="staff">Équipe (Livreurs, Restaurateurs)</option>
                </select>
            </div>
        </section>

        <section class="carte-profil pleine-largeur">
            <h2>Liste des inscrits</h2>
            
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Action & Gestion</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($liste_utilisateurs)): ?>
                        <tr>
                            <td colspan="5" class="cellule-vide">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($liste_utilisateurs as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td>
                                    <?php 
                                        $prenom = $user['informations']['prenom'] ?? '';
                                        $nom = $user['informations']['nom'] ?? '';
                                        echo htmlspecialchars(trim($prenom . ' ' . $nom)); 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($user['login']); ?></td>
                                <td>
                                    <span class="badge-role <?php echo htmlspecialchars($user['role']); ?>">
 Í                                       <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="groupe-actions-admin">
                                        <a href="profil.php?id=<?php echo $user['id']; ?>" class="lien-noter">Profil</a>
                                        
                                        <button class="btn-bloquer" title="Bloquer le compte">Bloquer</button>
                                        
                                        <select class="select-admin" title="Modifier le statut">
                                            <option value="standard">Statut : Standard</option>
                                            <option value="premium">Statut : Premium</option>
                                            <option value="vip">Statut : VIP</option>
                                        </select>

                                        <select class="select-admin" title="Niveau de remise">
                                            <option value="0">Remise : 0%</option>
                                            <option value="5">Remise : 5%</option>
                                            <option value="10">Remise : 10%</option>
                                            <option value="15">Remise : 15%</option>
                                        </select>
                                    </div>
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