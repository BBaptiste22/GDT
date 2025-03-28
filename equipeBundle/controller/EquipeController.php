<?php
include_once __DIR__ . '/../Entity/Joueur.php';
include_once __DIR__ . '/../Entity/Equipe.php'; 
include_once __DIR__ . '/../../shared/Connexion_bdd.php';

class EquipeController {
    private $db;

    public function __construct() {
        $this->db = Connexion_bdd::getInstance();
    }

    public function ajouterJoueur($nom) {
        $joueur = new Joueur();
        $joueur->setNom($nom);
        return $joueur->sauvegarder();
    }

    public function soumettreEquipe($nom_equipe, $id_joueur1, $id_joueur2, $id_joueur3 = null) {
        $equipe = new Equipe();
        $equipe->setNom($nom_equipe);
        $equipe->setIdJoueur1($id_joueur1);
        $equipe->setIdJoueur2($id_joueur2);
        $equipe->setIdJoueur3($id_joueur3);
        return $equipe->soumettreEquipe();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['joueurs']) && isset($_POST['nom_equipe'])) {
        $joueurs = $_POST['joueurs'];
        $nom_equipe = $_POST['nom_equipe'];

        if (count($joueurs) < 1) {
            http_response_code(400);
            echo json_encode(['message' => 'Il faut au moins un joueur']);
            exit;
        }

        $controller = new EquipeController();
        $resultat = true;

        
        $ids_joueurs = [];
        foreach ($joueurs as $index => $nom_joueur) {
            $id_joueur = $controller->ajouterJoueur($nom_joueur);
            if (!$id_joueur) {
                $resultat = false;
                break;
            }
            $ids_joueurs[] = $id_joueur;
        }

    
        if ($resultat && count($ids_joueurs) >= 1) {
            $id_joueur1 = $ids_joueurs[0];
            $id_joueur2 = $ids_joueurs[1] ?? null;
            $id_joueur3 = $ids_joueurs[2] ?? null; 
            if (!$controller->soumettreEquipe($nom_equipe, $id_joueur1, $id_joueur2, $id_joueur3)) {
                $resultat = false;
            }
        }

        if ($resultat === true) {
            http_response_code(200);
            echo json_encode(['message' => 'Équipe et joueurs créés avec succès']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Erreur lors de la création de l\'équipe ou des joueurs']);
            error_log("Erreur lors de la création de l'équipe ou des joueurs.");
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Données requises manquantes']);
        error_log("Données requises manquantes.");
    }
}
?>
