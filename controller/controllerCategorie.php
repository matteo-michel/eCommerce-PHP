<?php
require_once File::build_path(array('model', 'ModelCategorie.php'));

class controllerCategorie
{
    protected static $object = 'categorie';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $auteur = ModelCategorie::select($_GET['numCategorie']);
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'created';
            $numCategorie = '';
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function delete()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            ModelCategorie::delete();
            self::readAll();
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function created()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $data = array('nomCategorie' => $_POST['nomCategorie']);
            ModelCategorie::saveGen($data);
            self::readAll();
            echo "<div class='alert alert-success'>La catégorie a bien été créée ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function update() {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $view = 'form';
            $name = 'updated';
            $numCategorie = $_GET['numCategorie'];
            $categorie = ModelCategorie::select($numCategorie)[0];
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function updated() {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $numCategorie = $_POST['numCategorie'];
            $nomCategorie = $_POST['nomCategorie'];
            $data = array('numCategorie' => $numCategorie,
                'nomCategorie' => $nomCategorie);
            modelCategorie::update($data);

            self::readAll();
            echo "<div class='alert alert-success'>La catégorie a bien été modifiée ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }
}
