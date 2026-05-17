<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['connecte']) || $_SESSION['role'] !== 'client') {
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$id_commande = $data['id_commande'] ?? null;
$nouveaux_articles = $data['articles'] ?? [];

$fichier_commandes = '../data/commandes.json';
$fichier_options = '../data/options.json';

if (file_exists($fichier_commandes)) {
    $donnees_cmd = json_decode(file_get_contents($fichier_commandes), true);
    $index_commande = -1;

    foreach ($donnees_cmd['commandes'] as $index => $cmd) {
        if ($cmd['id'] === $id_commande && $cmd['client_id'] === $_SESSION['id']) {
            $index_commande = $index;
            break;
        }
    }

    if ($index_commande !== -1) {
        $commande_cible = &$donnees_cmd['commandes'][$index_commande];

        $ancien_total = 0;
        foreach ($commande_cible['articles'] as $art) {
            $ancien_total += (float)($art['prix'] ?? 0) * (int)$art['quantite'];
        }

        $nouveau_total = 0;
        foreach ($nouveaux_articles as $art) {
            $nouveau_total += (float)$art['prix'] * (int)$art['quantite'];
        }

        $difference = $nouveau_total - $ancien_total;

        if ($difference > 0) {
            $_SESSION['modif_attente'] = [
                'id_commande' => $id_commande,
                'articles' => $nouveaux_articles,
                'difference' => $difference
            ];

            $id_vendeur = "V-LaPizzardiz95";
            $url_ok = "http://localhost/ton_projet/confirmation_paiement_additionnel.php";
            $url_err = "http://localhost/ton_projet/modifier_commande.php?id=" . $id_commande;
            
            $query = http_build_query([
                'vendeur' => $id_vendeur,
                'montant' => $difference,
                'ref' => $id_commande . "-ADD",
                'url_ok' => $url_ok,
                'url_err' => $url_err
            ]);

            echo json_encode([
                'success' => true,
                'redirect_url' => "https://cybank.cytech.fr/paiement/?" . $query
            ]);
            exit();
        }

        if ($difference < 0) {
            $montant_avoir = abs($difference);
            $code_avoir = "AVOIR-" . strtoupper(substr(md5(uniqid()), 0, 6));

            if (file_exists($fichier_options)) {
                $options = json_decode(file_get_contents($fichier_options), true);
                $options['options']['coupons_reduction'][] = [
                    "code" => $code_avoir,
                    "type_remise" => "montant",
                    "valeur" => $montant_avoir,
                    "description" => "Avoir suite à modification de la commande " . $id_commande
                ];
                file_put_contents($fichier_options, json_encode($options, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

            $commande_cible['articles'] = $nouveaux_articles;
            file_put_contents($fichier_commandes, json_encode($donnees_cmd, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            echo json_encode([
                'success' => true,
                'message' => "Commande modifiée ! Un ticket de réduction de " . number_format($montant_avoir, 2) . " € a été généré sous le code : " . $code_avoir
            ]);
            exit();
        }

        $commande_cible['articles'] = $nouveaux_articles;
        file_put_contents($fichier_commandes, json_encode($donnees_cmd, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(['success' => true, 'message' => "Commande mise à jour sans changement de prix."]);
        exit();
    }
}

echo json_encode(['success' => false, 'message' => 'Commande introuvable.']);
?>