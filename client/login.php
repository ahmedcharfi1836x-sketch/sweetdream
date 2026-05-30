<?php
session_start();
require_once '../commandes.php';


if (isset($_SESSION['client_id'])) {
    header('Location: ../page.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email      = trim($_POST['email']);
    $motdepasse = trim($_POST['motdepasse']);

    $client = getClient($email, $motdepasse);

    if ($client) {
        $_SESSION['client_id']     = $client['id'];
        $_SESSION['client_pseudo'] = $client['pseudo'];
        header('Location: ../page.php');
        exit;
    } else {
        $error = "Email ou mot de passe incorrect !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SweetDream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Connexion Client</h4>
                    </div>
                    <div class="card-body">

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['success'] ?>
                                <?php unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="motdepasse" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se Connecter</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="register.php">Pas encore de compte ? S'inscrire</a>
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