<?php
require_once File::build_path(array('model', 'ModelItemPanier.php'));
require_once File::build_path(array('model', 'ModelCommande.php'));
require_once File::build_path(array('model', 'ModelBook.php'));
require_once File::build_path(array('model', 'ModelBookCommande.php'));

class controllerPanier
{
    protected static $object = 'panier';

    public static function readAll()
    {
        $tab = array();
        if (isset($_COOKIE['panier'])) $tab = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $view = 'panier';
        require File::build_path(array('view', 'view.php'));
    }

    public static function create() {
        if(isset($_COOKIE['panier'])) {
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
            unset($_COOKIE['panier']);
            $item = self::findObjectById($_GET['isbn'], $panier);
            if (!$item) {
                $itemPanier = new ModelItemPanier($_GET['isbn'], 1);
                $data = array($itemPanier);
                $data = array_merge($panier, $data);
                setcookie('panier', serialize($data), time() + 3600);
            } else {
                $item->addQuantite();
                setcookie('panier', serialize($panier), time() + 3600);
            }
        } else {
            $itemPanier = new ModelItemPanier($_GET['isbn'], 1);
            $data = array($itemPanier);
            setcookie('panier', serialize($data), time() + 3600);
        }
        header('Location: index.php');
    }

    public static function delete() {
        $isbn = $_GET['isbn'];
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        foreach ($panier as $key => $p)
            if($p->get('isbn') == $isbn) $index = $key;
        unset($panier[$index]);
        unset($_COOKIE['panier']);
        setcookie('panier', serialize($panier), time() + 3600);
        header('Location: index.php?controller=panier');
    }

    public static function clear() {
        if(isset($_COOKIE['panier'])) {
            setcookie("panier", "", time() - 3600);
        }
        header('Location: index.php?controller=panier');
    }

    public static function acheterPanier()
    {
        if (!isset($_SESSION['login']))
        {
            echo '<div class="alert alert-danger">Vous devez d\'abord vous connecter !</div>';
            ControllerUtilisateur::login();
        } else
        {
            $view = 'valideAchat';
            require File::build_path(array('view', 'view.php'));
        }
    }

    public static function acheterPanier_end()
    {
        if (!isset($_SESSION['login']))
        {
            echo '<div class="alert alert-danger">Vous devez d\'abord vous connecter !</div>';
            self::login();
        } else
        {
            if (!empty(unserialize($_COOKIE['panier'], ["allowed_classes" => true])))
            {
                $data = array(
                    'login' => $_SESSION['login'],
                    'date' => date("y-m-j")
                );
                ModelCommande::saveCommande($data);
            }
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
            foreach ($panier as $item)
            {
                $data = array(
                    'isbn' => $item->get('isbn'),
                    'quantite' => $item->get('quantite'),
                );
                ModelBookCommande::saveBookCommande($data);
                ModelBook::updateStock($item->get('isbn'), $item->get('quantite'));
            }
            self::clear();
            echo "<div class='alert alert-success'>La commande a bien été validée ! </div>";
        }
    }

    public static function update() {
        $quantite = $_POST['quantite'];
        if(isset($_COOKIE['panier'])) {
            $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
            unset($_COOKIE['panier']);
            $item = self::findObjectById($_POST['isbn'], $panier);
            $item->set('quantite', $quantite);
            setcookie('panier', serialize($panier), time() + 3600);
        }
        header('Location: index.php?controller=panier');
    }

    public static function findObjectById($id, $array){
        foreach ($array as $element ) {
            if ( $id == $element->get('isbn')) {
                return $element;
            }
        }
        return false;
    }
}