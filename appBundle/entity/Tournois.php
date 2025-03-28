<?php
namespace AppBundle\Entity; 
use \PDO;

class Tournois {
    // les propriétés de la classe
    private $id;
    private $id_animateur;
    private $nom;
    private $nb_joueur_equipe;
    private $poule;
    private $nb_poule;
    private $nb_equipe_poule;
    private $consolante;

    // les getters
    public function getId() {
        return $this->id;
    }

    public function getId_animateur() {
        return $this->id_animateur;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getNb_joueur_equipe() {
        return $this->nb_joueur_equipe;
    }

    public function getPoule() {
        return $this->poule;
    }

    public function getNb_poule() {
        return $this->nb_poule;
    }

    public function getNb_equipe_poule() {
        return $this->nb_equipe_poule;
    }

    public function getConsolante() {
        return $this->consolante;
    }

    // les setters
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setId_animateur($id_animateur) {
        $this->id_animateur = $id_animateur;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setNb_joueur_equipe($nb_joueur_equipe) {
        $this->nb_joueur_equipe = $nb_joueur_equipe;
    }

    public function setPoule($poule) {
        $this->poule = $poule;
    }

    public function setNb_poule($nb_poule) {
        $this->nb_poule = $nb_poule;
    }

    public function setNb_equipe_poule($nb_equipe_poule) {
        $this->nb_equipe_poule = $nb_equipe_poule;
    }

    public function setConsolante($consolante) {
        $this->consolante = $consolante;
    }

    // constructeur
    public function __construct($id = null, $id_animateur = null, $nom = null, $nb_joueur_equipe = null, $poule = null, $nb_poule = null, $nb_equipe_poule = null, $consolante = null) {
        $this->id = $id;
        $this->id_animateur = $id_animateur;
        $this->nom = $nom;
        $this->nb_joueur_equipe = $nb_joueur_equipe;
        $this->poule = $poule;
        $this->nb_poule = $nb_poule;
        $this->nb_equipe_poule = $nb_equipe_poule;
        $this->consolante = $consolante;
    }

    // fonction to String
    public function __toString() {
        $reponse = "";
        foreach (get_object_vars($this) as $key => $value) {
            if ($value !== null) {
                $reponse .= "<pre>$key : $value</pre>";
            }
        }
        return $reponse;
    }

    // lecture des données du tournoi
    public function lecture($nom) {
        include '../schared/connexion_bdd.php';

        $lecture = $dbco->prepare("SELECT * FROM tournois WHERE nom = ?");
        $lecture->execute([$nom]);

        if ($lecture->rowCount() > 0) {
            $tournoi = $lecture->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "tournoi inexistant";
            $tournoi = [];
        }
        return $tournoi;
    }

    // fonction pour créer un tournoi
    /*public function ajout($nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante) {
        include '../schared/connexion_bdd.php';        
        try {
            
            $check_tournoi_sql = "SELECT COUNT(*) FROM tournois WHERE nom = ?"; // compare les identifiants 
            $check_tournoi_stmt = $dbco->prepare($check_tournoi_sql);
            $check_tournoi_stmt->execute([$nom]);
            $nb = $check_tournoi_stmt->fetchColumn();
            
            if ($nb > 0) {
                echo "Ce nom est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                $insert_tournoi_sql = "INSERT INTO tournois (nom, nb_joueur_equipe, poule, nb_poule, nb_equipe_poule, consolante) VALUES (?, ?, ?, ?, ?, ?)"; 
                $insert_tournoi_stmt = $dbco->prepare($insert_tournoi_sql);
                if ($insert_tournoi_stmt->execute([$nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante])) { // envoie les informations dans la base de donnée
                    echo "Creation effectuée";
                    session_start();
                    $_SESSION['tournoi'] = $tournoi;
                    header("Location: ../views/CreationEquipe.php");
                    exit();
                } else {
                    echo "Erreur lors de l'exécution de la requête d'insertion.";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la préparation de la requête: " . $e->getMessage();
        }
        echo "Tous les champs ne sont pas remplis.";
    }*/

    public function ajout($id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante) {
        include '../schared/connexion_bdd.php'; // Assurez-vous d'inclure votre fichier de connexion

        try {
            // Vérifie si le nom du tournoi est déjà utilisé
            $check_tournoi_sql = "SELECT COUNT(*) FROM tournois WHERE nom = ?";
            $check_tournoi_stmt = $dbco->prepare($check_tournoi_sql);
            $check_tournoi_stmt->execute([$nom]);
            $nb = $check_tournoi_stmt->fetchColumn();
            
            if ($nb > 0) {
                echo "Ce nom est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                // Insertion du tournoi dans la base de données
                $insert_tournoi_sql = "INSERT INTO tournois (id_animateur, nom, nb_joueur_equipe, poule, nb_poule, nb_equipe_poule, consolante) VALUES (?, ?, ?, ?, ?, ?, ?)"; 
                $insert_tournoi_stmt = $dbco->prepare($insert_tournoi_sql);
                
                if ($insert_tournoi_stmt->execute([ $id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante])) {
                    echo "Création effectuée avec succès";
                    // Rediriger après la création du tournoi
                    header("Location: ../views/CreationEquipe.php");
                    exit();
                } else {
                    echo "Erreur lors de l'exécution de la requête d'insertion.";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la préparation de la requête: " . $e->getMessage();
        }
    }

    public function modif() {
        // à coder
    }
}
