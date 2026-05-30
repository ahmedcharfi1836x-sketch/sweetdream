<?php
session_start();
require_once 'commandes.php';
$produits = afficherProduits();
$showProducts = isset($_GET['voir']);
$isLoggedIn = isset($_SESSION['client_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SweetDream</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: sans-serif; }

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
            border: none;
            padding: 0.35rem 0.85rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .nav-btn:hover { background: #b02a37; }
        .nav-btn-login {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 0.35rem 0.85rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .nav-btn-login:hover { background: #0b5ed7; }
        .nav-greeting { color: #ffc107; font-size: 0.9rem; }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                        url('https://picsum.photos/id/1080/1200/500') center/cover;
            color: white;
            padding: 120px 1rem;
            text-align: center;
        }
        .hero-title  { font-size: 3.5rem; font-weight: bold; margin-bottom: 1rem; }
        .hero-sub    { font-size: 1.7rem; margin-bottom: 1.5rem; }
        .btn-discover {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.4rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-discover:hover { background: #e0a800; }

        .products-wrap {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }
        .section-title { text-align: center; margin-bottom: 3rem; font-size: 2rem; }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .prod-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .prod-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .prod-placeholder {
            width: 100%;
            height: 200px;
            background: #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }
        .prod-body    { padding: 1rem; flex: 1; }
        .prod-name    { font-size: 1.1rem; font-weight: bold; margin-bottom: 0.25rem; }
        .prod-price   { color: #198754; font-weight: bold; margin-bottom: 0.5rem; }
        .prod-desc    { color: #555; font-size: 0.95rem; margin-bottom: 1rem; }
        .prod-footer  { padding: 0.75rem 1rem; border-top: 1px solid #dee2e6; }

        .btn-cart {
            width: 100%;
            background: #ffc107;
            color: #000;
            border: none;
            padding: 0.5rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        .btn-cart:hover { background: #e0a800; }
        .btn-cart-disabled {
            width: 100%;
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 5px;
            font-weight: 600;
            cursor: not-allowed;
            display: block;
            text-align: center;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .login-notice {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .empty-msg { text-align: center; padding: 3rem 0; grid-column: 1 / -1; }
        .btn-go-admin {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: 6px;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-go-admin:hover { background: #0b5ed7; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="topnav">
        <a class="brand-logo" href="page.php">SweetDream</a>
        <div class="nav-links">
            <a class="nav-active" href="page.php">Accueil</a>
            <a class="nav-item" href="?voir=1">Produits</a>
            <a class="nav-item" href="admin/">Administration</a>

            <?php if ($isLoggedIn): ?>
                <span class="nav-greeting">👋 <?= htmlspecialchars($_SESSION['client_pseudo']) ?></span>
                <a class="nav-item" href="cart.php">
                    🛒 Panier
                    <?php if (!empty($_SESSION['panier'])): ?>
                        <span style="background:#ffc107; color:#000; border-radius:50%; padding: 0 6px; font-size:0.8rem; font-weight:bold;">
                            <?= array_sum(array_column($_SESSION['panier'], 'quantite')) ?>
                        </span>
                    <?php endif; ?>
                </a>
                <a class="nav-btn" href="client/logout.php">Se déconnecter</a>
            <?php else: ?>
                <a class="nav-btn-login" href="client/login.php">Se connecter</a>
                <a class="nav-item" href="client/register.php">S'inscrire</a>
            <?php endif; ?>
        </div>
    </nav>

    
    <?php if (!$showProducts): ?>
    <section class="hero">
        <h1 class="hero-title">🍭 SweetDream</h1>
        <p  class="hero-sub">Vos rêves les plus sucrés deviennent réalité</p>
        <a  class="btn-discover" href="?voir=1">Découvrir nos Délices</a>
    </section>
    <?php endif; ?>

    
    <?php if ($showProducts): ?>
    <div class="products-wrap">
        <h2 class="section-title">Nos Délices Sucrés 🍭</h2>

        <?php if (!$isLoggedIn): ?>
        <div class="login-notice">
            🔒 Connectez-vous pour pouvoir ajouter des produits à votre panier.
            <a href="client/login.php" style="color:#0d6efd; font-weight:600;">Se connecter</a>
            ou
            <a href="client/register.php" style="color:#198754; font-weight:600;">S'inscrire</a>
        </div>
        <?php endif; ?>

        <div class="products-grid">
            <?php if (empty($produits)): ?>
                <div class="empty-msg">
                    <h4>Aucun produit disponible pour le moment.</h4>
                    <a class="btn-go-admin" href="admin/">Aller à l'Administration</a>
                </div>
            <?php else: ?>
                <?php foreach ($produits as $produit): ?>
                    <div class="prod-card">
                        <?php if (!empty($produit['image'])): ?>
                            <img class="prod-img"
                                 src="<?= htmlspecialchars($produit['image']) ?>"
                                 alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <?php else: ?>
                            <div class="prod-placeholder">🍭</div>
                        <?php endif; ?>

                        <div class="prod-body">
                            <p class="prod-name"><?= htmlspecialchars($produit['nom']) ?></p>
                            <p class="prod-price"><?= number_format($produit['prix'], 0, ',', ' ') ?> TND</p>
                            <p class="prod-desc"><?= htmlspecialchars($produit['description']) ?></p>
                        </div>

                        <div class="prod-footer">
                            <?php if ($isLoggedIn): ?>
                                <!-- Cart button - ready for when you add cart logic -->
                                <a href="cart.php?add=<?= $produit['id'] ?>" class="btn-cart">
                                    🛒 Ajouter au panier
                                </a>
                            <?php else: ?>
                                <a href="client/login.php" class="btn-cart-disabled">
                                    🔒 Connectez-vous pour acheter
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>