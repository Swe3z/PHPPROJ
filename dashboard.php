<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: connexion.php');
  exit;
}

$userId = $_SESSION['user_id'];

// Récupérer le nom et la classe de l'utilisateur
$stmt = $pdo->prepare("SELECT nom, classe FROM utilisateurs WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
if ($user) {
    $_SESSION['user_nom'] = $user['nom'];
    $classe = $user['classe'];
}

// Déterminer si c'est un admin (ID = 2)
$isAdmin = $userId === 2;

// Récupérer le dernier emploi du temps pour chaque classe
if ($isAdmin) {
    $stmt = $pdo->query("SELECT classe, semaine, fichier, date_publication 
                        FROM emplois_du_temps 
                        WHERE (classe, date_publication) IN 
                        (SELECT classe, MAX(date_publication) 
                         FROM emplois_du_temps 
                         GROUP BY classe)
                        ORDER BY classe");
    $dernierEDT = $stmt->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT id, classe, semaine, fichier, date_publication 
                          FROM emplois_du_temps 
                          WHERE classe = ? 
                          ORDER BY date_publication DESC LIMIT 1");
    $stmt->execute([$classe]);
    $dernierEDT = $stmt->fetch();
}

// Récupérer tous les anciens emplois du temps
$stmt = $pdo->prepare($isAdmin ? 
    "SELECT id, classe, semaine, fichier, date_publication FROM emplois_du_temps ORDER BY classe, date_publication DESC" : 
    "SELECT id, classe, semaine, fichier, date_publication FROM emplois_du_temps WHERE classe = ? ORDER BY date_publication DESC"
);
if (!$isAdmin) {
    $stmt->execute([$classe]);
} else {
    $stmt->execute();
}
$anciensEDT = $stmt->fetchAll();

// Récupérer les notifications non lues
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = ? AND lue = 0 ORDER BY date_envoi DESC");
$stmt->execute([$userId]);
$notifications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="EduPlanner - Créez votre compte pour accéder à votre emploi du temps personnalisé." />
  <meta name="keywords" content="inscription, emploi du temps, organisation, éducation, EduPlanner" />
  <meta name="author" content="Memel Esmel Axel & Traoré Kevin" />
  <title>EduPlanner - Dashboard</title>
  <link rel="icon" href="favicon.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Styles existants */

    /* Notifications Styles */
    .notifications {
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .notification-list {
      list-style: none;
      padding: 0;
    }

    .notification-card {
      background: #fff;
      border-radius: 8px;
      padding: 1.25rem;
      margin-bottom: 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .notification-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .notification-card.unread {
      border-left: 4px solid #2196F3;
    }

    .notification-content {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .notification-message {
      font-size: 1rem;
      color: #333;
    }

    .notification-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #666;
      font-size: 0.875rem;
    }

    .notification-time {
      opacity: 0.8;
    }

    .mark-as-read-form {
      margin-top: 1.5rem;
      text-align: right;
    }

    .btn-mark-read {
      background: #2196F3;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .btn-mark-read:hover {
      background: #1976D2;
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
        <li><a href="dashboard.php" class="nav-link">ACCUEIL</a></li>
        <li><a href="profil.php" class="nav-link">PROFIL</a></li>
        <?php if ($isAdmin): ?>
        <li><a class="nav-link" role="menuitem" href="admin.php">AJOUTER EMPLOI DU TEMPS</a></li>
        <?php endif; ?>
        <li><a href="deconnexion.php" class="nav-link">DECONNEXION</a></li>
      </ul>
    </nav>
  </header>
<br> <br><br><br><br>
  <main class="container">
    <div class="welcome-message">
      <h1>Bienvenue, <?=htmlspecialchars($_SESSION['user_nom'])?></h1>
    </div>

    <?php if ($notifications): ?>
      <section class="notifications">
        <h2>Notifications</h2>
        <div class="notification-list">
          <?php foreach ($notifications as $notif): ?>
            <div class="notification-card <?php echo $notif['lue'] ? '' : 'unread'; ?>">
              <div class="notification-content">
                <div class="notification-message">
                  <?=htmlspecialchars($notif['message'])?>
                </div>
                <div class="notification-meta">
                  <small class="notification-time">
                    <?= $notif['date_envoi'] ?>
                  </small>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <form action="marquer_notifications_lues.php" method="POST" class="mark-as-read-form">
          <button type="submit" class="btn-mark-read">Marquer toutes comme lues</button>
        </form>
      </section>
    <?php endif; ?>

  <section class="emploi-du-temps">
    <h2 class="table-title">Dernier emploi du temps publié</h2>
    <?php if ($isAdmin && !empty($dernierEDT)): ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Classe</th>
              <th>Semaine</th>
              <th>Date de publication</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dernierEDT as $edt): ?>
              <tr>
                <td><?=htmlspecialchars($edt['classe'])?></td>
                <td><?=htmlspecialchars(date('d/m/Y', strtotime($edt['semaine'])))?></td>
                <td><?=htmlspecialchars(date('d/m/Y H:i', strtotime($edt['date_publication'])))?></td>
                <td>
                  <div class="actions">
                    <a href="uploads/emplois_du_temps/<?=htmlspecialchars($edt['fichier'])?>" target="_blank" class="download-link">
                      <i class="fas fa-download"></i> Télécharger
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php elseif (!$isAdmin && $dernierEDT): ?>
      <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
              <th>Classe</th>
              <th>Semaine</th>
              <th>Date de publication</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?=htmlspecialchars($dernierEDT['classe'])?></td>
              <td><?=htmlspecialchars($dernierEDT['semaine'])?></td>
              <td><?=htmlspecialchars($dernierEDT['date_publication'])?></td>
              <td><div class="actions">
                  <a href="uploads/emplois_du_temps/<?=htmlspecialchars($dernierEDT['fichier'])?>" target="_blank" class="download-link">
                    <i class="fas fa-download"></i> Télécharger
                  </a>
                  </div>
              </td>
            </tr>
            
          </tbody>
        </table>
      </div>
      
    <?php else: ?>
      <?php if ($isAdmin): ?>
        <p>Aucun emploi du temps disponible.</p>
      <?php else: ?>
        <p>Aucun emploi du temps disponible pour votre classe.</p>
      <?php endif; ?>
    <?php endif; ?>
  </section>

  <section class="anciens-emplois">
    <h2 class="table-title">Anciens emplois du temps</h2>
    <?php if ($anciensEDT): ?>
      <div class="table-responsive">
        <?php 
        $currentClasse = null;
        foreach ($anciensEDT as $edt): 
          if ($edt['classe'] !== $currentClasse): 
            if ($currentClasse !== null): ?>
              </tbody>
            </table>
          <?php endif; ?>
          <h3 class="table-title"><?=htmlspecialchars($edt['classe'])?></h3>
          <table class="table">
            <thead>
              <tr>
                <th>Semaine</th>
                <th>Date de publication</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
          <?php endif; ?>
          <tr>
            <td><?=htmlspecialchars(date('d/m/Y', strtotime($edt['semaine'])))?></td>
            <td><?=htmlspecialchars(date('d/m/Y H:i', strtotime($edt['date_publication'])))?></td>
            <td>
              <div class="actions">
                <a href="uploads/emplois_du_temps/<?=htmlspecialchars($edt['fichier'])?>" target="_blank" class="download-link">
                  <i class="fas fa-download"></i> Télécharger
                </a>
              </div>
            </td>
          </tr>
          <?php 
          $currentClasse = $edt['classe'];
        endforeach; 
        if ($currentClasse !== null): ?>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <p>Aucun ancien emploi du temps.</p>
    <?php endif; ?>
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
