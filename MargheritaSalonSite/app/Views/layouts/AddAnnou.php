<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="write-rev-block">
            <div class="write-rev"  style="overflow-y: hidden; height: 90vh">
                <h1>Nuovo Annuncio</h1>
                <hr>
                <?php if(isset($error)) { ?>
                    <div class="error-box">
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                    <hr>
                <?php } else if(isset($success)) { ?>
                    <div class="success-box">
                        <p class="success-message"><?= $success; ?></p>
                    </div>
                    <hr>
                <?php } ?>
                <form method="post" action="/announcements" target="_self">
                    <div class="rev-textarea">
                        <textarea name="annuncio" cols="50" rows="30" placeholder="Descrizione"></textarea>
                    </div>
                    <div class="rev-submit">
                            <input type="submit" value="Posta">
                            <input type="reset" value="Cancella">
                    </div>
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>