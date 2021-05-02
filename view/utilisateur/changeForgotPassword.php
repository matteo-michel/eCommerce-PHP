<div class="content">
    <form method="post" action="index.php?controller=utilisateur" class="login">
        <fieldset>
        <legend>Changer de Mot de Passe :</legend>
            <div class="form-group">
                <input type='hidden' name='action' value='<?php echo $name ?>'>
                <input type='hidden' name='login' value='<?php echo $user->get('login') ?>'>
            </div>
            <div class="form-group">
                <label for="new_password">Nouveau Mot De Passe</label> :
                <input type="password" name="new_password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Le mot de passe doit contenir au moins 8 caractères,
            une lettre majuscule, minuscule et un chiffre" id="new_password" class="form-control" required/>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div>