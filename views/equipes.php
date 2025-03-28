<?php
include_once __DIR__ . '/../equipeBundle/controller/EquipeController.php';
include_once __DIR__ . '/../equipeBundle/Entity/Equipe.php';

$tournoiId = 1; // ID du tournoi à sélectionner
$equipeController = new Equipe();
$equipes = $equipeController->getEquipesByTournoiId($tournoiId); // Méthode pour récupérer les équipes par ID de tournoi
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des équipes pour le tournoi ID <?php echo $tournoiId; ?></title>
    <link href="../web/css/cssListeEquipe.css" rel="stylesheet">
</head>
<body>
<?php include_once 'navbar.php'; ?>
<div class="container mt-5">
    <h1 class="text-center">Liste des équipes pour le tournoi ID <?php echo $tournoiId; ?></h1>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php foreach ($equipes as $equipe): ?>
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <span class="team-name" id="teamName_<?php echo htmlspecialchars($equipe['id']); ?>"><?php echo htmlspecialchars($equipe['nom']); ?></span>
                        <span class="action-icons">
                            <i class="fas fa-pen icon-edit-equipe" data-id="<?php echo htmlspecialchars($equipe['id']); ?>"></i>
                            <i class="fas fa-trash-alt icon-delete" data-id="<?php echo htmlspecialchars($equipe['id']); ?>"></i>
                        </span>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                        // Récupérer les joueurs pour cette équipe
                        $joueurs = $equipeController->getJoueursByEquipeId($equipe['id']);
                        foreach ($joueurs as $joueur): ?>
                            <li class="list-group-item">
                                <strong>Joueur:</strong> <span class="joueur-nom"><?php echo htmlspecialchars($joueur['nom']); ?></span>
                                <i class="fas fa-pen icon-edit-joueur" data-id="<?php echo htmlspecialchars($joueur['id']); ?>"></i>
                                <input type="text" class="edit-input form-control" data-id="<?php echo htmlspecialchars($joueur['id']); ?>" value="<?php echo htmlspecialchars($joueur['nom']); ?>" style="display: none;">
                                <button class="btn btn-primary save-button" data-id="<?php echo htmlspecialchars($joueur['id']); ?>" style="display: none;">Sauvegarder</button>
                                <button class="btn btn-secondary cancel-button" data-id="<?php echo htmlspecialchars($joueur['id']); ?>" style="display: none;">Annuler</button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include_once 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../web/js/ListeEquipe.js"></script>
</body>
</html>
