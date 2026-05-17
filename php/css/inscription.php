<?php 
require_once 'includes/registre.php';
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

    <div id="erreur-js" class="message-erreur erreur-invisible"></div>

    <?php if (isset($message_erreur) && $message_erreur != ''): ?>
        <p class="message-erreur">
            <?php echo $message_erreur; ?>
        </p>
    <?php endif; ?>

    <?php if (isset($message_succes) && $message_succes != ''): ?>
        <p class="message-succes">
            <?php echo $message_succes; ?> <br>
            <a href="connexion.php" class="lien-connexion-succes">Aller à la page de connexion</a>
        </p>
    <?php endif; ?>

    <form action="inscription.php" method="POST" id="form-inscription">
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
            <input type="email" id="email" name="email" maxlength="50" required>
            <small class="texte-compteur droite"><span id="compteur-email">0</span>/50 caractères</small>
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
            <textarea id="infos" name="infos" rows="4" maxlength="200" placeholder="Code d'entrée, interphone, étage..."></textarea>
            <small class="texte-compteur"><span id="compteur-infos">0</span>/200 caractères</small>
        </div>

        <div class="groupe-champ">
            <label for="mdp">Mot de passe :</label>
            <div class="bloc-mot-de-passe">
                <input type="password" id="mdp" name="mdp" maxlength="30" required>
                <button type="button" class="toggle-mdp">Afficher</button>
            </div>
            <small class="texte-compteur droite"><span id="compteur-mdp">0</span>/30 caractères</small>
        </div>

        <button type="submit" class="btn-valider">M'inscrire</button>
    </form>
</main>

<script src="validation.js"></script>
</body>

</html>