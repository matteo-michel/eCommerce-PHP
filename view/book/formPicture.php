<div class="content">
    <form method="post" action="index.php" class="login" id="register" enctype="multipart/form-data">
        <fieldset>
            <legend>Modifier l'image :</legend>
            <div class="form-group">
                <input type='hidden' name='action' value='<?php echo $name ?>'>
                <input type='hidden' name='isbn' value='<?php echo $book->get('isbn') ?>'>
            </div>
            <div class="form-group">
                <label>Ancienne image </label> :
                <img src="data:image/jpeg;base64,<?php echo base64_encode($book->get('image')) ?>"/>
            </div>
            <div class="form-group">
            <label for="newImage">Nouvelle Image</label> :
            <input type="file" class="" name = "newImage" accept=".jpeg, .jpg" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </fieldset>
    </form>
</div>