<?php
echo "<p class='auteurTitle'>Livre(s) écris par " . ucfirst($auteur->get('prenomAuteur')) . " " . ucfirst($auteur->get('nomAuteur')) . " :</p>";
echo '<div class="home-content">';
foreach ($books as $b) {
    $bISBN = $b->get('isbn');
    $resultAuteur = "";
    $auteurs = ModelAuteur::getBookAuteurs($bISBN);

    foreach ($auteurs as $a) {
        $resultAuteur = $resultAuteur . '<a href="index.php?controller=auteur&action=read&numAuteur=' . rawurlencode($a->get('numAuteur')) . '">' . htmlspecialchars($a->get('prenomAuteur')) . " " . htmlspecialchars($a->get('nomAuteur')) . '</a>' . ", ";
    }

    $resultAuteur = rtrim($resultAuteur, ', ');

    echo '<div class="livre">';
    if(!$b->get('image')) {
        echo '<img src="../../ressource/linux.png"/>';
    } else {
        echo '<img src="data:image/jpeg;base64,'.base64_encode($b->get('image')).'"/>';
    }
    echo '  <div class="bookInfo">
                <p>Titre : '. htmlspecialchars($b->get("titre")) . '</p>
                <p> Auteurs : '. $resultAuteur .'</p>
                <p> Stock : '. htmlspecialchars($b->get('stock')) .'</p>
                <p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>
                </div>
                <div class="panier">
                <p>' . htmlspecialchars($b->get("prix")) . '<sup>€</sup></p>';
    if ($b->get('stock') == 0) {
        echo '<p id="stock"> Rupture de stock </p>';
    } else {
        echo "<a class='btn btn-primary' role='button' href=\"index.php?controller=panier&action=create&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-shopping-basket\"></i>  Ajouter au panier</a>";
    }
    isset($_SESSION['login']) ? $listEnvie = ModelListeEnvie::selectListeEnvie($_SESSION['login']) : $listEnvie = false;
    $content = false;
    if ($listEnvie != false) {
        foreach ($listEnvie as $itemlisteEnvie)
            if ($itemlisteEnvie->get('isbn') == $bISBN) $content = true;
    }

    if (!$content)
        echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=book&action=ajouterListeEnvie&isbn=" . rawurlencode($bISBN) . "\"><i class=\"far fa-heart\"></i>  Ajouter à la liste d'envie</a>";
    else
        echo "<a class='btn btn-warning invisible' role='button' href=\"index.php?controller=book&action=ListeEnvie&isbn=" . rawurlencode($bISBN) . "\"><i class=\"far fa-heart\"></i>  Ajouter à la liste d'envie</a>";
    echo '</div></div>';
}
echo '</div>';