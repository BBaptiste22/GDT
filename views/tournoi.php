<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* élément pour créer un tournoi */
use AppBundle\Controller\AnimateurController;

require_once '../appBundle/controller/AnimateurController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Debugging : Afficher les données de la session
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

if (isset($_POST['envoie'])) {
     // Vérifier que tous les champs nécessaires sont présents
    // if (!empty($_POST['nom']) && isset($_POST['nb_joueur_equipe']) && !empty($_POST['poule']) && 
    //     (!empty($_POST['nb_poule']) || $_POST['poule'] === 'non') && 
    //     (!empty($_POST['nb_equipe_poule']) || $_POST['poule'] === 'non') && 
    //     isset($_POST['consolante'])) {

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $nb_joueur_equipe = (int)$_POST['nb_joueur_equipe']; // Conversion en entier pour la base de données
    $poule = $_POST['poule'];
    $nb_poule = ($_POST['poule'] === 'oui') ? (int)$_POST['nb_poule'] : 0;
    $nb_equipe_poule = ($_POST['poule'] === 'oui') ? (int)$_POST['nb_equipe_poule'] : 0;
    $consolante = $_POST['consolante'];

    // Vérifier que $_SESSION['animateur'] est bien un tableau avant d'accéder à ses éléments
    if (($_SESSION['etat'] == 'connect')) {
        $animateur = $_SESSION['animateur'];
        $id_animateur = $animateur->getId();

        // Debugging : Afficher l'ID de l'animateur pour confirmation
        echo 'ID Animateur: ' . $id_animateur;

        // Création d'une instance du contrôleur AnimateurController
        $animateurController = new AnimateurController();

        // Appel de la méthode pour créer un tournoi dans le contrôleur
        $animateurController->creationTournoi($id_animateur, $nom, $nb_joueur_equipe, $poule, $nb_poule, $nb_equipe_poule, $consolante);

    } else {
        // Debugging : Afficher un message si l'animateur n'est pas détecté dans la session
        echo 'Animateur non connecté ou données de session incorrectes.';
        // Redirection si l'animateur n'est pas connecté
        header("Location: login.php");
        //echo 'Redirection vers login désactivée pour débogage.';
        exit;
    }

    // } else {
    //     echo "Tous les champs nécessaires ne sont pas remplis.";
    // }
}
?>
<?php include_once 'navbar.php'; ?>

<!-- formulaire de création de tournoi -->
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-9">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-7" style="padding: 0rem;">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Création tournoi</p>
                                <form class="mx-1 mx-md-4" action="" method="post">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nom">Nom du tournoi</label>
                                            <input type="text" id="nom" class="form-control" name="nom" required />
                                        </div>
                                    </div>
                                    <div class="btn-group mb-4">
                                        <div class="d-flex flex-column align-items-center mb-4">
                                            <label for="nb_joueur_equipe" class="form-label">Nombre de joueurs par équipe</label>
                                            <select class="form-select" id="nb_joueur_equipe" name="nb_joueur_equipe" required>
                                                <option value="#">Choisissez une option</option>
                                                <option value="1">Seule</option>
                                                <option value="2">Doublette</option>
                                                <option value="3">Triplette</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <label for="poule" id="poule" class="form-label">Poules</label>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="poule" id="poulesOui" value="oui" onclick="togglePouleFields()">
                                            <label class="form-check-label" for="poulesOui">Oui</label>
                                        </div>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="poule" id="poulesNon" value="non" onclick="togglePouleFields()" checked>
                                            <label class="form-check-label" for="poulesNon">Non</label>
                                        </div>
                                    </div>
                                    <div id="pouleFields" style="display: none;">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="nb_poule">Nombre de poules</label>
                                                <input type="number" id="nb_poule" class="form-control" name="nb_poule" required>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="nb_equipe_poule">Nombre d'équipes par poule</label>
                                                <input type="number" id="nb_equipe_poule" class="form-control" name="nb_equipe_poule" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <label for="consolante" id="consolante" class="form-label">Consolante</label>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="consolante" id="consolanteOui" value="oui">
                                            <label class="form-check-label" for="consolanteOui">Oui</label>
                                        </div>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="radio" name="consolante" id="consolanteNon" value="non" checked>
                                            <label class="form-check-label" for="consolanteNon">Non</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="button" class="btn btn-secondary btn-sm me-5" onclick="window.location.href='accueil.php'">Annuler</button>
                                        <button type="submit" name="envoie" class="btn btn-primary btn-sm">valider</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'Footer.php'?>
