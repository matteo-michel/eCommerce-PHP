<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelItemPanier extends Model
{
    private $isbn;
    private $quantite;

    public function __construct($isbn, $quantite) {
        $this->isbn = $isbn;
        $this->quantite = $quantite;
    }

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

    public function addQuantite()
    {
        $this->quantite ++;
    }

    public function removeQuantite() {
        $this->quantite--;
    }




}