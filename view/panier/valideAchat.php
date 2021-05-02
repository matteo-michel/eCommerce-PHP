<?php
        $panier = unserialize($_COOKIE['panier'], ["allowed_classes" => true]);
        $testQuantite = true;
        foreach ($panier as $item)
        {
            $quantite = $item->get('quantite');
            $itemQuantite = ModelBook::select($item->get('isbn'))[0]->get('stock');
            if ($quantite > $itemQuantite) {
                echo "<div class='alert alert-danger'>Il n'y pas assez de produit en stock pour le livre de numéro : " . htmlspecialchars($item->get('isbn')) . "</div>";

                $testQuantite = false;
            }

            $isExiste = ModelBook::select($item->get('isbn'))[0]->get('isExiste');
            if ($isExiste == '0') {
                echo "<div class='alert alert-danger'>Le livre de numero : " . htmlspecialchars($item->get('isbn')) . " a été supprimé !</div>";

                $testQuantite = false;
            }
        }
        if ($testQuantite) {
            controllerPanier::acheterPanier_end();
        }
        else {
            echo '<a role="button" class="btn btn-danger" href="index.php?controller=panier&action=readAll">Retour au panier</a>';
        }
