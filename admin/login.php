<?php
session_start();
require_once '../commandes.php';


if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

//login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo     = trim($_POST['pseudo']);
    $motdepasse = trim($_POST['motdepasse']);

    $admin = getAdmin($pseudo, $motdepasse);  // use the function

    if ($admin) {
        $_SESSION['admin_id']     = $admin['id'];
        $_SESSION['admin_pseudo'] = $admin['pseudo'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Pseudo ou mot de passe incorrect !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - SweetDream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center bg-dark text-white">
                        <h4>Connexion Administration</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Pseudo</label>
                                <input type="text" name="pseudo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="motdepasse" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se Connecter</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="../page.php">← Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>