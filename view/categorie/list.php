<div class="text-center">
    <a class="btn btn-success" href="index.php?controller=categorie&action=create">Ajouter une categorie</a>
</div>

<?php
echo '<div class="home-content">';
$tab = ModelCategorie::selectAll(';');

foreach ($tab as $t)
{
    echo '<div class="livre">';
    echo '<div class="bookInfo">';
    echo '<p> Categorie : '.htmlspecialchars($t->get('nomCategorie')).'</p>';
    echo '</div>';
    echo '<div class="panier">';
    echo '<a class="btn btn-primary" href="index.php?controller=categorie&action=update&numCategorie='.rawurlencode($t->get('numCategorie')).'"><i class="fas fa-pen"></i> Modifier</a>';
    echo '<a class="btn btn-danger" href="index.php?controller=categorie&action=delete&numCategorie='.rawurlencode($t->get('numCategorie')).'"><i class="fas fa-times"></i> Supprimer</a>';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
echo '</div>';
?>
