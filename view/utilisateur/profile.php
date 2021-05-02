<?php
$user = modelUtilisateur::select($login)[0];
($user->get('isAdmin') == 1)? $admin = 'Administrateur': $admin = 'Utilisateur';
($testAdmin)? $pronom = 'le': $pronom = 'mon';

$updatePassword = '';
if($login == $_SESSION['login']) {
    $updatePassword = '<div class="text-center updatePassword">
                                <a role="button" class="btn btn-success" href="index.php?controller=utilisateur&action=updatePassword">Modifier le mot de passe</a>
                            </div>';
}

echo '
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="d-flex justify-content-center">
            <div class="col-xl-6 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25"> <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image"> </div>
                                <h6 class="f-w-600">' . htmlspecialchars($user->get('prenom')) . ' ' . htmlspecialchars($user->get('nom')) . '</h6>
                                <p>' . $admin . '</p>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="card-block">
                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Email</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars(strtolower($user->get('email'))) . '</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="m-b-10 f-w-600">Login</p>
                                        <h6 class="text-muted f-w-400">' . htmlspecialchars(strtolower($user->get('login'))) . '</h6>
                                    </div>
                                </div>
                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Modifications</h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a role="button" class="btn btn-primary" href="index.php?controller=utilisateur&action=update">Modifier ' . $pronom . ' profil</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a role="button" class="btn btn-danger" href="index.php?controller=utilisateur&action=delete&login=' . htmlspecialchars($user->get('login')) . '">Supprimer ' . $pronom . ' profil</a>
                                    </div>
                                </div>
                            </div>' .
                            $updatePassword . '
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
?>
