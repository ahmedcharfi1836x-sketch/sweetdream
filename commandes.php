<?php

require_once __DIR__ . '/config/connection.php';

function getAdmin($pseudo, $motdepasse) {
    global $pdo;
    $sql = "SELECT * FROM admin WHERE pseudo = ? AND motdepasse = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$pseudo, $motdepasse]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 1. Add a new product
function ajouterProduit($nom, $image, $prix, $description) {
    global $pdo;
    $sql = "INSERT INTO produits (nom, image, prix, description) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom, $image, $prix, $description]);
}

// 2. Get all products
function afficherProduits() {
    global $pdo;
    $sql = "SELECT * FROM produits ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// 3. Delete a product
function supprimerProduit($id) {
    global $pdo;
    $sql = "DELETE FROM produits WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

// 4. Get one product by ID
function getProduitById($id) {
    global $pdo;
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// 5. Update a product
function modifierProduit($id, $nom, $image, $prix, $description) {
    global $pdo;
    $sql = "UPDATE produits SET nom=?, image=?, prix=?, description=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom, $image, $prix, $description, $id]);
}

function getClient($email, $motdepasse) {
    global $pdo;
    $sql = "SELECT * FROM client WHERE email = ? AND motdepasse = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $motdepasse]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function ajouterAuPanier($produit_id) {
    $produit = getProduitById($produit_id);
    if (!$produit) return false;

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$produit_id])) {
        // Already in cart, increase quantity
        $_SESSION['panier'][$produit_id]['quantite']++;
    } else {
        // Add new item
        $_SESSION['panier'][$produit_id] = [
            'nom'      => $produit['nom'],
            'prix'     => $produit['prix'],
            'image'    => $produit['image'],
            'quantite' => 1
        ];
    }
    return true;
}


function supprimerDuPanier($produit_id) {
    if (isset($_SESSION['panier'][$produit_id])) {
        unset($_SESSION['panier'][$produit_id]);
    }
}


function mettreAJourQuantite($produit_id, $quantite) {
    if ($quantite <= 0) {
        supprimerDuPanier($produit_id);
    } elseif (isset($_SESSION['panier'][$produit_id])) {
        $_SESSION['panier'][$produit_id]['quantite'] = $quantite;
    }
}

// 11. Get cart total
function totalPanier() {
    $total = 0;
    if (!empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
    }
    return $total;
}