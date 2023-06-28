<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="write-rev-block" style="height: 180vh;">
            <div class="write-rev"  style="overflow-y: hidden; height: 700px; margin-bottom: 40px;">
                <h1>Nuovo Annuncio</h1>
                <hr>
                <?php if(isset($error)) { ?>
                    <div class="error-box" style="margin-top: 5px;">
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                    <hr>
                <?php } else if(isset($success)) { ?>
                    <div class="success-box" style="margin-top: 5px;">
                        <p class="success-message"><?= $success; ?></p>
                    </div>
                    <hr>
                <?php } ?>
                <form method="post" action="/postannouncements" target="_self">
                    <div class="rev-textarea">
                        <textarea name="annuncio" cols="50" rows="30" placeholder="Descrizione"></textarea>
                    </div>
                    <div class="rev-submit">
                            <input type="submit" value="Posta">
                            <input type="reset" value="Cancella">
                    </div>
                </form>
            </div>
                <?php if(isset($result)): ?>
                    <div class="works-block" style="border: 3px solid black; border-radius: 20px;">
                    <?php foreach ($result as $annuncio): ?>
                        <div class="work-block">
                            <h1><?= "Annuncio di " . $annuncio["Username"] ?></h1>
                            <hr>
                            <h2><span>Postato in Data:</span> <?= $annuncio['Data'] ?></h2>
                            <hr>
                            <p><?= $annuncio['Testo'] ?></p>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>