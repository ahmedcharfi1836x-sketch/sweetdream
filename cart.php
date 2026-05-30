<?php
session_start();
require_once 'commandes.php';


if (!isset($_SESSION['client_id'])) {
    header('Location: client/login.php');
    exit;
}


if (isset($_GET['add'])) {
    ajouterAuPanier((int)$_GET['add']);
    header('Location: cart.php');
    exit;
}


if (isset($_GET['remove'])) {
    supprimerDuPanier((int)$_GET['remove']);
    header('Location: cart.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantite'] as $id => $qty) {
        mettreAJourQuantite((int)$id, (int)$qty);
    }
    header('Location: cart.php');
    exit;
}


if (isset($_GET['clear'])) {
    $_SESSION['panier'] = [];
    header('Location: cart.php');
    exit;
}

$panier = $_SESSION['panier'] ?? [];
$total  = totalPanier();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - SweetDream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .topnav {
            background: #212529;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand-logo {
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
            text-decoration: none;
        }
        .nav-links { display: flex; gap: 1rem; align-items: center; }
        .nav-item   { color: rgba(255,255,255,0.75); text-decoration: none; }
        .nav-active { color: white; text-decoration: none; }
        .nav-btn {
            background: #dc3545;
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .nav-greeting { color: #ffc107; font-size: 0.9rem; }
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="topnav">
        <a class="brand-logo" href="page.php">SweetDream</a>
        <div class="nav-links">
            <a class="nav-item" href="page.php">Accueil</a>
            <a class="nav-item" href="page.php?voir=1">Produits</a>
            <a class="nav-item" href="admin/">Administration</a>
            <a class="nav-active" href="cart.php">🛒 Panier
                <?php if (!empty($panier)): ?>
                    <span class="badge bg-warning text-dark"><?= array_sum(array_column($panier, 'quantite')) ?></span>
                <?php endif; ?>
            </a>
            <span class="nav-greeting">👋 <?= htmlspecialchars($_SESSION['client_pseudo']) ?></span>
            <a class="nav-btn" href="client/logout.php">Se déconnecter</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">🛒 Mon Panier</h2>

        <?php if (empty($panier)): ?>
            <div class="alert alert-info text-center">
                Votre panier est vide.
                <a href="page.php?voir=1" class="alert-link">Continuer mes achats</a>
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="card mb-4">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Sous-total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($panier as $id => $item): ?>
                                <tr>
                                    <td>
                                        <img src="<?= htmlspecialchars($item['image']) ?>"
                                             class="cart-img" alt="">
                                    </td>
                                    <td class="align-middle"><?= htmlspecialchars($item['nom']) ?></td>
                                    <td class="align-middle"><?= number_format($item['prix'], 0, ',', ' ') ?> TND</td>
                                    <td class="align-middle" style="width: 120px;">
                                        <input type="number"
                                               name="quantite[<?= $id ?>]"
                                               value="<?= $item['quantite'] ?>"
                                               min="1" max="99"
                                               class="form-control form-control-sm">
                                    </td>
                                    <td class="align-middle fw-bold">
                                        <?= number_format($item['prix'] * $item['quantite'], 0, ',', ' ') ?> TND
                                    </td>
                                    <td class="align-middle">
                                        <a href="?remove=<?= $id ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Retirer cet article ?')">
                                           🗑️
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <a href="?clear=1" class="btn btn-outline-danger"
                           onclick="return confirm('Vider le panier ?')">
                           🗑️ Vider le panier
                        </a>
                        <a href="page.php?voir=1" class="btn btn-outline-secondary ms-2">
                           ← Continuer mes achats
                        </a>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" name="update" class="btn btn-outline-primary mb-2">
                            🔄 Mettre à jour les quantités
                        </button>
                        <div class="card">
                            <div class="card-body">
                                <h5>Total : <span class="text-success fw-bold"><?= number_format($total, 0, ',', ' ') ?> TND</span></h5>
                                <a href="checkout.php" class="btn btn-success w-100 mt-2">
                                    ✅ Passer la commande
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>