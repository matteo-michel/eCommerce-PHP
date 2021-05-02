<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelCommande extends Model
{
    private $numCommande;
    private $login;
    private $date;

    protected static $object = 'book';
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

    public function __construct($numCommande = NULL, $login = NULL, $date = NULL) {
        if (!is_null($numCommande) && !is_null($login) && !is_null($date)) {
            $this->numCommande = $numCommande;
            $this->login = $login;
            $this->date = $date;
        }
    }

    public static function saveCommande($data)
    {
        try {
            $sql = "INSERT INTO commande VALUES (0, :login, :date)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "login"=>$data['login'],
                "date"=>$data['date'],
            );
            $req_prep->execute($values);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            }
            else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }
}