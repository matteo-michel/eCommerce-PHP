<?php
echo '<div class="home-content">';
foreach ($tab as $u){
    $uLogin = $u->get('login');
    echo '<div class="livre">';
    echo '<div class="bookInfo">';
    echo '<p> Utilisateur de login : <a href="index.php?controller=utilisateur&action=profile&login=' . rawurlencode($uLogin) . '">' . htmlspecialchars($uLogin) . '</a></br>';
    echo '</div>';
    echo '<div class="panier horizontal">';
    if (isset($_SESSION['login']) && $_SESSION['isAdmin'] == '1')
    {
        if (modelUtilisateur::select($uLogin)[0]->get('isAdmin')=='0')
        {
            echo "<a class='btn btn-success' role='button' href=\"index.php?controller=utilisateur&action=promote&login=" . rawurlencode($uLogin) . "\"><i class='fas fa-medal'></i> Promouvoir </a>";
        } else
        {
            echo "<a class='btn btn-secondary' role='button'><i class='fas fa-crown'></i> Admin </a>";
        }

    }
    echo "<a class='btn btn-primary' role='button' href=\"index.php?controller=utilisateur&action=update&login=" . rawurlencode($uLogin) . "\"><i class='fas fa-pen'></i> Modifier</a>";
    echo "<a class='btn btn-danger' role='button' href=\"index.php?controller=utilisateur&action=delete&login=" . rawurlencode($uLogin) . "\"><i class=\"fas fa-times\"></i> Supprimer le compte</a>";
    echo '</div>';
    echo '</div>';
}
    echo '</div>';
