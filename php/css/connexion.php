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

        <div id="erreur-js" class="message-erreur erreur-invisible"></div>

        <?php if (isset($message_erreur) && $message_erreur != ''): ?>
            <p class="message-erreur">
                <?php echo $message_erreur; ?>
            </p>
        <?php endif; ?>

        <form action="connexion.php" method="POST" id="form-connexion">
            <div class="groupe-champ">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="votre@email.com" maxlength="50" required>
                <small class="texte-compteur droite"><span id="compteur-email">0</span>/50 caractères</small>
            </div>

            <div class="groupe-champ">
                <label for="mdp">Mot de passe :</label>
                <div class="bloc-mot-de-passe">
                    <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" maxlength="30" required>
                    <button type="button" class="toggle-mdp">Afficher</button>
                </div>
                <small class="texte-compteur droite"><span id="compteur-mdp">0</span>/30 caractères</small>
            </div>

            <button type="submit" class="btn-valider">Se connecter</button>
        </form>

        <p class="lien-inscription">
            <a href="inscription.php">Pas encore de compte ? Inscrivez-vous ici.</a>
        </p>
    </main>

<script src="validation.js"></script>
</body>

</html>