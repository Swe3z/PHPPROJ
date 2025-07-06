<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Contactez-nous pour toute question sur la gestion de votre emploi du temps." />
  <meta name="keywords" content="contact, support, emploi du temps, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>EduPlanner - Contact</title>
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
        <li><a href="contact.php" class="nav-link active" role="menuitem" aria-current="page">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <!-- Section principale -->
  <main>
    <section class="hero faq-hero">
      <div class="container hero-container">
        <div class="hero-content">
          <h1>Contactez <span class="highlight">EduPlanner</span></h1>
          <p class="subtitle">Nous sommes disponibles pour répondre à vos questions ou recevoir vos suggestions.</p>
          <address class="contact-info" style="line-height: 1.8; font-size: 1.1rem;">
            <strong>Emails :</strong><br>
            📧 <a href="mailto:axelmea09@gmail.com">axelmea09@gmail.com</a><br>
            📧 <a href="mailto:kevintraoretr@gmail.com">kevintraoretr@gmail.com</a><br><br>
            <strong>WhatsApp :</strong><br>
            📱 <a href="https://wa.me/2250153721857" target="_blank" rel="noopener">+225 01 53 72 18 57</a><br>
            📱 <a href="https://wa.me/2250713644839" target="_blank" rel="noopener">+225 07 09 18 86 75</a>
          </address>
        </div>
      </div>
    </section>
  </main>

  <!-- Pied de page -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 <strong>EduPlanner</strong> — Un projet de <strong>Memel Esmel Axel</strong> & <strong>Traoré Kevin</strong></p>
    </div>
  </footer>

  <script src="main.js"></script>
</body>
</html>
