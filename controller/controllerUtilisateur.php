<?php
require_once File::build_path(array('model', 'ModelUtilisateur.php'));

class ControllerUtilisateur {

	protected static $object = 'utilisateur';

    public static function readAll() {
        $tab = ModelUtilisateur::selectAll(';');
        $view = 'list';
        require File::build_path(array('view', 'view.php'));
    }

    public static function register()
    {
        $view = 'update';
        $name = 'register_end';
        $create = true;
        require File::build_path(array('view', 'view.php'));
    }

    public static function register_end()
    {
        if ($_POST['password']!=''&&$_POST['email']!=''&&$_POST['nom']!=''&&$_POST['prenom']!='') {
            $nonce = Security::generateRandomHex();
            $login = $_POST['login'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $data = array(
                'password' => $password,
                'email' => $_POST['email'],
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'isAdmin' => 0,
                'nonce' => $nonce);
            Model::saveCookie($data + array("login" => $_POST['login']), 5, 'createdData');
            ModelUtilisateur::saveGen($data);
            ModelUtilisateur::sendMail($login, $_POST['email'], $nonce);
            self::login();
        } else {
            echo '<p class="alert alert-danger">Veuillez remplir tous les champs !</p>';
            self::register();
        }
    }

    public static function login()
    {
        $view = 'form';
        $name = 'login_end';
        require File::build_path(array('view', 'view.php'));
    }

    public static function login_end()
    {
        if(!isset($_POST['login']) || !isset($_POST['password'])) {
            controllerBook::readAll();
            return;
        }
        $login = $_POST['login'];
        $mdp = $_POST['password'];
        $user = ModelUtilisateur::testLogin($login);
        if (!$user || !password_verify($mdp, $user->get('password'))) {
            session_destroy();
            Model::saveCookie(array('login' => $login), 5, 'createdData');
            header("location: index.php?controller=utilisateur&action=errorLogin");
        }
        elseif (!is_null($user->get('nonce'))) {
            session_destroy();
            echo '<p class="alert alert-danger">L\'email n\'est pas vérifié !</p>';
            self::login();
        }else {
            $_SESSION['login'] = $login;
            $user = ModelUtilisateur::select($login);
            $_SESSION['isAdmin'] = $user[0]->get('isAdmin');
            header('Location: index.php');
        }
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php');
    }

    public static function profile()
    {
        if(isset($_SESSION['login'])) {
            if ($_SESSION['isAdmin'] == 1 && isset($_GET['login']))
            {
                $login = $_GET['login'];
                $testAdmin = true;
            } else
            {
                $login = $_SESSION['login'];
                $testAdmin = false;
            }
            $view = 'profile';
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function update() {
        if(isset($_SESSION['login'])) {
            if (isset($_GET['login']) && $_SESSION['isAdmin'] == 1) {
                $login = $_GET['login'];
            } else {
                $login = $_SESSION['login'];
            }
            $view = 'update';
            $name = 'updated';
            $user = modelUtilisateur::select($login)[0];
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function updated() {
        if (isset($_SESSION['login'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $data = array('nom' => $nom, 'prenom' => $prenom, 'email' => $email);
            modelUtilisateur::update($data);

            echo "<div class='alert alert-success'>Le profil a bien été modifié ! </div>";
            self::profile();
        } else {
            ControllerUtilisateur::login();
        }

    }

    public static function promote() {
        if(isset($_SESSION['login']) && $_SESSION['isAdmin'] == 1 && isset($_GET['login'])) {
            $login = $_GET['login'];
            modelUtilisateur::promote($login);
        }
        self::readAll();
    }

    public static function delete() {
        if (isset($_SESSION['login'])) {
            if($_GET['login'] == $_SESSION['login'] || $_SESSION['isAdmin'] == '1') {
                modelUtilisateur::delete();
                if($_GET['login'] == $_SESSION['login'])
                    self::logout();
                else
                    self::readAll();
            } else {
                echo '<p class="alert alert-danger">Vous n\'avez pas la permission de réaliser cela !</p>';
                self::readAll();
            }
        } else {
            self::login();
        }
    }

    public static function validate(){
        $user = modelUtilisateur::testLogin($_GET['login']);
        if($user != false && ($_GET['nonce'] == $user->get('nonce')))
        {
            $login_utilisateur = $user->get('login');
            Model::$pdo->query("UPDATE utilisateur SET nonce = NULL WHERE login = '$login_utilisateur'");
        }
        self::login();
    }

    public static function updatePassword()
    {
        if (isset($_SESSION['login'])){
            $view = 'changePassword';
            $name = 'end_updatePassword';
            require File::build_path(array('view','view.php'));
        } else {
            self::login();
        }
    }

    public static function end_updatePassword()
    {
        if (isset($_SESSION['login'])){
            if ($_POST['old_password']!=''&&$_POST['new_password']!='') {
                $user = modelUtilisateur::select($_SESSION['login'])[0];
                $oldPassword = $_POST['old_password'];
                if (password_verify($oldPassword, $user->get('password'))) {
                    $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                    $data = array('password' => $newPassword);
                    modelUtilisateur::update($data);
                    self::profile();
                    echo '<p class="alert alert-success">Le mot de passe a été mis à jour !</p>';

                } else {
                    echo '<p class="alert alert-danger">L\'ancien mot de passe n\'est pas le bon !</p>';
                    self::updatePassword();
                }
            } else {
                echo '<p class="alert alert-danger">Veuillez remplir tous les champs !</p>';
                self::updatePassword();
            }
        } else {
            self::login();
        }
    }

    public static function forgotPassword()
    {
            $view = 'forgotPassword';
            $name = 'middle_forgotPassword';
            require File::build_path(array('view','view.php'));
    }

    public static function middle_forgotPassword()
    {
        if ($_POST['login']!='') {
            $user = modelUtilisateur::select($_POST['login']);
            if (!$user) {
                echo '<p class="alert alert-danger">Aucun utilisateur ne possède ce login</p>';
                self::forgotPassword();
                return;
            } else
            {
                $user = $user[0];
            }
            $userEmail = $user->get('email');
            $nonce = Security::generateRandomHex();
            $data = array('password' => $nonce);
            modelUtilisateur::update($data);
            ModelUtilisateur::sendMailPassword($_POST['login'], $userEmail, $nonce);
            echo '<p class="alert alert-success">Un email vous a été envoyé !</p>';
            controllerBook::readAll();
        } else {
            echo '<p class="alert alert-danger">Veuillez remplir tous les champs !</p>';
            self::forgotPassword();
        }
    }

    public static function endMidlle_forgotPassword()
    {
        if ($_GET['login']!=''&&$_GET['nonce']!='') {
            $user = modelUtilisateur::select($_GET['login'])[0];
            if (!$user) {
                echo '<p class="alert alert-danger">Aucun utilisateur ne possède ce login</p>';
                self::forgotPassword();
            }
            if ($user->get('password')==$_GET['nonce']){
                $view = 'changeForgotPassword';
                $name = 'end_forgotPassword';
                require File::build_path(array('view','view.php'));
            }
        } else {
            echo '<p class="alert alert-danger">Veuillez remplir tous les champs !</p>';
            self::forgotPassword();
        }
    }

    public static function end_forgotPassword()
    {
        if ($_POST['new_password']!='') {
            $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $data = array('password' => $newPassword);
            modelUtilisateur::update($data);
            header('Location: index.php?controller=utilisateur&action=profile');
        } else {
            echo '<p class="alert alert-danger">Veuillez remplir tous les champs !</p>';
            self::updatePassword();
        }
    }

    public static function errorSave() {
        if(isset($_COOKIE['createdData'])) {
            $cookie = unserialize($_COOKIE['createdData']);
            $user = new modelUtilisateur($cookie['login'],$cookie['nom'],$cookie['prenom'],'',$cookie['email'],'');
            $view = 'update';
            $create = true;
            $name = 'register_end';
            echo '<p class="alert alert-danger">Il y a un problème avec les informations saisies !</p>';
            require File::build_path(array('view', 'view.php'));
        }

    }

    public static function errorLogin() {
        if(isset($_COOKIE['createdData'])) {
            $cookie = unserialize($_COOKIE['createdData']);
            $user = new modelUtilisateur($cookie['login'],'','','','','');
            $view = 'form';
            $name = 'login_end';
            echo '<p class="alert alert-danger">Le mot de passe ne correspond pas à cet utilisateur !</p>';
            require File::build_path(array('view', 'view.php'));
        }

    }
}


