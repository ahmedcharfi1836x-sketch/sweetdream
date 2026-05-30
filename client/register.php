<?php
session_start();
require_once '../commandes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo      = trim($_POST['pseudo']);
    $email       = trim($_POST['email']);
    $motdepasse  = trim($_POST['motdepasse']);

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM client WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        $error = "Cet email est déjà utilisé !";
    } else {
        $sql = "INSERT INTO client (pseudo, email, motdepasse) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$pseudo, $email, $motdepasse])) {
            $_SESSION['success'] = "Compte créé avec succès ! Connectez-vous.";
            header('Location: login.php');
            exit;
        } else {
            $error = "Erreur lors de la création du compte.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SweetDream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-success text-white">
                        <h4>Créer un Compte Client</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label>Pseudo</label>
                                <input type="text" name="pseudo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Mot de passe</label>
                                <input type="password" name="motdepasse" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">S'Inscrire</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="login.php">Déjà un compte ? Se connecter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>