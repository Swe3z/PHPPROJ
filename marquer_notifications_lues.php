<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: connexion.php');
  exit;
}

$userId = $_SESSION['user_id'];

$pdo->prepare("UPDATE notifications SET lue = 1 WHERE user_id = ?")->execute([$userId]);

header('Location: dashboard.php');
exit;
