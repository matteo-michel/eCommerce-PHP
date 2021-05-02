<form method="post" action="index.php?controller=auteur" class="login">
    <fieldset>
        <legend>Ajouter un Auteur :</legend>
        <div class="form-group">
            <input type='hidden' name='action' value='<?php echo $name ?>'>
            <input type='hidden' name='numAuteur' value='<?php echo $numAuteur ?>'>
        </div>
        <div class="form-group">
            <label for="prenomAuteur_id">Prénom auteur</label> :
            <input type="text"  name="prenomAuteur" value = "<?php echo isset($auteur)? htmlspecialchars($auteur->get('prenomAuteur')):'' ; ?>" id="prenomAuteur_id" required/>
        </div>
        <div class="form-group">
            <label for="nomAuteur_id">Nom auteur</label> :
            <input type="text"  name="nomAuteur" value = "<?php echo isset($auteur)? htmlspecialchars($auteur->get('nomAuteur')): '' ; ?>" id="nomAuteur_id" required/>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Envoyer</button>
        </div>
    </fieldset>
</form>
