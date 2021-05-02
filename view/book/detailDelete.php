<?php
echo '<div class="home-content">';
foreach ($book as $bookitem) {
    if ($bookitem->get('isExiste') == '0') {
        $bISBN = $bookitem->get('isbn');
        echo '<div class="livre">';
        $resultAuteur = "";
        $auteurs = ModelAuteur::getBookAuteurs($bISBN);

        foreach ($auteurs as $a) {
            $resultAuteur = $resultAuteur . '<a href="index.php?controller=auteur&action=read&numAuteur=' . rawurlencode($a->get('numAuteur')) . '">' . htmlspecialchars($a->get('prenomAuteur')) . " " . htmlspecialchars($a->get('nomAuteur')) . '</a>' . ", ";
        }

        $resultAuteur = rtrim($resultAuteur, ', ');


        if (!$bookitem->get('image')) {
            echo '<img src="../../ressource/linux.png"/>';
        } else {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($bookitem->get('image')) . '"/>';
        }
        echo '  <div class="bookInfo">
                            <p>Titre : ' . htmlspecialchars($bookitem->get("titre")) . '</p>
                            <p> Auteurs : ' . $resultAuteur. '</p>
                            <p> Stock : ' . htmlspecialchars($bookitem->get('stock')) . '</p>
                            <p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>
                            </div>';

        echo "<div class ='panier horizontal'>";
        echo "<a class='btn btn-secondary' role='button' href=\"index.php?controller=book&action=safeReset&isbn=" . rawurlencode($bISBN) . "\"><i class='fas fa-coins'></i> Remettre en vente</a>";
        echo "<a class='btn btn-danger' role='button' href=\"index.php?controller=book&action=hardDelete&isbn=" . rawurlencode($bISBN) . "\"><i class=\"fas fa-trash-alt\"></i> Supprimer définitivement</a>";
        echo '</div>';
        echo '</div>';
    }
        echo '</div>';
}