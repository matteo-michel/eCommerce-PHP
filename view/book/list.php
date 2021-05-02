<div class="recherche">
    <form method="post" action="index.php">
        <select name="book" id="book_id">
            <option value="">--Trier les livres--</option>
            <option value="isbn">numéro ISBN</option>
            <option value="titre">Titre</option>
            <option value="prix">Prix</option>
            <option value="dateParution">date de Parution</option>
        </select>
        <input type="text" name="search">
        <input type="submit" value="Rechercher">
    </form>
</div>

<?php
    $order_by = '';
    if (isset($_POST['book']) && $_POST['book'] != '') {
        $order_by = 'ORDER BY ' . $_POST['book'];
        $tab = ModelBook::selectAll($order_by);
    } else if (isset($_POST['search']) && $_POST['search'] != '') {
        $q_array = explode(' ', $_POST['search']);
        $tab = array();
        foreach ($q_array as $q) {
            $listNewBook = ModelBook::getBookByAutors($q);
            if (empty($listNewBook)) echo "Il n’y a aucun résultat pour votre recherche. Vérifiez l’orthographe des mots saisis, complétez-les par un nouveau mot clé ou désactivez les filtres actifs";
            else {
                foreach ($listNewBook as $nb) {
                    $in_array = false;
                    foreach ($tab as $t) {
                        if ($t->get('isbn') == $nb->get('isbn')) $in_array = true;
                    }
                    if (!$in_array) array_push($tab, $nb);
                }
            }
        }
    } else
    {
        $start = 0;
        if(isset($_GET['page'])) {
            $start = 10 * $_GET['page'] - 10;
        }
        $tab = ModelBook::selectAmount($order_by, $start,10);
    }

    echo '<div class="home-content">';
    foreach ($tab as $u) {
        if (ModelBook::select($u->get('isbn'))[0]->get('isExiste') == '1') {
            $bISBN = $u->get('isbn');
            $resultAuteur = "";
            $auteurs = ModelAuteur::getBookAuteurs($bISBN);

            foreach ($auteurs as $a) {
                $resultAuteur = $resultAuteur . '<a href="index.php?controller=auteur&action=read&numAuteur=' . rawurlencode($a->get('numAuteur')) . '">' . htmlspecialchars($a->get('prenomAuteur')) . " " . htmlspecialchars($a->get('nomAuteur')) . '</a>' . ", ";
            }

            $resultAuteur = rtrim($resultAuteur, ', ');

            echo '<div class="livre">';
            if (!$u->get('image')) {
                echo '<img src="../../ressource/linux.png"/>';
            } else {
                echo '<img src="data:image/jpeg;base64,' . base64_encode($u->get('image')) . '"/>';
            }
            echo '  <div class="bookInfo">
                    <p>Titre : ' . htmlspecialchars($u->get("titre")) . '</p>
                    <p> Auteurs : ' . $resultAuteur . '</p>
                    <p> Stock : ' . htmlspecialchars($u->get('stock')) . '</p>
                    <p> Livre de numéro : <a href="index.php?action=read&isbn=' . rawurlencode($bISBN) . '">' . htmlspecialchars($bISBN) . '</a></p>
                    </div>
                    <div class="panier">
                    <p>' . $u->get("prix") . '<sup>€</sup></p>';
            if ($u->get('stock') == 0) {
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
    }
        echo '<div>';
        echo "<ul class=\"pagination text-center\">";
        if ($order_by == '') {

            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 1;
            }

            $realAmount = 0;
            foreach (ModelBook::selectAll('') as $book) ($book->get('isExiste')=='1')?$realAmount+=1:'';
            for ($i = 1; $i <= floor($realAmount / 11) + 1; $i++) {
                if($i == $page)
                    echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"index.php?page=" . $i . "\">$i</a></li>";
                else
                    echo "<li class=\"page-item\"><a class=\"page-link\" href=\"index.php?page=" . $i . "\">$i</a></li>";
            }
        }
        echo "</ul>";
?>
