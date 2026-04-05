<?php 
require_once 'includes/presentation_dyn.php'; 
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>

    <main class="conteneur-menu">
        <h1>Bienvenue chez La Pizzardiz !</h1>

        <?php if (isset($message_ajout)): ?>
            <div class="message-succes"><?php echo $message_ajout; ?></div>
        <?php endif; ?>

        <div class="zone-recherche">
            <form action="#" method="GET">
                <input type="search" placeholder="Rechercher une pizza, un ingrédient..." name="q">
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <section class="section-accueil">
            <h2>La Pizza du Moment</h2>
            <div class="grille-produits">
                <article class="carte-pizza"> 
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/The_Butcher_(All_Meat)_pizza_-_27282456634.jpg" alt="Pizza L'Extravagante" class="img-pizza">
                    <h3>L'Extravagante</h3>
                    <p class="ingredients">Sauce tomate, mozzarella, poulet fumé, champignons, oignons, poivrons, boeuf, olives noires.</p>
                    <div class="pied-carte">
                        <span class="prix">16.00 €</span>
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                            <form action="accueil.php" method="POST" class="form-ajout-panier">
                                <input type="hidden" name="action" value="ajouter">
                                <input type="hidden" name="id_article" value="P07">
                                <input type="hidden" name="nom_article" value="L'Extravagante">
                                <input type="hidden" name="prix_article" value="16.00">
                                <input type="number" name="quantite" value="1" min="1" max="10" class="input-quantite">
                                <button type="submit" class="btn-ajouter">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
        </section>

        <section class="section-accueil">
            <h2>Nos Pizzas les Plus Populaires</h2>
            <div class="grille-produits">
                
                <article class="carte-pizza">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c8/Pizza_Margherita_stu_spivack.jpg" alt="Pizza Margherita" class="img-pizza">
                    <h3>Margherita</h3>
                    <p class="ingredients">Sauce tomate, mozzarella, basilic frais.</p>
                    <div class="pied-carte">
                        <span class="prix">10.00 €</span>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                            <form action="accueil.php" method="POST" class="form-ajout-panier">
                                <input type="hidden" name="action" value="ajouter">
                                <input type="hidden" name="id_article" value="P01">
                                <input type="hidden" name="nom_article" value="Margherita">
                                <input type="hidden" name="prix_article" value="10.00">
                                <input type="number" name="quantite" value="1" min="1" max="10" class="input-quantite">
                                <button type="submit" class="btn-ajouter">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>

                <article class="carte-pizza">
                    <img src="https://commons.wikimedia.org/wiki/Special:FilePath/Four_Cheese_-_Pizza_500_2023-11-10.jpg" alt="Pizza 4 Fromages" class="img-pizza">
                    <h3>4 Fromages</h3>
                    <p class="ingredients">Sauce tomate, mozzarella, fromage de chèvre, emmental, bleu.</p>
                    <div class="pied-carte">
                        <span class="prix">14.00 €</span>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                            <form action="accueil.php" method="POST" class="form-ajout-panier">
                                <input type="hidden" name="action" value="ajouter">
                                <input type="hidden" name="id_article" value="P08">
                                <input type="hidden" name="nom_article" value="4 Fromages">
                                <input type="hidden" name="prix_article" value="14.00">
                                <input type="number" name="quantite" value="1" min="1" max="10" class="input-quantite">
                                <button type="submit" class="btn-ajouter">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>

                <article class="carte-pizza">
                    <img src="https://img.cuisineaz.com/800x450/2013/12/20/i92032-pizza-savoyarde.jpeg" alt="Pizza Savoyarde" class="img-pizza">
                    <h3>Savoyarde</h3>
                    <p class="ingredients">Crème fraîche, mozzarella, pommes de terre, lardons, reblochon.</p>
                    <div class="pied-carte">
                        <span class="prix">14.50 €</span>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'client'): ?>
                            <form action="accueil.php" method="POST" class="form-ajout-panier">
                                <input type="hidden" name="action" value="ajouter">
                                <input type="hidden" name="id_article" value="P06">
                                <input type="hidden" name="nom_article" value="Savoyarde">
                                <input type="hidden" name="prix_article" value="14.50">
                                <input type="number" name="quantite" value="1" min="1" max="10" class="input-quantite">
                                <button type="submit" class="btn-ajouter">Ajouter</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>

            </div>
        </section>

    </main>

</body>

</html>