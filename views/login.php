<?php 
/* élément pour ce connecter */
use appBundle\controller\AnimateurController;
// session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $identifiant = htmlspecialchars($_POST["identifiant"]);
    $mdp = htmlspecialchars($_POST['mdp']);

    include '../appBundle/controller/AnimateurController.php';
    $animateurController = new AnimateurController();
    $animateurController->connexion($identifiant, $mdp);
}

include 'navbar.php'; 
?>
<!-- formulaire de connexion -->
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Connexion</p>
                                    <form class="mx-1 mx-md-4" action="" method="post">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example1c">Votre identifiant</label>
                                                <input type="text" id="form3Example1c" class="form-control" name="identifiant" required />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label class="form-label" for="form3Example4c">Mot de passe</label>
                                                <input type="password" id="form3Example4c" class="form-control" name="mdp" required />
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a type="submit" name="annuler" class="btn btn-secondary btn-sm me-5" href='accueil.php'>Annuler</a>
                                            <button type="submit" name="connexion" class="btn btn-primary btn-sm">Se connecter</button>
                                        </div>
                                        <div class="d-flex justify-content-center mx-a mb-3 mb-lg-4">
                                            <a type="button" class="btn btn-link me-5" href='#'>Mot de passe oublier</a>
                                            <a type="submit" name="inscrire" class="btn btn-link " href='register.php'>Création de compte</a>
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
<?php include '../views/Footer.php'?>
</body>
</html>
