<?php
class Connexion_bdd {
    private static $instance = null;
    private $db;

    private function __construct() {
        $dsn = 'mysql:host=localhost;dbname=petanque';
        $username = 'mysql';
        $password = 'mysql';
        
        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
            exit();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->db;
    }
}
?>
