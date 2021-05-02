<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path(array('model', 'ModelCommande.php'));

class ModelListeCommande extends Model
{
    private $numCommande;
    private $isbn;
    private $quantite;
    private $date;

    protected static $object = 'book';

    public function get($nom_attribut)
    {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public function set($nom_attribut, $valeur)
    {
        if (property_exists($this, $nom_attribut))
            $this->$nom_attribut = $valeur;
        return false;
    }

    public function __construct($numCommande = NULL, $isbn = NULL, $quantite = NULL, $date = NULL)
    {
        if (!is_null($numCommande) && !is_null($isbn) && !is_null($quantite) && !is_null($date)) {
            $this->numCommande = $numCommande;
            $this->isbn = $isbn;
            $this->quantite = $quantite;
            $this->date = $date;
        }
    }

    public static function selectNumCommande($login)
    {
        try {
            $sql="SELECT * FROM commande WHERE login = :login ";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array("login" => $login);
            $req_prep->execute($values);
            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelCommande");
            $tab = $req_prep->fetchAll();
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

    public static function selectBookCommande($login)
    {
        try {
            $sql="SELECT numCommande FROM commande WHERE login =:login";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array("login" => $login);
            $req_prep->execute($values);
            $req_prep->fetch();
            $tab = $req_prep->fetchAll();
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