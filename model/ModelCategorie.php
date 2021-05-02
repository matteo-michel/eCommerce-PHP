<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelCategorie extends Model
{
    private $numCategorie;
    private $nomCategorie;


    protected static $object = 'categorie';
    protected static $primary = 'numCategorie';

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

    public function __construct($numCategorie = NULL, $nomCategorie = NULL) {
        if (!is_null($numCategorie) && !is_null($nomCategorie)) {
            $this->numCategorie = $numCategorie;
            $this->nomCategorie = $nomCategorie;
        }
    }

    public static function getCategoriesFromBook($isbn) {
        try {
            $sql= "SELECT * 
            FROM categorie c 
            JOIN bookCategorie bc ON c.numCategorie = bc.numCategorie 
            WHERE bc.isbn = :isbn";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array("isbn" => $isbn);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelCategorie");
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