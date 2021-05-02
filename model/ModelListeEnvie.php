<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelListeEnvie extends Model
{
    private $login;
    private $isbn;

    protected static $object = 'listeEnvie';
    protected static $primary = 'login';


    public function __construct($login = NULL, $isbn = NULL) {
        if (!is_null($login) && !is_null($isbn)) {
            $this->login = $login;
            $this->isbn = $isbn;
        }
    }

    public function get($nom_attribut)
    {
        if (property_exists($this, $nom_attribut))
            return $this->$nom_attribut;
        return false;
    }

    public static function ajouter($login, $isbn)
    {
        try {
            $sql = "INSERT INTO listeEnvie VALUES (:login, :isbn)";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
                "login" => $login,
                "isbn" => $isbn,
            );
            $req_prep->execute($values);
            return true;
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else if ($e->getCode() == 23000) {
                echo "Vous avez déjà ce livre dans votre liste d'envie !";
                return false;
            } else {
                echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function supprimer($login, $isbn) {
        try {
            $sql = "DELETE FROM listeEnvie WHERE login = :login AND isbn = :isbn;";
            $req = Model::$pdo->prepare($sql);
            $value = array('login' => $login, 'isbn' => $isbn);
            $req->execute($value);
        } catch (PDOException $e) {
            if (Conf::getDebug()) {
                echo $e->getMessage();
            } else {
                echo 'Une erreur est survenue <a href="index.php"> retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function selectListeEnvie($primary_value)
    {
        try {
            $sql="SELECT * from listeEnvie WHERE login =:nom_tag";

            $req_prep = Model::$pdo->prepare($sql);
            $values = array("nom_tag" => $primary_value);

            $req_prep->execute($values);

            $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelListeEnvie");
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