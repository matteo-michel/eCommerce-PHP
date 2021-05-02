<div class="text-center">
    <a class="btn btn-success" href="index.php?controller=auteur&action=create">Ajouter un auteur</a>
</div>
<?php
echo '<div class="home-content">';
$tab = ModelAuteur::selectAll(';');

foreach ($tab as $t)
{
    echo '<div class="livre">';
    echo '<div class="bookInfo">';
    echo '<p> Auteur : '.htmlspecialchars($t->get('nomAuteur')).' '.htmlspecialchars($t->get('prenomAuteur')).'</p>';
    echo '</div>';
    echo '<div class="panier">';
    echo '<a class="btn btn-primary" href="index.php?controller=auteur&action=update&numAuteur='.rawurlencode($t->get('numAuteur')).'"><i class="fas fa-pen"></i> Modifier</a>';
    echo '<a class="btn btn-danger" href="index.php?controller=auteur&action=delete&numAuteur='.rawurlencode($t->get('numAuteur')).'"><i class="fas fa-times"></i> Supprimer</a>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';
?>