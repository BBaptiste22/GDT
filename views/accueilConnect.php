<?php
use appBundle\controller\AnimateurController;
include_once '../appBundle/entity/Animateur.php';
use appBundle\entity\Animateur;


include 'navbar.php';
?>
<div class="container-fluid p-0 position-relative">
    <img src="../Ressources/boule_02 - Accueil.jpeg" class="img-fluid w-100 reduced-image">
    <div class="center-text text-center text-white">
        <h1 class="display-3">Bienvenue</h1>
        <?php
        $animateur = $_SESSION['animateur'];
        $nom = $animateur->getNom();
        $prenom = $animateur->getPrenom();
        echo $nom . " " . $prenom;
        ?>
    
    </div>
</div>

<?php include 'footer.php'; ?>
