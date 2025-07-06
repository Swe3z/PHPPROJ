<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Foire Aux Questions pour gérer votre emploi du temps efficacement." />
  <meta name="keywords" content="FAQ, emploi du temps, organisation, éducation, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>EduPlanner - FAQ</title>
  <link rel="icon" type="image/png" href="favicon.png" />
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
        <li><a href="Faq.php" class="nav-link active" role="menuitem" aria-current="page">FAQ</a></li>
        <li><a href="Contact.php" class="nav-link" role="menuitem">CONTACT</a></li>
      </ul>
    </nav>
  </header>

  <!-- Contenu principal -->
  <main>
    <!-- Section héro -->
    <section class="hero faq-hero">
      <div class="container hero-container">
        <div class="hero-content">
          <h1>Foire Aux Questions <span class="highlight">EduPlanner</span></h1>
          <p class="subtitle">Trouvez les réponses à vos questions sur l’utilisation d’EduPlanner.</p><br>
              <i class="fas fa-question-circle"></i> <strong>Qu’est-ce qu’EduPlanner ?</strong>
              <p>EduPlanner est une plateforme en ligne qui permet aux étudiants de consulter leur emploi du temps facilement, en fonction de leur classe.</p><br>
               <i class="fas fa-cogs"></i> <strong>Comment fonctionne EduPlanner ?</strong>
               <p>Il vous suffit de créer un compte et d’indiquer votre classe d’origine. Une fois inscrit, vous pouvez consulter les emplois du temps publiés par l’administrateur.</p><br>
               <i class="fas fa-user-cog"></i> <strong>Qui met à jour les emplois du temps ?</strong>
               <p>Les emplois du temps sont ajoutés et mis à jour exclusivement par l’administrateur de la plateforme (souvent un responsable pédagogique ou un membre du personnel scolaire).</p><br>
               <i class="fas fa-bell"></i> <strong>Comment suis-je informé lorsqu’un emploi du temps change ?</strong>
               <p>Dès qu’un nouvel emploi du temps est disponible pour votre classe, vous recevez une notification automatique vous en informant.</p><br>
               <i class="fas fa-history"></i> <strong>Est-ce que je peux accéder à l’historique des emplois du temps ?</strong>
               <p>Oui, une fois connecté, vous pouvez consulter les anciens emplois du temps de votre classe, selon les autorisations définies par l’administrateur.</p><br>
        </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Pied de page -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 <strong>EduPlanner</strong> — Un projet de Memel Esmel Axel & Traoré Kevin
      </p>
    </div>
  </footer>

  <script src="main.js"></script>
</body>
</html>