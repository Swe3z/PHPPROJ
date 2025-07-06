<?php
session_start();
require 'db.php'; // fichier PDO $pdo connecté

// Nettoyage et validation basique
$nom = trim($_POST['nom'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$classe = trim($_POST['classe'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$errors = [];

if (!$nom) $errors[] = "Nom requis";
if (!$email) $errors[] = "Email invalide";
if (!$classe) $errors[] = "Classe requise";
if (strlen($password) < 6) $errors[] = "Mot de passe trop court (6 caractères minimum)";
if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas";

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('Location: inscription.php');
    exit;
}

// Vérifier si email existe déjà
$stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['errors'] = ["Email déjà utilisé"];
    header('Location: inscription.php');
    exit;
}

// Hash du mot de passe
$hash = password_hash($password, PASSWORD_DEFAULT);

// Insertion utilisateur
$stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, classe) VALUES (?, ?, ?, ?)");
if ($stmt->execute([$nom, $email, $hash, $classe])) {
    $_SESSION['success'] = "Compte créé avec succès, connectez-vous.";
    header('Location: connexion.php');
    exit;
} else {
    $_SESSION['errors'] = ["Erreur lors de l'inscription"];
    header('Location: inscription.php');
    exit;
}
