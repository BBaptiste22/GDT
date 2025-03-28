<?php 
/* élément pour s'inscrire */
use appBundle\controller\AnimateurController;
if (isset($_POST['envoie'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['identifiant']) && !empty($_POST['mail']) && !empty($_POST['mdp'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $identifiant = $_POST['identifiant'];
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];

        include '../appBundle/controller/AnimateurController.php';
        $animateurController = new AnimateurController();
        $animateurController->inscription($nom, $prenom, $identifiant, $mail, $mdp);
    } else {
        echo 'Tous les champs ne sont pas remplis.';
    }
}

include_once 'navbar.php'; 
?>

<!-- formulaire d'inscription -->
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-9">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-7" style="padding: 0rem;">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Inscription</p>
                                <form class="mx-1 mx-md-4" action="" method="post">
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="nom">Votre nom</label>
                                            <input type="text" id="nom" class="form-control" name="nom" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="prenom">Votre prénom</label>
                                            <input type="text" id="prenom" class="form-control" name="prenom" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="identifiant">Votre identifiant</label>
                                            <input type="text" id="identifiant" class="form-control" name="identifiant" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="mail">Votre mail</label>
                                            <input type="email" id="mail" class="form-control" name="mail" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="mdp">Mot de passe</label>
                                            <input type="password" id="mdp" class="form-control" name="mdp" required />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <label class="form-label" for="confirm_password">Confirmer le mot de passe</label>
                                            <input type="password" id="confirm_password" class="form-control" name="confirm_password" required />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="button" class="btn btn-secondary btn-sm me-5" onclick="window.location.href='accueil.php'">Annuler</button>
                                        <button type="submit" name="envoie" class="btn btn-primary btn-sm">S'inscrire</button>
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
