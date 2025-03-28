<?php
include_once __DIR__ . '/../../shared/Connexion_bdd.php';

class Equipe {
    private $nom;
    private $id_tournois = 1;
    private $id_joueur1; // Ajout de la propriété pour l'ID du joueur
    private $id_joueur2;
    private $id_joueur3;

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setIdJoueur1($id_joueur1) {
        $this->id_joueur1 = $id_joueur1;
    }

    public function setIdJoueur2($id_joueur2) {
        $this->id_joueur2 = $id_joueur2;
    }

    public function setIdJoueur3($id_joueur3) {
        $this->id_joueur3 = $id_joueur3;
    }

    public function soumettreEquipe() {
        try {
            $db = Connexion_bdd::getInstance();
            
            $stmt = $db->prepare("INSERT INTO equipe (nom, id_tournois, id_joueur1, id_joueur2, id_joueur3) VALUES (:nom_equipe, :id_tournois, :id_joueur1, :id_joueur2, :id_joueur3)");
            $stmt->bindParam(':nom_equipe', $this->nom);
            $stmt->bindParam(':id_tournois', $this->id_tournois);
            $stmt->bindParam(':id_joueur1', $this->id_joueur1);
            $stmt->bindParam(':id_joueur2', $this->id_joueur2);
            $stmt->bindParam(':id_joueur3', $this->id_joueur3);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    

    public static function getEquipesByTournoiId($tournoiId) {
        try {
            $db = Connexion_bdd::getInstance();
            $stmt = $db->prepare("SELECT * FROM equipe WHERE id_tournois = :tournoi_id");
            $stmt->bindParam(':tournoi_id', $tournoiId, PDO::PARAM_INT);
            $stmt->execute();
            $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($equipes as &$equipe) {
                $equipe['joueurs'] = self::getJoueursByEquipeId($equipe['id']);
            }

            return $equipes;
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function getJoueursByEquipeId($equipeId) {
        try {
            $db = Connexion_bdd::getInstance();
            $stmt = $db->prepare("
                SELECT id, nom FROM joueur 
                WHERE id = (SELECT id_joueur1 FROM equipe WHERE id = :equipe_id)
                OR id = (SELECT id_joueur2 FROM equipe WHERE id = :equipe_id)
                OR id = (SELECT id_joueur3 FROM equipe WHERE id = :equipe_id)
            ");
            $stmt->bindParam(':equipe_id', $equipeId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
