<div class="text-center">
    <a class="btn btn-success" href="index.php?controller=editeur&action=create">Ajouter un editeur</a>
</div>
<?php
echo '<div class="home-content">';
$tab = ModelEditeur::selectAll(';');

foreach ($tab as $t)
{
    echo '<div class="livre">';
    echo '<div class="bookInfo">';
    echo '<p> Editeur : '.htmlspecialchars($t->get('nomEditeur')).'</p>';
    echo '</div>';
    echo '<div class="panier">';
    echo '<a class="btn btn-primary" href="index.php?controller=editeur&action=update&numEditeur='.rawurlencode($t->get('numEditeur')).'"><i class="fas fa-pen"></i> Modifier</a>';
    echo '<a class="btn btn-danger" href="index.php?controller=editeur&action=delete&numEditeur='.rawurlencode($t->get('numEditeur')).'"><i class="fas fa-times"></i> Supprimer</a>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';
?>

