<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    $nom = trim($_POST['nom'] ?? '');
    $classe = $_POST['classe'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($nom)) $errors[] = "Le nom est obligatoire.";
    if (!filter_var($email, FILTER_VAR_EMAIL)) $errors[] = "L'email n'est pas valide";
    if (empty($classe)) $errors[] = "La classe est obligatoire";
    if (strlen($password) < 6) $errors[] = "Mot de passe trop court";
    if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Un compte avec cet email existe déjà";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, classe) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $hash, $classe]);
            $_SESSION['success'] = "Inscription réussie, vous pouvez maintenant vous connecter.";
            header('Location: connexion.php');
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Créez votre compte pour accéder à votre emploi du temps personnalisé." />
  <meta name="keywords" content="inscription, emploi du temps, organisation, éducation, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>EduPlanner - Inscription</title>
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
        <li><a href="index.php" class="nav-link">ACCUEIL</a></li>
        <li><a href="faq.php" class="nav-link">FAQ</a></li>
        <li><a href="contact.php" class="nav-link">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <!-- Section principale -->
  <main>
    <section class="hero">
      <div class="container hero-container">
        <div class="hero-content">
          <form action="process_inscription.php" method="POST" class="auth-form" id="register-form" novalidate>
            <h2 class="form-title">Créer un compte</h2>

            <div class="form-group">
              <label for="nom">Nom complet</label>
              <input type="text" id="nom" name="nom" required placeholder="Ex : Jean Dupont">
              <span class="error" id="nom-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
              <label for="classe">Niveau </label>
              <select id="classe" name="classe" required>
                <option value="">-- Sélectionnez votre classe --</option>
                <option value="PREPA 1">PREPA 1</option>
                <option value="PREPA 2">PREPA 2</option>
                <option value="ING 1">ING 1</option>
                <option value="ING 2">ING 2</option>
                <option value="ING 3">ING 3</option>
              </select>
              <span class="error" id="classe-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
              <label for="email">Adresse email</label>
              <input type="email" id="email" name="email" required autocomplete="email" placeholder="ex: etudiant@gmail.com" />
              <span class="error" id="email-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
              <label for="password">Mot de passe</label>
              <div class="password-wrapper">
                <input type="password" id="password" name="password" required placeholder="••••••••" />
                <button type="button" class="toggle-password" aria-label="Afficher ou masquer le mot de passe">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <span class="error" id="password-error" aria-live="polite"></span>
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirmer le mot de passe</label>
              <div class="password-wrapper">
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="••••••••" />
                <button type="button" class="toggle-password" aria-label="Afficher ou masquer le mot de passe">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <span class="error" id="confirm-password-error" aria-live="polite"></span>
            </div>

            <button type="submit" class="btn btn-primary">S'inscrire</button>

            <p class="form-footer">
              Vous avez déjà un compte ? <a href="connexion.php">Connectez-vous ici</a>.
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
