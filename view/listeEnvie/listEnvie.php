<?php
if (!$tab)
{
    echo '<div class="panierEmpty">';
    echo '<p>La liste d\'envie est vide !</p>';
    echo '<a class="btn btn-primary" href="index.php"><i class="fas fa-chevron-left"></i> Retour aux achats</a>';
    echo '</div>';
} else {
    foreach ($tab as $u) {
        $bISBN = $u->get('isbn');
        $livre = ModelBook::select($bISBN)[0];
        $resultAuteur = "";
        $auteurs = ModelAuteur::getBookAuteurs($bISBN);

        foreach ($auteurs as $a) {
            $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
        }

        echo '<div class="livre">';

        if(!$livre->get('image')) {
            echo '<img src="../../ressource/linux.png"/>';
        } else {
            echo '<img src="data:image/jpeg;base64,'.base64_encode($livre->get('image')).'"/>';
        }
        echo '<div class="bookInfo">';
        echo '<p>Titre : ' . htmlspecialchars($livre->get("titre")) . '</p>';
        echo '<p> Auteurs : ' . htmlspecialchars($resultAuteur) . '</p>';
        echo '<p> Stock : ' . htmlspecialchars($livre->get('stock')) . '</p>';
        echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>';
        echo '</div>';
        echo '<div class="panier">';
        echo '<p>' . htmlspecialchars($livre->get("prix")) . '<sup>€</sup></p>';
        if ($livre->get('isExiste') == '1') {
            if ($livre->get('stock') == 0) {
                echo '<p id="stock"> Rupture de stock </p>';
            } else {
                echo "<a class='btn btn-primary' role='button' href=\"index.php?controller=panier&action=create&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-shopping-basket\"></i>  Ajouter au panier</a>";
            }
        } else {
            echo '<p id="stock"> Ce produit n\'est plus disponible à la vente ! </p>';
        }
        echo "<a class='btn btn-warning' role='button' href=\"index.php?controller=listeEnvie&action=delete&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-times\"></i>  Supprimer de la liste d'envie</a>";
        echo '</div>';
        echo '</div>';
    }
}