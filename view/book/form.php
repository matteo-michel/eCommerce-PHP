<div class="content">
    <form method="post" action="index.php" class="login" id="register" enctype="multipart/form-data">
        <fieldset>
            <legend>Ajouter un livre :</legend>
            <div class="form-group">
                <input type='hidden' name='action' value='<?php echo $name ?>'>
            </div>
            <div class="form-group">
                <label for="isbn_id">ISBN</label> :
                <input type="text" value="<?php echo $isbn?>" name="isbn" id="isbn_id" required <?php echo $type?>/>
            </div>
            <div class="form-group">
                <label for="titre_id">Titre</label> :
                <input type="text" class="form-control" value = "<?php echo isset($book)? htmlspecialchars($book->get('titre')):'' ; ?>" name="titre" id="titre_id" required/>
            </div>
            <div class="form-group">
                <label for="stock_id">Stock</label> :
                <input type="number" value = "<?php echo isset($book)? htmlspecialchars($book->get('stock')):'' ; ?>" name="stock" id="stock_id" required/>
            </div>
            <div class="form-group">
                <label for="numEditeur_id">Nom Editeur</label> :
                <select name="numEditeur" id="numEditeur_id" required>
                    <?php
                    $listEditeur = ModelEditeur::selectAll(";");
                    foreach ($listEditeur as $item) {
                            $selected = '';
                            if (isset($book) && $item->get('numEditeur')== $book->get('numEditeur')){
                                $selected = "selected";
                            }
                            echo "<option value=\"" . $item->get('numEditeur') . "\" $selected>" . htmlspecialchars($item->get('nomEditeur')) . "</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="numAuteur_id">Nom Auteur</label> :
                <select class="custom-select" name="numAuteur[]" id="numAuteur_id" multiple required>
                    <?php
                    $listAuteur = ModelAuteur::selectAll(";");
                    if (isset($book)){
                        $listBookAuteur = ModelAuteur::getBookAuteurs($book->get('isbn'));
                    }
                    foreach ($listAuteur as $item) {
                        $selected = '';
                        if (isset($listBookAuteur))
                        {
                            foreach ($listBookAuteur as $lBAuteur)
                            {
                                if ($lBAuteur->get('numAuteur') == $item->get('numAuteur')) $selected = "selected";
                            }
                        }
                        echo "<option value=\"" . $item->get('numAuteur') . "\" $selected>" . htmlspecialchars($item->get('prenomAuteur')) . " ". htmlspecialchars($item->get('nomAuteur')) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="categorie_id">Categorie</label> :
                <select name="numCategorie[]" class="custom-select" id="categorie_id" multiple required>
                    <?php
                    $listCategorie = ModelCategorie::selectAll(";");
                    if (isset($book)){
                        $listBookCategorie = ModelBookCategorie::select($book->get('isbn'));
                    }
                    foreach ($listCategorie as $item) {
                        $selected = '';
                        if (isset($listBookCategorie))
                        {
                            foreach ($listBookCategorie as $lBCategorie)
                            {
                                if ($lBCategorie->get('numCategorie') == $item->get('numCategorie')) $selected = "selected";
                            }
                        }
                        echo "<option value=\"" . htmlspecialchars($item->get('numCategorie')) . "\" $selected>" . htmlspecialchars($item->get('nomCategorie')) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prix_id">Prix</label> :
                <input type="number" name="prix" value = "<?php echo isset($book)? htmlspecialchars($book->get('prix')):'' ; ?>" id="prix_id" required/>
            </div>
            <div class="form-group">
                <label for="date_id">Date de Parution</label> :
                <input type="date" name="date" value = "<?php echo isset($book)? htmlspecialchars($book->get('dateParution')):'' ;?>" id="date_id" required/>
            </div>
            <div class="form-group">
                <label for="resume_id">Resumé</label> :
                <textarea id="resume_id" class="form-control" name = "resume" rows="3" cols="50" maxlength="1024"> <?php echo isset($book)? htmlspecialchars($book->get('resume')):'';?></textarea>
            </div>
            <?php if (!isset($book) || isset($erreur))
            {
                echo '<div class="form-group">
                    <label for="image">Image</label> :
                    <input type="file" class="" name = "image" accept=".jpeg, .jpg" required>
                    </div>';

            }
            ?>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div>