<?php
session_start();
require_once 'commandes.php';


if (!isset($_SESSION['client_id'])) {
    header('Location: client/login.php');
    exit;
}


if (empty($_SESSION['panier'])) {
    header('Location: cart.php');
    exit;
}


$total  = totalPanier();
$panier = $_SESSION['panier'];


$_SESSION['panier'] = [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée - SweetDream</title>
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
        .nav-greeting { color: #ffc107; font-size: 0.9rem; }
        .nav-btn {
            background: #dc3545;
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .checkmark {
            font-size: 5rem;
            animation: pop 0.5s ease;
        }
        @keyframes pop {
            0%   { transform: scale(0); }
            80%  { transform: scale(1.2); }
            100% { transform: scale(1); }
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
            <a class="nav-item" href="cart.php">🛒 Panier</a>
            <span class="nav-greeting">👋 <?= htmlspecialchars($_SESSION['client_pseudo']) ?></span>
            <a class="nav-btn" href="client/logout.php">Se déconnecter</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">

                <div class="checkmark">✅</div>
                <h2 class="mt-3">Commande Confirmée !</h2>
                <p class="text-muted">Merci <strong><?= htmlspecialchars($_SESSION['client_pseudo']) ?></strong>, votre commande a bien été enregistrée.</p>

                <!-- Order summary -->
                <div class="card mt-4 text-start">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Récapitulatif de votre commande</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($panier as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['nom']) ?></td>
                                    <td><?= $item['quantite'] ?></td>
                                    <td><?= number_format($item['prix'] * $item['quantite'], 0, ',', ' ') ?> TND</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="fw-bold text-end">Total :</td>
                                    <td class="fw-bold text-success"><?= number_format($total, 0, ',', ' ') ?> TND</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-3 justify-content-center">
                    <a href="page.php?voir=1" class="btn btn-primary">🛍️ Continuer mes achats</a>
                    <a href="page.php" class="btn btn-outline-secondary">🏠 Accueil</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>