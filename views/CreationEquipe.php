<?php
include_once '../shared/Connexion_bdd.php';
try {
    $db = Connexion_bdd::getInstance(); // Obtenir l'instance de la connexion PDO
    $query = $db->query("SELECT nb_joueur_equipe FROM tournois WHERE id = 1");
    $nombre_joueur_par_equipe = $query->fetchColumn();
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pétanque</title>
    <link rel="stylesheet" href="../web/css/cssEquipe.css">
    <style>
        /* Centrer la carte horizontalement */
        #conteneurCartes {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* S'assurer que les cartes sont empilées verticalement */
            min-height: 80vh;
        }

        /* Ajuster la taille de la carte */
        .card {
            width: 150%;
            max-width: 500px; /* Vous pouvez ajuster cette valeur selon vos besoins */
            min-height: 300px; 
        }
    </style>
</head>
<body>
    <?php include '../views/navbar.php'; ?>

    <div class="content-wrapper">
        <div class="container">
            <p id="compteurEquipes" data-nombre-joueurs="<?php echo htmlspecialchars($nombre_joueur_par_equipe, ENT_QUOTES, 'UTF-8'); ?>">Nombre d'équipes créées : 0</p>
            <p id="messageErreur" class="d-none">Vous devez soumettre l'équipe actuelle avant d'en ajouter une nouvelle.</p>
            <form id="formEquipe" method="POST">
                <div class="row" id="conteneurCartes">
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="../web/js/equipe.js" defer></script>
</body>
</html>
