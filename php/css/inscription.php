<?php 
require_once 'includes/registre.php'
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>


<main class="conteneur-formulaire">
    <h1>Créer un compte</h1>
    <p>Remplissez ce formulaire pour vous inscrire</p>

   <?php if ($message_erreur != ''): ?>
            <p class="message-erreur">
                <?php echo $message_erreur; ?>
            </p>
        <?php endif; ?>

        <?php if ($message_succes != ''): ?>
            <p class="message-succes">
                <?php echo $message_succes; ?> <br>
                <a href="connexion.php" class="lien-connexion-succes">Aller à la page de connexion</a>
            </p>
        <?php endif; ?>

    <form action="inscription.php" method="POST">
        <div class="groupe-champ">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>

        <div class="groupe-champ">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>

        <div class="groupe-champ">
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="groupe-champ">
            <label for="telephone">Numéro de téléphone :</label>
            <input type="tel" id="telephone" name="telephone" placeholder="Ex: 06 83 62 25 62" required>
        </div>

        <div class="groupe-champ">
            <label for="adresse">Adresse complète :</label>
            <input type="text" id="adresse" name="adresse" placeholder="N°, rue, code postal, ville" required>
        </div>

        <div class="groupe-champ">
            <label for="infos">Informations complémentaires :</label>
            <textarea id="infos" name="infos" rows="4" placeholder="Code d'entrée, interphone, étage..."></textarea>
        </div>

        <div class="groupe-champ">
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required>
        </div>

        <button type="submit" class="btn-valider">M'inscrire</button>
    </form>
</main>

</body>

</html>