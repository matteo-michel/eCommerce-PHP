<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerAuteur
{
    protected static $object = 'auteur';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        if(isset($_GET['numAuteur'])) {
            $books = ModelBook::getBooksFromAuteur(($_GET['numAuteur']));
            $auteur = ModelAuteur::select($_GET['numAuteur'])[0];
            if($books != false) {
                $view = 'detail';
                require File::build_path(array('view', 'view.php'));
            }
        } else {
            controllerBook::readAll();
        }
    }

    public static function delete()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            ModelAuteur::delete();
            self::readAll();
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function create()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'created';
            $numAuteur = '';
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function created()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $data = array(
                'prenomAuteur' => $_POST['prenomAuteur'],
                'nomAuteur' => $_POST['nomAuteur']);
            ModelAuteur::saveGen($data);
            self::readAll();
            echo "<div class='alert alert-success'>L\'auteur a bien été créé ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function update() {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'updated';
            $numAuteur = $_GET['numAuteur'];
            $auteur = ModelAuteur::select($numAuteur)[0];
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function updated() {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') {
            $numAuteur = $_POST['numAuteur'];
            $nomAuteur = $_POST['nomAuteur'];
            $prenomAuteur = $_POST['prenomAuteur'];
            $data = array('numAuteur' => $numAuteur,
                'nomAuteur' => $nomAuteur,
                'prenomAuteur' => $prenomAuteur);
            modelAuteur::update($data);

            self::readAll();
            echo "<div class='alert alert-success'>L'auteur a bien été modifié ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

}
