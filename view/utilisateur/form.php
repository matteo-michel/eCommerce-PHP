<div class="content">
    <form method="post" action="index.php?controller=utilisateur" class="login">
        <fieldset>
        <legend>Connexion :</legend>
            <div class="form-group">
                <input type='hidden' name='action' value='<?php echo $name ?>'>
                <label for="login_id">Login</label> :
                <input type="text"  name="login" id="login_id" value="<?php echo (isset($user))? rawurlencode($user->get('login')): ''; ?>" class="form-control" required/>
            </div>
            <div class="form-group">
                <label for="password_id">Mot De Passe</label> :
                <input type="password"  name="password" id="password_id" class="form-control" required/>
            </div>
            <div class="loginLink">
                <a href="index.php?controller=utilisateur&action=register">Je n'ai pas de compte</a>
                <a href="index.php?controller=utilisateur&action=forgotPassword">Mot de passe oublié</a>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer <i class="fa fa-paper-plane"></i></button>
            </div>
        </fieldset>
    </form>
</div>