<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$errors = [];
$success = '';

// Traitement formulaire modification mot de passe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!$current_password || !$new_password || !$confirm_password) {
        $errors[] = "Tous les champs sont requis.";
    } else {
        // Récup user
        $stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateurs WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['mot_de_passe'])) {
            $errors[] = "Mot de passe actuel incorrect.";
        } elseif (strlen($new_password) < 6) {
            $errors[] = "Le nouveau mot de passe doit faire au moins 6 caractères.";
        } elseif ($new_password !== $confirm_password) {
            $errors[] = "La confirmation du mot de passe ne correspond pas.";
        } else {
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id = ?");
            if ($stmt->execute([$hash, $_SESSION['user_id']])) {
                $success = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> Mot de passe mis à jour avec succès !</div>";
            } else {
                $errors[] = "Erreur lors de la mise à jour.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
  
<head>
  <meta charset="UTF-8" />
  <title>Profil - EduPlanner</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <style>
    .alert {
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      border-radius: 8px;
      position: relative;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      display: flex;
      align-items: center;
      gap: 1rem;
      font-size: 1rem;
      animation: fadeIn 0.3s ease-out;
    }

    .alert i {
      font-size: 1.25rem;
      opacity: 0.8;
    }

    .alert-success {
      background-color: #f0fff4;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-success i {
      color: #28a745;
    }

    .alert-error {
      background-color: #fff3f3;
      color: #842029;
      border: 1px solid #f8d7da;
    }

    .alert-error i {
      color: #dc3545;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>
<header class="header">
  <nav class="nav container" aria-label="Navigation principale">
      <div class="nav-brand">
        <a href="index.php" aria-label="Retour à l'accueil">
          <i class="fas fa-calendar-alt"></i><span>EduPlanner</span>
        </a>
      </div>
        <div class="nav-actions">
        <button class="theme-toggle" aria-label="Changer le thème" title="Changer thème clair/sombre">
          <i class="fas fa-moon"></i>
        </button>
        <button class="hamburger" aria-label="Menu mobile" aria-expanded="false" aria-controls="nav-menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>
      <ul class="nav-menu" id="nav-menu" role="menubar">
        <li><a class="nav-link" role="menuitem" href="dashboard.php">ACCUEIL</a></li>
        <li><a class="nav-link" role="menuitem" href="deconnexion.php">DECONNEXION</a></li>
      </ul>
  </nav>
</header>
<br><br> <br>
  <main class="container">
    
   <?php if ($errors): ?>
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin: 0; padding: 0; list-style: none;">
          <?php foreach ($errors as $err): ?>
            <li style="margin: 0.5rem 0;"><?=htmlspecialchars($err)?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <?= $success ?>
    <?php endif; ?>
    <form method="POST" action="profil.php" enctype="multipart/form-data" class="auth-form">
          
        <h1>Profil de <?=htmlspecialchars($_SESSION['user_nom'])?></h1>

        <legend>Modifier mot de passe</legend>
<br>
        <label for="current_password">Mot de passe actuel</label>
        <input type="password" id="current_password" name="current_password" required />
<br>
        <label for="new_password">Nouveau mot de passe</label>
        <input type="password" id="new_password" name="new_password" required />
<br>
        <label for="confirm_password">Confirmer le nouveau mot de passe</label>
        <input type="password" id="confirm_password" name="confirm_password" required />
<br>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
  </main>
</body>
</html>
