<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelAuteur extends Model {
    private $nomAuteur;
    private $prenomAuteur;
    private $numAuteur;

    protected static $object = 'auteur';
    protected static $primary = 'numAuteur';

    public function get($nom_attribut) {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur) {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    public function __construct($nomAuteur = NULL, $prenomAuteur = NULL, $numAuteur = NULL) {
        if (!is_null($nomAuteur) && !is_null($prenomAuteur) && !is_null($numAuteur)) {
            $this->nomAuteur = $nomAuteur;
            $this->prenomAuteur = $prenomAuteur;
            $this->numAuteur = $numAuteur;
        }
    }

    public static function getBookAuteurs($isbn) {
        try {
            $sql= "SELECT * from auteur a JOIN bookAuteur b ON a.numAuteur = b.numAuteur WHERE b.isbn = :isbn";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array("isbn" => $isbn);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelAuteur");
            $tab=$req_prep->fetchAll();
            if(empty($tab)) return false;
            return $tab;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

}