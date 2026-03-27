<?php
session_start();

$message_erreur = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_saisi = $_POST['email'];
    $mdp_saisi = $_POST['mdp'];

    if (file_exists('data/utilisateurs.json')) {
        $json_data = file_get_contents('data/utilisateurs.json');
        $donnees = json_decode($json_data, true);
        $utilisateurs = $donnees['utilisateurs'];

        $utilisateur_trouve = false;

        foreach ($utilisateurs as $user) {
            if ($user['login'] === $email_saisi && $user['mot_de_passe'] === $mdp_saisi) {
                $utilisateur_trouve = true;
                
                $_SESSION['connecte'] = true;
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['informations']['nom'];
                
                if ($user['role'] === 'admin') { header("Location: admin.php"); }
                elseif ($user['role'] === 'restaurateur') { header("Location: commande.php"); }
                elseif ($user['role'] === 'livreur') { header("Location: livraison.php"); }
                else { header("Location: profil.php"); }
                exit();
            }
        }

        if (!$utilisateur_trouve) {
            $message_erreur = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        $message_erreur = "Erreur serveur : le fichier des utilisateurs est introuvable.";
    }
}
?>