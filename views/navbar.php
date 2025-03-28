<?php
/* sert à faire le changement de la vu de quand on est connecter */
// Vérifiez si la session n'a pas déjà été démarrée avant d'appeler session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['etat'])) {
    $_SESSION['etat'] = 'disconnect';
}
// Détecter la page actuelle
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petanque</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.es.min.js" integrity="sha512-89Ar0ofqIrPG0GKRxVyihfyrZP3wApwUKRU5SxDLyk/o5OF3yVE6zNm30byp89uKsboFNinM2DEHYGOKTEIvPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../web/css/style.css">
    <script src="../web/js/script.js"></script>
    <script src="https://kit.fontawesome.com/59fa4e08aa.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand me-2" href="accueil.php">
            <img
                    src="../Ressources/petanque-155945_1280.png"
                    height="50"
                    loading="lazy"
                    style="margin-top: -1px; margin-right: auto;"
            />
        </a>

        <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarButtonsExample"
                aria-controls="navbarButtonsExample"
                aria-expanded="false"
                aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <div class="d-flex ms-auto align-items-center">
                
                <?php //echo $_SESSION['etat'];
                if ($_SESSION['etat'] == 'connect'){ ?>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'accueilConnect.php') ? 'active disabled' : '' ?>" href="accueilConnect.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'tournoi.php') ? 'active disabled' : '' ?>" href="tournoi.php">Tournoi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'classement.php') ? 'active disabled' : '' ?>" href="classement.php">Classement</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3" href="deconnexion.php?action=deconnexion">Déconnexion</a>

                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'accueil.php') ? 'active disabled' : '' ?>" href="accueil.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'tournoi.php') ? 'active disabled' : '' ?>" href="tournoi.php">Tournoi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link me-3 <?= ($current_page == 'login.php') ? 'active disabled' : '' ?>" href="login.php">Connexion</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
</body>
</html>
