<div class="content">
    <form method="post" action="index.php?controller=utilisateur" class="login">
        <fieldset>
            <legend>Mot de passe oublié :</legend>
            <div class="form-group">
                <input type='hidden' name='action' value='<?php echo $name ?>'>
                <label for="login">Login</label> :
                <input type="text" name="login" id="login" class="form-control" required/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div><?php
