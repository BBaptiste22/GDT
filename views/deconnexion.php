<?php
include '../appBundle/controller/AnimateurController.php';
use appBundle\controller\AnimateurController;
$animateurController = new AnimateurController();
$animateurController->deconnexion();

// if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
//     $_SESSION['etat'] = "disconnect";
//     session_destroy();
//     header("Location: accueil.php");
//     // exit();
//  }
?>