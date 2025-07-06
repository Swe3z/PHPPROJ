<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Gérez votre emploi du temps avec élégance et efficacité." />
  <meta name="keywords" content="emploi du temps, organisation, éducation, productivité, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>EduPlanner - Accueil</title>
  <link rel="icon" type="image/png" href="favicon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css">
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
        <li><a href="index.php" class="nav-link active" role="menuitem" aria-current="page">ACCUEIL</a></li>
        <li><a href="faq.php" class="nav-link" role="menuitem">FAQ</a></li>
        <li><a href="contact.php" class="nav-link" role="menuitem">CONTACT</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="hero" id="home">
      <div class="container hero-container">
        <div class="hero-content">
          <h1>Bienvenue sur <span class="highlight">EduPlanner</span></h1>
          <p class="subtitle">Consultez votre emploi du temps avec simplicité et efficacité.</p>
          <div class="hero-buttons">
            <a href="connexion.php" class="btn btn-primary">Connexion</a>
            <a href="inscription.php" class="btn btn-secondary">Inscription</a>
          </div>
        </div>
        <div class="image-log">
          <img src="image/mea2.png" alt="Illustration d’un emploi du temps" loading="lazy" />
        </div>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="container">
      <p>© 2025 <strong>EduPlanner</strong> — Un projet de Memel Esmel Axel & Traoré Kevin      </p>
    </div>
  </footer>

  <script src="main.js"></script>
</body>
</html>