<?php
if ($tab != false)
{
    $tab = array_reverse($tab);
    foreach ($tab as $u) {
        $listeBookByNumCommande = ModelBookCommande::select($u->get('numCommande'));
        setlocale(LC_TIME, "fr_FR", "French");
        $date = utf8_encode(strftime("%d %B %G", strtotime($u->get('date'))));

        echo '<div class = "articles-commande">';
        echo '<p class="dateCommande">Commande effectué le ' . $date . '</p>';
        $prixTotal = 0;

        if (!$listeBookByNumCommande) {
            echo '<p> Les elements de cette commande n\'existent plus ! </p></div>';

        } else {
            foreach ($listeBookByNumCommande as $book) {
                $livreCommande = ModelBook::select($book->get('isbn'))[0];
                $resultAuteur = "";
                $auteurs = ModelAuteur::getBookAuteurs($livreCommande->get('isbn'));

                foreach ($auteurs as $a) {
                    $resultAuteur = $resultAuteur . $a->get('prenomAuteur') . " " . $a->get('nomAuteur') . ", ";
                }
                $resultAuteur = rtrim($resultAuteur, ', ');

                echo '<div class="livre">';

                if (!$livreCommande->get('image')) {
                    echo '<img src="../../ressource/linux.png"/>';
                } else {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($livreCommande->get('image')) . '"/>';
                }

                echo '<div class="bookInfo">';
                echo '<p>Titre : ' . htmlspecialchars($livreCommande->get("titre")) . '</p>';
                echo '<p> Auteurs : ' . htmlspecialchars($resultAuteur) . '</p>';
                echo '<p> Quantite : ' . htmlspecialchars($book->get('quantite')) . '</p>';
                echo '<p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($livreCommande->get('isbn')) . '">' . htmlspecialchars($livreCommande->get('isbn')) . '</a></p>';
                echo '</div>';
                echo '<div class="panier">';
                echo '</div>';
                echo '</div>';
                $prixTotal = $prixTotal + $livreCommande->get('prix') * $book->get('quantite');
            }

            echo '<p>Le prix total de la commande est : ' . htmlspecialchars($prixTotal) . ' €</p>';
            echo '</div>';
        }
    }
}else
{
    echo "<p>Vous n'avez passé aucune commande !</p>";
}
