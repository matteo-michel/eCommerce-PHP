<?php
$auteurs = ModelAuteur::getBookAuteurs($book->get('isbn'));
$resultAuteur = '';
foreach ($auteurs as $a) {
    $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ', ';
}
$resultAuteur = rtrim($resultAuteur, ', ');

$categories = ModelCategorie::getCategoriesFromBook($book->get('isbn'));
$resultCat = '';
foreach ($categories as $c) {
    $resultCat = $resultCat . $c->get('nomCategorie') . ', ';
}
$resultCat = rtrim($resultCat, ', ');

if (!$book->get('image')) {
    $image = '<img src="../../ressource/linux.png"/>';
} else {
    $image = '<img src="data:image/jpeg;base64,' . base64_encode($book->get('image')) . '"/>';
}

$date = date("d/m/Y", strtotime($book->get('dateParution')));

$panel = '<h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Achats</h6>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <a class="btn btn-primary buttonPanier" role="button" href="index.php?controller=panier&action=create&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-shopping-basket"></i>  Ajouter au panier</a>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <a class=" buttonEnvie btn btn-warning" role="button" href="index.php?controller=book&action=ajouterListeEnvie&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="far fa-heart"></i>  Ajouter à la liste d\'envie</a>
                                                                            </div>
                                                                        </div>';
if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') $panel = $panel . '<h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Modifications</h6>
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <a class="btn btn-warning" role="button" href="index.php?controller=book&action=update&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-pen"></i> Modifier le livre</a>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <a class="btn btn-danger" role="button" href="index.php?controller=book&action=delete&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-times"></i> Supprimer le livre</a>
                                                                            </div>
                                                                        </div>';
$updateImage='';
if (isset($_SESSION['login'])&&$_SESSION['isAdmin']=='1') $updateImage = '<a class="btn btn-secondary detailBookButton" role="button" href="index.php?controller=book&action=updatePicture&isbn=' . rawurlencode($book->get('isbn')) . '"><i class="fas fa-images"></i>  Modifier l\'image</a>';


if ($book->get('isExiste') == '0') $panel = '';

echo '
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">' .
                                $image .
                                '</div>' .
                                $updateImage .
                                '<h5 class="f-w-600">' . $book->get('titre') . '</h5>
                                <p>' . $book->get('isbn') . '</p>
                                <h6 class="f-w-600">Prix : ' . $book->get('prix') . '€</h6>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informations</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Auteur</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars($resultAuteur) . '</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Editeur</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars(ModelEditeur::select($book->get('numEditeur'))[0]->get('nomEditeur')) . '</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Resumé</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars($book->get('resume')) . '</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Catégorie</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars($resultCat) . '</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Date de parution</p>
                                        <h6 class="text-muted f-w-400">' . $date . '</h6>
                                    </div>                                   
                                </div>' . $panel . '
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
?>
