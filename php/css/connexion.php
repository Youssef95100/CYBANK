<?php
require_once 'includes/auth.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - La Pizzardiz</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'views/nav.php'; ?>
    
   <main class="conteneur-formulaire">
        <h1>Connexion</h1>
        <p>Veuillez vous identifier pour accéder à votre compte.</p>

        <?php if ($message_erreur != ''): ?>
            <p class="message-erreur">
                <?php echo $message_erreur; ?>
            </p>
        <?php endif; ?>

        <form action="connexion.php" method="POST">
            <div class="groupe-champ">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="votre@email.com" required>
            </div>

            <div class="groupe-champ">
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn-valider">Se connecter</button>
        </form>

        <p class="lien-inscription">
            <a href="inscription.php">Pas encore de compte ? Inscrivez-vous ici.</a>
        </p>
    </main>


</body>

</html>