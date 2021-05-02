<form method="post" action="index.php?controller=editeur" class="login">
    <fieldset>
        <legend>Ajouter un Editeur :</legend>
        <div class="form-group">
            <input type='hidden' name='action' value='<?php echo $name ?>'>
            <input type='hidden' name='numEditeur' value='<?php echo $numEditeur ?>'>

            <label for="nomEditeur_id">Nom éditeur</label> :
            <input type="text"  name="nomEditeur" value = "<?php echo isset($editeur)? htmlspecialchars($editeur->get('nomEditeur')):'' ; ?>"id="nomEditeur_id" required/>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
    </fieldset>
</form>
