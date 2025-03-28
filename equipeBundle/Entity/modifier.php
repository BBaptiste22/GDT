<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../../shared/Connexion_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        $db = Connexion_bdd::getInstance();

        try {
            $db->beginTransaction();

            if ($action === 'updateEquipe') {
                if (isset($_POST['equipeId'], $_POST['nouveauNom'])) {
                    $equipeId = $_POST['equipeId'];
                    $nouveauNom = $_POST['nouveauNom'];

                    // Vérifier si le nouveau nom est déjà utilisé par une autre équipe
                    $sqlCheckUniqueNom = "SELECT COUNT(*) as count FROM equipe WHERE nom = :nom AND id != :id";
                    $stmtCheckUniqueNom = $db->prepare($sqlCheckUniqueNom);
                    $stmtCheckUniqueNom->bindParam(':nom', $nouveauNom, PDO::PARAM_STR);
                    $stmtCheckUniqueNom->bindParam(':id', $equipeId, PDO::PARAM_INT);
                    $stmtCheckUniqueNom->execute();
                    $result = $stmtCheckUniqueNom->fetch(PDO::FETCH_ASSOC);

                    if ($result['count'] > 0) {
                        $response = ['success' => false, 'error' => 'Ce nom est déjà utilisé par une autre équipe.'];
                        echo json_encode($response);
                        exit();
                    }

                    // Mettre à jour le nom de l'équipe dans la base de données
                    $sqlUpdateEquipe = "UPDATE equipe SET nom = :nom WHERE id = :id";
                    $stmtUpdateEquipe = $db->prepare($sqlUpdateEquipe);
                    $stmtUpdateEquipe->bindParam(':nom', $nouveauNom, PDO::PARAM_STR);
                    $stmtUpdateEquipe->bindParam(':id', $equipeId, PDO::PARAM_INT);
                    $stmtUpdateEquipe->execute();

                    $response = ['success' => true];
                    echo json_encode($response);
                    $db->commit();
                    exit();
                } else {
                    $response = ['success' => false, 'error' => 'Données incomplètes pour la modification du nom de l\'équipe.'];
                    echo json_encode($response);
                    exit();
                }
            } elseif ($action === 'updateJoueur') {
                if (isset($_POST['joueurId'], $_POST['nouveauNom'])) {
                    $joueurId = $_POST['joueurId'];
                    $nouveauNomJoueur = $_POST['nouveauNom'];

                    // Vérifier si le nouveau nom est déjà utilisé par un autre joueur
                    $sqlCheckUniqueNomJoueur = "SELECT COUNT(*) as count FROM joueur WHERE nom = :nom AND id != :joueur_id";
                    $stmtCheckUniqueNomJoueur = $db->prepare($sqlCheckUniqueNomJoueur);
                    $stmtCheckUniqueNomJoueur->bindParam(':nom', $nouveauNomJoueur, PDO::PARAM_STR);
                    $stmtCheckUniqueNomJoueur->bindParam(':joueur_id', $joueurId, PDO::PARAM_INT);
                    $stmtCheckUniqueNomJoueur->execute();
                    $resultJoueur = $stmtCheckUniqueNomJoueur->fetch(PDO::FETCH_ASSOC);

                    if ($resultJoueur['count'] > 0) {
                        $response = ['success' => false, 'error' => 'Ce nom est déjà utilisé par un autre joueur.'];
                        echo json_encode($response);
                        exit();
                    }

                    // Mettre à jour le nom du joueur dans la base de données
                    $sqlUpdateJoueur = "UPDATE joueur SET nom = :nom WHERE id = :id";
                    $stmtUpdateJoueur = $db->prepare($sqlUpdateJoueur);
                    $stmtUpdateJoueur->bindParam(':nom', $nouveauNomJoueur, PDO::PARAM_STR);
                    $stmtUpdateJoueur->bindParam(':id', $joueurId, PDO::PARAM_INT);
                    $stmtUpdateJoueur->execute();

                    $response = ['success' => true];
                    echo json_encode($response);
                    $db->commit();
                    exit();
                } else {
                    $response = ['success' => false, 'error' => 'Données incomplètes pour la modification du nom du joueur.'];
                    echo json_encode($response);
                    exit();
                }
            }
        } catch (PDOException $e) {
            $db->rollBack();
            $response = ['success' => false, 'error' => 'Erreur lors de la modification : ' . $e->getMessage()];
            echo json_encode($response);
            exit();
        }
    }
}
?>
