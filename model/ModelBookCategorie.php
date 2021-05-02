<?php

class ModelBookCategorie extends Model
{
    private $isbn;
    private $numCategorie;

    protected static $object = 'bookCategorie';
    protected static $primary = 'isbn';

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

    public function __construct($numCategorie = NULL, $isbn = NULL)
    {
        if (!is_null($numCategorie) && !is_null($isbn)) {
            $this->numCategorie = $numCategorie;
            $this->isbn = $isbn;
        }
    }
}