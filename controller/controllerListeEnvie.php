<?php
require_once File::build_path(array('model', 'ModelListeEnvie.php'));

class controllerListeEnvie
{
    protected static $object = 'listeEnvie';

    public static function readAll()
    {
        $tab = ModelListeEnvie::selectListeEnvie($_SESSION['login']);
        $view = 'listEnvie';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create(){
        if(isset($_GET['isbn']) && isset($_SESSION['login'])) {
            $isbn = $_GET['isbn'];
            $login = $_SESSION['login'];
            ModelListeEnvie::ajouter($login, $isbn);
            header('Location: index.php');
        } else {
            self::readAll();
        }
    }

    public static function delete(){
        if(isset($_GET['isbn']) && isset($_SESSION['login'])) {
            $isbn = $_GET['isbn'];
            $login = $_SESSION['login'];
            ModelListeEnvie::supprimer($login, $isbn);
            header('Location: index.php?controller=listeEnvie');
        } else {
            self::readAll();
        }
    }

}