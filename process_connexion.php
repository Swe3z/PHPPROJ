<?php
session_start();
require 'db.php';

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    $_SESSION['errors'] = ["Email et mot de passe requis"];
    header('Location: connexion.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['mot_de_passe'])) {
    $_SESSION['errors'] = ["Email ou mot de passe incorrect"];
    header('Location: connexion.php');
    exit;
}
 if($user && password_verify($password, $user['mot_de_passe'])){
            $_SESSION['user_id']= $user['id'];
            // Check if user is admin (ID 2)
            if ($user['id'] === 2) {
                header('Location: admin.php');
                exit;
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom']= $user['nom'];
            $_SESSION['user_classe']= $user['classe'];
         
            //ici c'est la mise de la derniere connexion
            $stmt= $pdo->prepare("UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id = ?")->execute([$user['id']]);
            header('Location: dashboard.php');
            exit;
        }else{
            $errors[]="Email ou mot de passe incorrect.";
        }
