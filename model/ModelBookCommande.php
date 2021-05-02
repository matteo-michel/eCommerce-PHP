<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelBookCommande extends Model
{
    private $numCommande;
    private $isbn;
    private $quantite;

    protected static $object = 'bookCommande';
    protected static $primary = 'numCommande';

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

    public function __construct($numCommande = NULL, $isbn = NULL, $quantite = NULL) {
        if (!is_null($numCommande) && !is_null($isbn) && !is_null($quantite)) {
            $this->numCommande = $numCommande;
            $this->isbn = $isbn;
            $this->quantite = $quantite;
        }
    }

    public static function saveBookCommande($data)
    {
        try {
            $id = self::getNextId() - 1;
            $sql = "INSERT INTO bookCommande VALUES ($id, :isbn, :quantite)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "isbn" => $data['isbn'],
                "quantite" => $data['quantite'],
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function getNextId()
    {
        $req = Model::$pdo->query("SHOW TABLE STATUS FROM michelm LIKE 'commande' ");
        $donnees = $req->fetch();
        return $donnees['Auto_increment'];
    }
}