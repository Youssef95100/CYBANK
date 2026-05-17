<?php
include 'includes/admin_dyn.php';

$fichier_users = 'data/utilisateurs.json';
$liste_utilisateurs = [];
if (file_exists($fichier_users)) {
    $donnees = json_decode(file_get_contents($fichier_users), true);
    $liste_utilisateurs = $donnees['utilisateurs'];
}
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liste_utilisateurs as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['informations']['prenom'] . ' ' . $user['informations']['nom']); ?></td>
                            <td><?php echo htmlspecialchars($user['login']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($user['role'])); ?></td>
                            <td>
                                <div class="actions-admin">
                                    <a href="profil.php?id=<?php echo $user['id']; ?>" class="lien-noter bouton-lien">Profil</a>
                                    
                                    <?php if ($user['id'] !== $_SESSION['id']): ?>
                                        <?php 
                                        $estBloque = isset($user['bloque']) && $user['bloque'] === true; 
                                        $texteBouton = $estBloque ? 'Débloquer' : 'Bloquer';
                                        $classeBouton = $estBloque ? 'btn-debloquer' : 'btn-bloquer';
                                        ?>
                                        <button class="btn-action-blocage <?php echo $classeBouton; ?>" data-id="<?php echo $user['id']; ?>">
                                            <?php echo $texteBouton; ?>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="admin.js"></script>
</body>
</html>