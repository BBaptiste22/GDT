<?php
include '../schared/connexion_bdd.php';

if (isset($_POST['identifiant'])) {
    $identifiant = $_POST['identifiant'];

    $stmt = $dbco->prepare("SELECT COUNT(*) FROM animateur WHERE identifiant = ?");
    $stmt->execute([$identifiant]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}