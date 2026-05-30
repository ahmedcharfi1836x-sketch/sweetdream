<?php

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once '../commandes.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$produit = getProduitById($id);

if (!$produit) {
    header('Location: index.php');
    exit;
}

// Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $nom         = trim($_POST['nom']);
    $image       = trim($_POST['image']);
    $prix        = trim($_POST['prix']);
    $description = trim($_POST['description']);
    
    modifierProduit($id, $nom, $image, $prix, $description);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit - SweetDream</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Administration</a>
            <a class="nav-link text-light" href="index.php"> <- Retour à la liste</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Modifier le Produit</h2>

        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="text" name="image" class="form-control" 
                                   value="<?= htmlspecialchars($produit['image']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom du Produit</label>
                            <input type="text" name="nom" class="form-control" 
                                   value="<?= htmlspecialchars($produit['nom']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prix (TND)</label>
                            <input type="number" name="prix" class="form-control" 
                                   value="<?= $produit['prix'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($produit['description']) ?></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" name="modifier" class="btn btn-warning">Enregistrer les Modifications</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>