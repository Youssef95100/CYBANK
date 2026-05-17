<?php
include 'includes/presentation_dyn.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre Carte - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-menu">
        
        <h1>Découvrez notre Carte</h1>

        <?php if (isset($message_ajout) && $message_ajout != ''): ?>
            <div class="message-succes"><?php echo $message_ajout; ?></div>
        <?php endif; ?>

        <section class="barre-outils">
            <div class="filtres">
                <label for="filtre-categorie">Catégorie :</label>
                <select id="filtre-categorie" class="select-admin">
                    <option value="">Toutes les catégories</option>
                    <option value="Pizza">Pizzas</option>
                    <option value="Boisson">Boissons</option>
                    <option value="Dessert">Desserts</option>
                </select>
            </div>
            
            <div class="filtres">
                <label for="tri-plats">Trier par :</label>
                <select id="tri-plats" class="select-admin">
                    <option value="defaut">Par défaut</option>
                    <option value="prix_asc">Prix croissant</option>
                    <option value="prix_desc">Prix décroissant</option>
                    <option value="nom_asc">Nom (A-Z)</option>
                </select>
            </div>
        </section>

        <section class="section-accueil">
            <div id="grille-produits" class="grille-produits">
            </div>
        </section>

    </main>

    <script>
        const estClient = <?php echo (isset($_SESSION['role']) && $_SESSION['role'] === 'client') ? 'true' : 'false'; ?>;
    </script>
    <script src="presentation.js"></script>
</body>

</html>