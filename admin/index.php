<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}


require_once '../commandes.php';

// Add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom         = trim($_POST['nom']);
    $image       = trim($_POST['image']);
    $prix        = trim($_POST['prix']);
    $description = trim($_POST['description']);
    
    ajouterProduit($nom, $image, $prix, $description);
    header('Location: index.php');
    exit;
}

// Delete product
if (isset($_GET['delete'])) {
    supprimerProduit($_GET['delete']);
    header('Location: index.php');
    exit;
}

$produits = afficherProduits();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - SweetDream</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">🛠️ Administration SweetDream</a>
            <a class="nav-link text-light" href="../page.php"><- Accueil</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Gestion des Produits</h1>

        
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h5>Ajouter un Nouveau Produit</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Image URL</label>
                            <input type="text" name="image" class="form-control" placeholder="https://..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nom du Produit</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Prix (TND)</label>
                            <input type="number" name="prix" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-success">Ajouter Produit</button>
                </form>
            </div>
        </div>

        
        <h3>Liste des Produits</h3>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><img src="<?= htmlspecialchars($p['image']) ?>" width="80" alt=""></td>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td><?= $p['prix'] ?> TND</td>
                    <td><?= htmlspecialchars(substr($p['description'], 0, 80)) ?>...</td>
                    <td>
                        <a href="edit.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="?delete=<?= $p['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>