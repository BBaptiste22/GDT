<?php
namespace appBundle\entity;
use \PDO;

class Animateur {
    // les propriétés de la classe
    private $id;
    private $nom;
    private $prenom;
    private $identifiant;
    private $mail;
    private $mdp;

    // les getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getMdp() {
        return $this->mdp;
    }

    // les setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setIdentifiant($identifiant) {
        $this->identifiant = $identifiant;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }

    public function setMdp($mdp) {
        $this->mdp = $mdp;
    }

    // constructeur
    public function __construct($id = null, $nom = null, $prenom = null, $identifiant = null, $mail = null, $mdp = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->identifiant = $identifiant;
        $this->mail = $mail;
        $this->mdp = $mdp;
    }


    // fonction to string
    public function __toString() {
        $reponse = "";
        foreach (get_object_vars($this) as $key => $value) {
            if ($value !== null) {
                $reponse .= "<pre>$key : $value</pre>";
            }
        }
        return $reponse;
    }

    // fonction pour vérifier les éléments de connexion + compteur
    public function connect($identifiant, $mdp) {
        include '../schared/connexion_bdd.php';

        $verif = $dbco->prepare("SELECT id, nom, prenom, identifiant, mail, mdp FROM animateur WHERE identifiant = ?");
        $identifiant = [$identifiant];
        $verif->execute($identifiant);

        if ($verif->rowCount() > 0) {
            $user = $verif->fetch(PDO::FETCH_ASSOC);

            // compare le mot de passe 
            if (password_verify($mdp, $user['mdp'])) {
                // Vérifier si une session n'est pas déjà démarrée
                $result = "ok";
            } else {
                $result = "mdp";
                $user = [];
                echo "identifiant non trouvé";
                //echo "Mot de passe incorrect";
            }
        } else {
            $result = 'ident';
            $user = [];
            //echo "identifiant non trouvé";
        }
        return ['result' => $result, 'user' => $user ];
    }

    // fonction pour créer un compte
    public function inscrip($nom, $prenom, $identifiant, $mail, $mdp) {
        include '../schared/connexion_bdd.php';        
        try {
            
            $check_user_sql = "SELECT COUNT(*) FROM animateur WHERE identifiant = ?"; // compare les identifiants 
            $check_user_stmt = $dbco->prepare($check_user_sql);
            $check_user_stmt->execute([$identifiant]);
            $nb = $check_user_stmt->fetchColumn();
            
            
            if ($nb > 0) {
                echo "Cet identifiant est déjà utilisé. Veuillez en choisir un autre.";
            } else {
                $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT); // hache le mot de passe en BCRYPT
                $insert_user_sql = "INSERT INTO animateur (nom, prenom, identifiant, mail, mdp) VALUES (?, ?, ?, ?, ?)"; 
                $insert_user_stmt = $dbco->prepare($insert_user_sql);
                if ($insert_user_stmt->execute([$nom, $prenom, $identifiant, $mail, $hashedPassword])) { // envoie les informations dans la base de donnée
                    echo "Inscription effectuée";
                    session_start();
                    $_SESSION['identifiant'] = $identifiant;
                    header("Location: ../views/login.php");
                    exit();
                } else {
                    echo "Erreur lors de l'exécution de la requête d'insertion.";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la préparation de la requête: " . $e->getMessage();
        }
        echo "Tous les champs ne sont pas remplis.";
        
    }

    // fonction pour ce déconnecter
    public function deco() {
        include '../schared/connexion_bdd.php';
        session_start();

        if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
            unset($_SESSION['identifiant']);
            session_destroy();
            header("Location: accueil.php");
            exit();
        }
    }
}