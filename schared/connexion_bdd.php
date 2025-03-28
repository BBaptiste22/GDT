<?php
$dsn = 'mysql:host=localhost;dbname=petanque';
$username = 'root';
$password = 'root';

try {
    $dbco = new PDO($dsn, $username, $password);
    $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'connexion reussie';
} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
    exit();
}

?>

