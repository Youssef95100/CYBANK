<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $id_article = $_POST['id_article'];
    $nom_article = $_POST['nom_article'];
    $prix_article = (float) $_POST['prix_article'];
    $quantite = (int) $_POST['quantite'];

    $article_trouve = false;
    foreach ($_SESSION['panier'] as &$article_panier) {
        if ($article_panier['id'] === $id_article) {
            $article_panier['quantite'] += $quantite;
            $article_trouve = true;
            break;
        }
    }

    if (!$article_trouve) {
        $_SESSION['panier'][] = [
            'id' => $id_article,
            'nom' => $nom_article,
            'prix' => $prix_article,
            'quantite' => $quantite
        ];
    }
    
    $message_ajout = "✅ " . htmlspecialchars($quantite . "x " . $nom_article) . " ajouté(s) au panier !";
}
?>