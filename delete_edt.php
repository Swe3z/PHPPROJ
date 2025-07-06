<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté et est admin
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Vérifier si l'ID est fourni
if (!isset($_GET['id'])) {
    header('Location: admin.php');
    exit;
}

$id = $_GET['id'];

// Récupérer le fichier avant suppression
$stmt = $pdo->prepare("SELECT fichier FROM emplois_du_temps WHERE id = ?");
$stmt->execute([$id]);
$edt = $stmt->fetch();

if ($edt) {
    // Supprimer le fichier physique
    $upload_dir = 'uploads/emplois_du_temps/';
    $file_path = $upload_dir . $edt['fichier'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Supprimer l'enregistrement de la base de données
    $stmt = $pdo->prepare("DELETE FROM emplois_du_temps WHERE id = ?");
    $stmt->execute([$id]);
    
    // Supprimer les notifications liées
    $stmt = $pdo->prepare("DELETE FROM notifications WHERE message LIKE '%emploi du temps%' AND user_id IN (SELECT id FROM utilisateurs WHERE classe IN (SELECT classe FROM emplois_du_temps WHERE id = ?))");
    $stmt->execute([$id]);
    
    $_SESSION['success'] = "L'emploi du temps a été supprimé avec succès.";
} else {
    $_SESSION['error'] = "L'emploi du temps n'existe pas.";
}

// Rediriger vers la page admin
header('Location: admin.php');
exit;
