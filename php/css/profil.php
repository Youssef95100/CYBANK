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
                        <span><strong>Nom :</strong> Jannik Sinner</span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Email :</strong> jannik.sinner@email.com</span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Téléphone :</strong> 06 83 62 25 62</span>
                        <button class="btn-modifier" title="Modifier cette information">✏️</button>
                    </li>
                    <li>
                        <span><strong>Adresse :</strong> Avenue du Parc, 95000 Cergy-Pontoise</span>
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
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/02/2025</td>
                        <td>CMD-00123</td>
                        <td>32.50 €</td>
                        <td>Livrée</td>
                        <td><a href="notation.php" class="lien-noter">Noter</a></td> 
                    </tr>
                    <tr>
                        <td>02/01/2025</td>
                        <td>CMD-00084</td>
                        <td>18.00 €</td>
                        <td>Livrée</td>
                        <td><a href="notation.php" class="lien-noter">Noter</a></td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

</body>

</html>