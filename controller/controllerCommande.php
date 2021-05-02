<?php
require_once File::build_path(array('model', 'ModelListeCommande.php'));
require_once File::build_path(array('model', 'ModelBookCommande.php'));

class controllerCommande
{

    protected static $object = 'commande';

    public static function readAll()
    {
        $tab = ModelListeCommande::selectNumCommande($_SESSION['login']);
        $view = 'listCommande';
        require File::build_path(array('view', 'view.php'));
    }
}