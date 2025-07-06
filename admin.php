<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Vérifier si l'utilisateur est l'admin (ID spécifique)
/*if ($_SESSION['user_id'] !== 2) { // Change 2 to the actual admin ID
    header('Location: dashboard.php');
    exit;
}*/

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classe = $_POST['classe'] ?? '';
    $semaine = trim($_POST['semaine'] ?? '');
    $file = $_FILES['emploi_du_temps'] ?? null;

    if (!$classe) {
        $errors[] = "La classe est obligatoire.";
    }
    if (!$semaine) {
        $errors[] = "La date de la semaine est obligatoire.";
    }
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Le fichier de l'emploi du temps est obligatoire.";
    }

    if (empty($errors)) {
        // Insérer nouvel emploi du temps
        $stmt = $pdo->prepare("INSERT INTO emplois_du_temps (classe, semaine, fichier) VALUES (?, ?, ?)");
        
        // Définir le chemin de sauvegarde
        $upload_dir = 'uploads/emplois_du_temps/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $today = date('Y-m-d');
        $new_filename = 'emploi_' . $today . '_' . uniqid() . '.' . $file_extension;
        $target_file = $upload_dir . $new_filename;
        
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            $stmt->execute([$classe, $semaine, $new_filename]);
        } else {
            $errors[] = "Erreur lors du téléchargement du fichier.";
        }

        // Récupérer ID du nouvel emploi du temps
        $edtId = $pdo->lastInsertId();

        // Envoyer notification à tous les utilisateurs de la classe
        $message = "Un nouvel emploi du temps pour la classe $classe a été publié (Semaine: $semaine).";

        $stmtUsers = $pdo->prepare("SELECT id FROM utilisateurs WHERE classe = ?");
        $stmtUsers->execute([$classe]);
        $users = $stmtUsers->fetchAll();

        foreach ($users as $user) {
            $stmtNotif = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $stmtNotif->execute([$user['id'], $message]);
        }

        $success = "<div class='alert alert-success'><i class='fas fa-check-circle'></i> Nouvel emploi du temps publié avec succès !</div>";
    }
}

// Pour afficher les emplois du temps existants (optionnel)
$stmtEDT = $pdo->query("SELECT * FROM emplois_du_temps ORDER BY date_publication DESC");
$edtList = $stmtEDT->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Gestion emplois du temps</title>
   <link rel="icon" href="favicon.png" type="image/png" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <script>
    function viewFile(url) {
        // Ouvrir le fichier dans un nouvel onglet
        window.open(url, '_blank');
        return false; // Empêcher le comportement par défaut du lien
    }
  </script>
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
        <li><a href="profil.php"role="menuitem" class="nav-link">PROFIL</a></li>
        <li><a class="nav-link" role="menuitem" href="dashboard.php">DASHBOARD</a></li>
        <li><a class="nav-link" role="menuitem" href="deconnexion.php">DECONNEXION</a></li>
      </ul>
  </nav>
</header>
<br><br> <br>
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
<main class="container">
  <h1>Administration - Publication emploi du temps</h1>

  <?php if ($errors): ?>
    <div class="error" role="alert">
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?=htmlspecialchars($err)?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <?= $success ?>
  <?php endif; ?>

  <form action="admin.php" method="POST" enctype="multipart/form-data" class="auth-form">
    <div class="form-group">
      <label for="classe">Classe</label>
      <select id="classe" name="classe" required>
        <option value="">Choisissez la classe</option>
        <option value="PREPA 1">PREPA 1</option>
        <option value="PREPA 2">PREPA 2</option>
        <option value="ING 1">ING 1</option>
        <option value="ING 2">ING 2</option>
        <option value="ING 3">ING 3</option>
      </select>
    </div>

    <div class="form-group">
      <label for="semaine">Date de la semaine</label>
      <input type="date" id="semaine" name="semaine" required />
    </div>

    <div class="form-group">
      <label for="emploi_du_temps">Fichier de l'emploi du temps</label>
      <input type="file" id="emploi_du_temps" name="emploi_du_temps" accept=".pdf,.doc,.docx,.xlsx,.xls,.csv" required />
      </div>

    <button type="submit" class="btn btn-primary">Publier</button>
  </form>

  <section>
    <h2 class="table-title">Emplois du temps publiés</h2>
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success-message">
        <?=htmlspecialchars($_SESSION['success'])?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error-message">
        <?=htmlspecialchars($_SESSION['error'])?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($edtList): ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Classe</th>
              <th>Semaine</th>
              <th>Actions</th>
              <th>Date de publication</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($edtList as $edt): ?>
              <tr>
                <td><strong><?=htmlspecialchars($edt['classe'])?></strong></td>
                <td><?=htmlspecialchars($edt['semaine'])?></td>
                <td>
                  <div class="actions">
                    <a href="uploads/emplois_du_temps/<?=htmlspecialchars($edt['fichier'])?>" target="_blank" class="download-link">
                      <i class="fas fa-download"></i> Télécharger
                    </a>
                    <a href="delete_edt.php?id=<?=htmlspecialchars($edt['id'])?>" class="delete-link" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet emploi du temps ?')">
                      <i class="fas fa-trash"></i> Supprimer
                    </a>
                  </div>
                </td>
                <td><?=htmlspecialchars($edt['date_publication'])?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="no-results">Aucun emploi du temps publié pour le moment.</p>
    <?php endif; ?>
  </section>
</main>
<footer class="footer">
    <div class="container">
      <p>© 2025 <strong>EduPlanner</strong> — Un projet de <strong>Memel Esmel Axel</strong> & <strong>Traoré Kevin</strong></p>
    </div>
  </footer>
  <script src="main.js"></script>
</body>
</html>