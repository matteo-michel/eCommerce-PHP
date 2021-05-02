<?php
require_once File::build_path(array('controller','controllerUtilisateur.php'));
require_once File::build_path(array('controller','controllerBook.php'));
require_once File::build_path(array('controller','controllerAuteur.php'));
require_once File::build_path(array('controller','controllerCategorie.php'));
require_once File::build_path(array('controller','controllerEditeur.php'));
require_once File::build_path(array('controller','controllerCommande.php'));
require_once File::build_path(array('controller','controllerListeEnvie.php'));
require_once File::build_path(array('controller','controllerPanier.php'));
require_once File::build_path(array('lib','Security.php'));


$controller = 'book';
if (isset($_GET['controller']))
	$controller = $_GET['controller'];

$controller_class = 'controller'. ucfirst($controller);

if(class_exists($controller_class)) {
	if(!isset($_GET['action']) && !isset($_POST['action']))
		$action = 'readAll';
	else if(isset($_GET['action']))
		$action = $_GET['action'];
	else
		$action = $_POST['action'];

	if (!in_array($action, get_class_methods($controller_class))) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}
} else {
	header('HTTP/1.0 404 Not Found');
	exit;
}

$controller_class::$action();

?> 
