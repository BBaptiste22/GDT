<?php

namespace AppBundle\Controller;
include_once '../appBundle/entity/Animateur.php';
include_once '../appBundle/entity/Tournois.php';
use AppBundle\Entity\Animateur;
use AppBundle\Entity\Tournois;

class AnimateurController {

    private $animateur;
    private $tournois;
    

    public function connexion($identifiant, $mdp) {
        require_once '../schared/connexion_bdd.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Démarrer la session
        }

        // Initialiser le compteur d'erreurs si ce n'est pas déjà fait
        if (!isset($_SESSION['error_count'])) {
            $_SESSION['error_count'] = 0;
        }

        $animateur = new Animateur();
        $connect = $animateur->connect($identifiant, $mdp);

        if ($connect['result'] == 'mdp' || $connect['result'] == 'ident') {
            // Incrémenter le compteur d'erreurs
            $_SESSION['error_count']++;
    
            if ($_SESSION['error_count'] >= 3) {
                // Réinitialiser le compteur et rediriger vers la page d'accueil après 3 erreurs
                $_SESSION['error_count'] = 0;
                header('Location: ../views/accueil.php');
            } else {
                // Redirection avec message d'erreur approprié
                $erreur = ($connect['result'] == 'mdp') ? 1 : 2;
                header("Location: login.php?erreur=$erreur");
            }
        } else {
            // Connexion réussie
            $user = $connect['user'];
            $animateur = new Animateur($user['id'], $user['nom'], $user['prenom'], $user['identifiant'], $user['mail']);
            $_SESSION['animateur'] = $animateur;
            $_SESSION['etat'] = 'connect';
            header("Location: ../views/accueilConnect.php");
        }
        exit(); // Assurez-vous de terminer le script après une redirection
    }

    

    public function inscription($nom, $prenom, $identifiant, $mail, $mdp) {
        require_once '../schared/connexion_bdd.php';

        $animateur = new Animateur();
        $inscrip = $animateur->inscrip($nom, $prenom, $identifiant, $mail, $mdp);
    }

    public function deconnexion() {
        include '../schared/connexion_bdd.php';

        $animateur = new Animateur();
        $deco = $animateur->deco();

    }

    public function ajoutAnimateur () {

    }

    public function modifAnimateur() {

    }

    public function lectTournoi($nom) {
        require_once '../schared/connexion_bdd.php';
        $tournois = new Tournois();
        $lecture = $tournois->lecture($nom);
    
        if (!empty($lecture)) {
            $tournoi = new Tournois(
                $lecture['id'], 
                $lecture['id_animateur'], 
                $lecture['nom'], 
                $lecture['nb_joueur_equipe'], 
                $lecture['poule'], 
                $lecture['nb_poule'], 
                $lecture['nb_equipe_poule'], 
                $lecture['consolante']
            );
            $_SESSION['tournoi'] = $tournoi;
            header("Location: ../views/CreationEquipe.php");
        } else {
            // Gérer le cas où le tournoi n'est pas trouvé
            header("Location: ../views/tournoi.php?error=1");
        }
        exit(); // Assurez-vous de terminer le script après une redirection
    }
    

    public function creationTournoi($id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante) {
        require_once '../schared/connexion_bdd.php';
    
        // Vérifie si l'animateur est connecté
        // if (!isset($_SESSION['animateur'])) {
        //     echo "Vous devez être connecté pour créer un tournoi.";
        //     return;
        // }
    
        // Récupérer l'ID de l'animateur depuis la session
        $animateur = $_SESSION['animateur'];
    
        try {
            // Continuer avec la création du tournoi
            $tournois = new Tournois($id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante);
            $tournois->ajout($id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante);
            $_session['tournois'] = $tournois;
        } catch (PDOException $e) {
            echo "Erreur lors de la création du tournoi : " . $e->getMessage();
        }
    }

}