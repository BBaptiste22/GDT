<?php
include_once __DIR__ . '/../../shared/Connexion_bdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $equipeId = intval($_POST['id']);

        try {
            // Récupérer l'instance de connexion à la base de données
            $db = Connexion_bdd::getInstance();
            $db->beginTransaction();

            $sqlDeleteEquipe = "DELETE FROM equipe WHERE id = :equipe_id";
            $stmtDeleteEquipe = $db->prepare($sqlDeleteEquipe);
            $stmtDeleteEquipe->bindParam(':equipe_id', $equipeId, PDO::PARAM_INT);
            $stmtDeleteEquipe->execute();

            // Valider et confirmer la transaction
            $db->commit();

            $response = ['success' => true];
            echo json_encode($response);
            exit();

        } catch (PDOException $e) {
            // Annuler la transaction en cas d'erreur
            $db->rollBack();

            $response = ['success' => false, 'error' => 'Erreur lors de la suppression de l\'équipe : ' . $e->getMessage()];
            echo json_encode($response);
            exit();
        }
    } else {
        $response = ['success' => false, 'error' => 'L\'ID de l\'équipe n\'est pas défini ou est invalide.'];
        echo json_encode($response);
        exit();
    }
}
?>
