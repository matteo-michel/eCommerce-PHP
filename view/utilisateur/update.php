<form method="post" action="index.php?controller=utilisateur" class="login">
<fieldset>
<legend>Modifer Mon profil :</legend>
    <label for="login_id">Login</label> :
    <div class="form-group">
        <input type='hidden' name='action' value='<?php echo $name ?>'>
        <input type="text"  name="login" id="login_id" class="form-control" value = "<?php echo (isset($user))?rawurlencode($user->get('login')):''; ?>" required <?php echo (!isset($create))?"readonly":''; ?>/>
    </div>
    <?php
        if(isset($create)) {
            echo '<div class="form-group">
                    <label for="password_id">Mot De Passe</label> :
                    <input type="password"  name="password" id="password_id" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères,
                    une lettre majuscule, minuscule et un chiffre" class="form-control" required/>
                </div>';
        }
    ?>
    <div class="form-group">
        <label for="prenom_id">Prenom</label> :
        <input type="text"  name="prenom" id="prenom_id" class="form-control" value = "<?php echo (isset($user))?htmlspecialchars($user->get('prenom')):''; ?>" required/>
    </div>

    <div class="form-group">
        <label for="nom_id">Nom</label> :
        <input type="text"  name="nom" id="nom_id" class="form-control" value = "<?php echo (isset($user))?htmlspecialchars($user->get('nom')):''; ?>" required/>
    </div>

    <div class="form-group">
        <label for="email_id">Email</label> :
        <input type="email"  name="email" id="email_id" class="form-control" value = "<?php echo(isset($user))? htmlspecialchars($user->get('email')):''; ?>" required/>
    </div>
    <div class="text-center">
        <input type="submit" class="btn btn-success" value="Envoyer" />
    </div>
</fieldset> 
</form>

