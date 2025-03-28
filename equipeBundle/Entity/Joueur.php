<?php
include_once __DIR__ . '/../../shared/Connexion_bdd.php';

class Joueur {
    private $id;
    private $id_animateur;
    private $nom;
    private $prenom;

    public function __construct($nom = '', $prenom = '', $id_animateur = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->id_animateur = $id_animateur;
    }


    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setIdAnimateur($id_animateur) {
        $this->id_animateur = $id_animateur;
    }

    public function sauvegarder() {
        try {
            $stmt = $this->db->prepare("INSERT INTO joueur (id_animateur, nom) VALUES (:id_animateur, :nom)");
            $stmt->bindParam(':id_animateur', $this->id_animateur);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->execute();
            return $this->db->lastInsertId(); // Retourne l'ID du joueur inséré
        } catch (PDOException $e) {
            return false;
        }
    }

    
    public static function getJoueursByEquipeId($equipeId) {
        try {
            $db = Connexion_bdd::getInstance();
            $stmt = $db->prepare("SELECT * FROM joueur WHERE id IN (SELECT id_joueur1 FROM equipe WHERE id = :equipe_id 
                                UNION SELECT id_joueur2 FROM equipe WHERE id = :equipe_id 
                                UNION SELECT id_joueur3 FROM equipe WHERE id = :equipe_id)");
            $stmt->bindParam(':equipe_id', $equipeId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
