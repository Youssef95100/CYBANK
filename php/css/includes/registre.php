<?php
session_start();

$message_erreur = '';
$message_succes = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone']; 
    $adresse = $_POST['adresse'];
    $infos = $_POST['infos'];
    $mdp = $_POST['mdp'];

    $fichier_json = 'data/utilisateurs.json';

    if (file_exists($fichier_json)) {
        $json_data = file_get_contents($fichier_json);
        $donnees = json_decode($json_data, true);
        
        $email_existe = false;

        foreach ($donnees['utilisateurs'] as $user) {
            if ($user['login'] === $email) {
                $email_existe = true;
                break;
            }
        }

        if ($email_existe) {
            $message_erreur = "Cette adresse e-mail est déjà utilisée.";
        } else {
            $dernier_id = 0;
            foreach ($donnees['utilisateurs'] as $user) {
                $num = intval(substr($user['id'], 1));
                if ($num > $dernier_id) {
                    $dernier_id = $num;
                }
            }
            $nouvel_id = 'U' . str_pad($dernier_id + 1, 3, '0', STR_PAD_LEFT); //ajoute des 0 pour completer

            $nouvel_utilisateur = [
                "id" => $nouvel_id,
                "login" => $email,
                "mot_de_passe" => $mdp,
                "role" => "client",
                "informations" => [
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "adresse" => $adresse . ($infos ? " (Infos : " . $infos . ")" : "")
                ],
                "dates" => [
                    "inscription" => date('d/m/Y'),
                    "derniere_connexion" => ""
                ]
            ];

            $donnees['utilisateurs'][] = $nouvel_utilisateur;

            if (file_put_contents($fichier_json, json_encode($donnees, JSON_PRETTY_PRINT))) {
                $message_succes = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            } else {
                $message_erreur = "Erreur lors de l'enregistrement.";
            }
        }
    } else {
        $message_erreur = "Erreur serveur.";
    }
}
?>