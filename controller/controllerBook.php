<?php
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelAuteur.php'));
require_once File::build_path(array('model', 'ModelEditeur.php'));
require_once File::build_path(array('model', 'ModelCategorie.php'));
require_once File::build_path(array('model', 'ModelListeEnvie.php'));
require_once File::build_path(array('model', 'ModelBookCategorie.php'));

class controllerBook
{
    protected static $object = 'book';

    public static function readAll() {
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function read()
    {
        $book = ModelBook::select($_GET['isbn'])[0];
        $view = 'detail';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create()
    {
        if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1')
        {
            $view = 'form';
            $name = 'created';
            $isbn = '';
            $type = '';
            require File::build_path(array('view', 'view.php'));
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
            $data = array(
                'titre' => $_POST['titre'],
                'stock' => $_POST['stock'],
                'numEditeur' => $_POST['numEditeur'],
                'prix' => $_POST['prix'],
                'dateParution' => $_POST['date'],
                'resume' => $_POST['resume']);
            Model::saveCookie($data + array('isbn' => $_POST['isbn']), 5, 'createdData');
            $data = $data + array('image' => file_get_contents($_FILES['image']['tmp_name']));
            ModelBook::saveGen($data);
            $listAuteurs = $_POST['numAuteur'];
            foreach ($listAuteurs as $la) {
                $data = array(
                    'isbn' => $_POST['isbn'],
                    'numAuteur' => $la
                );
                ModelBook::saveBookAuteur($data);
            }
            $listCategorie = $_POST['numCategorie'];
            foreach ($listCategorie as $item) {
                $data = array(
                    'isbn' => $_POST['isbn'],
                    'numCategorie' => $item
                );
                ModelBook::saveBookCategorie($data);
            }
            self::readAll();
            echo "<div class='alert alert-success'>Le livre a bien été créé ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
            self::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function update() {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1')
        {
            $view = 'form';
            $name = 'updated';
            $isbn = $_GET['isbn'];
            $type = 'readonly';
            $book = ModelBook::select($isbn)[0];
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function updated() {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $isbn = $_POST['isbn'];
            $titre = $_POST['titre'];
            $prix = $_POST['prix'];
            $dateParution = $_POST['date'];
            $resume = $_POST['resume'];
            $numEditeur = $_POST['numEditeur'];
            $listeAuteur = $_POST['numAuteur'];
            $listeCategorie = $_POST['numCategorie'];
            $stock = $_POST['stock'];

            modelBook::updateBookAuteur($isbn, $listeAuteur);
            modelBook::updateBookCategorie($isbn, $listeCategorie);

            $data = array('isbn' => $isbn,
                'titre' => $titre,
                'numEditeur' => $numEditeur,
                'prix' => $prix,
                'dateParution' => $dateParution,
                'resume' => $resume,
                'stock' => $stock,
                'isExiste' => 1);
            modelBook::update($data);
            self::readAll();
            echo "<div class='alert alert-success'>Le livre a bien été modifié ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function ajouterListeEnvie(){
        if(!isset($_SESSION['login'])) {
            ControllerUtilisateur::login();
            return;
        }
        $isbn = $_GET['isbn'];
        $login = $_SESSION['login'];
        ModelListeEnvie::ajouter($login, $isbn);
        header('Location: index.php');
    }

    public static function listeEnvie()
    {
        $tab = ModelListeEnvie::select($_SESSION['login']);
        $view = 'listEnvie';
        require File::build_path(array('view', 'view.php'));

    }

    public static function delete()

    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1') {
            ModelBook::updateExiste(0);
            header('Location: index.php');
        } else {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerUtilisateur::login();
        }
    }

    public static function readDelete()
    {
        $book = ModelBook::selectAll('');
        $view = 'detailDelete';
        require File::build_path(array('view', 'view.php'));
    }

    public static function safeReset(){
        if (isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1') {
            ModelBook::updateExiste(1);
            header('Location: index.php?controller=book&action=readDelete');
        } else {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerUtilisateur::login();
        }
    }

    public static function hardDelete()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1') {
            ModelBook::delete();
            header('Location: index.php?controller=book&action=readDelete');
        } else {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerUtilisateur::login();
        }
    }

    public static function updatePicture()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1')
        {
            $view = 'formPicture';
            $name = 'end_updatePicture';
            $book = ModelBook::select($_GET['isbn'])[0];
            require File::build_path(array('view', 'view.php'));
        } else if (isset($_SESSION['login'])) {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function end_updatePicture()
    {
        if (isset($_SESSION['login']) && $_SESSION['isAdmin']=='1') {
            $data = array('image' => file_get_contents($_FILES['newImage']['tmp_name']));
            modelBook::update($data);
            self::readAll();
            echo "<div class='alert alert-success'>L'image du livre a bien été modifié ! </div>";
        } else if (isset($_SESSION['login'])) {
            echo '<div class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</div>';
            controllerBook::readAll();
        } else {
            ControllerUtilisateur::login();
        }
    }

    public static function errorSave() {
        if(isset($_COOKIE['createdData'])) {
            $cookie = unserialize($_COOKIE['createdData']);
            $book = new ModelBook($cookie['isbn'], $cookie['titre'], $cookie['numEditeur'], $cookie['prix'], $cookie['dateParution'], $cookie['stock'], '', $cookie['resume'], 1);
            $view = 'form';
            $name = 'created';
            $type = '';
            $isbn = $cookie['isbn'];
            $erreur = true;
            echo '<div class="alert alert-danger">Impossible d\'ajouter ce livre !</div>';
            require File::build_path(array('view', 'view.php'));
        }
    }

}