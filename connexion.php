<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $errors[] = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            if ($user['id'] === 2) {
                header('Location: admin.php');
                exit;
            }
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_classe'] = $user['classe'];
            
            $stmt = $pdo->prepare("UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
            
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Connectez-vous pour accéder à votre emploi du temps." />
  <meta name="keywords" content="connexion, emploi du temps, organisation, éducation, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>Connexion | EduPlanner</title>
  <link rel="icon" href="favicon.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- En-tête -->
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
        <li><a href="index.php" class="nav-link" role="menuitem">ACCUEIL</a></li>
        <li><a href="faq.php" class="nav-link" role="menuitem">FAQ</a></li>
        <li><a href="contact.php" class="nav-link" role="menuitem">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <!-- Section de connexion -->
  <main>
    <section class="hero">
      <div class="container hero-container">
        <div class="hero-content">
          <form action="process_connexion.php" method="POST" class="auth-form" id="login-form" novalidate>
            <h2 class="form-title">Connexion</h2>

            <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="email" id="email" name="email" required autocomplete="email"
                     placeholder="ex. etudiant@gmail.com" aria-describedby="email-error" />
              <span class="error" id="email-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
              <label for="password">Mot de passe</label>
              <div class="password-wrapper">
                <input type="password" id="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••" aria-describedby="password-error" />
                <button type="button" class="toggle-password" aria-label="Afficher/Masquer le mot de passe">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <span class="error" id="password-error" aria-live="polite"></span>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>

            <p class="form-footer">
              Vous n’avez pas encore de compte ?
              <a href="inscription.php">Créer un compte</a>.
            </p>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Pied de page -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 <strong>EduPlanner</strong> — Un projet de Memel Esmel Axel & Traoré Kevin</p>
    </div>
  </footer>

  <script src="main.js"></script>
</body>
</html>
