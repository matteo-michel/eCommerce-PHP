<?php
require_once File::build_path(array('model', 'ModelEditeur.php'));

class controllerEditeur
{
    protected static $object = 'editeur';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $auteur = ModelEditeur::select($_GET['numEditeur']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'created';
            $numEditeur = '';
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function delete()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            ModelEditeur::delete();
            self::readAll();
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function created()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $data = array('nomEditeur' => $_POST['nomEditeur']);
            ModelEditeur::saveGen($data);
            self::readAll();
            echo "<div class='alert alert-success'>L\'éditeur a bien été cré ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function update() {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'updated';
            $numEditeur = $_GET['numEditeur'];
            $editeur = ModelEditeur::select($numEditeur)[0];
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function updated() {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $numEditeur = $_POST['numEditeur'];
            $nomEditeur = $_POST['nomEditeur'];
            $data = array('numEditeur' => $numEditeur,
                'nomEditeur' => $nomEditeur);
            modelEditeur::update($data);

            self::readAll();
            echo "<div class='alert alert-success'>L\'éditeur a bien été modifié ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }
}
