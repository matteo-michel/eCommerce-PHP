<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelEditeur extends Model
{
    private $numEditeur;
    private $nomEditeur;


    protected static $object = 'editeur';
    protected static $primary = 'numEditeur';

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

    public function __construct($numEditeur = NULL, $nomEditeur = NULL) {
        if (!is_null($numEditeur) && !is_null($nomEditeur)) {
            $this->numEditeur = $numEditeur;
            $this->nomEditeur = $nomEditeur;
        }
    }
}