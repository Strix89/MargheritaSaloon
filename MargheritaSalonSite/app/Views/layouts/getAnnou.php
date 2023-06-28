<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
        <?= view("templates/header") ?>
        <div class="works-block">
            <?php if(isset($error)): ?>
                <div class="work-block">
                    <div class="error">
                        <h1><?= $error ?></h1>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($result as $annuncio): ?>
                    <div class="work-block">
                        <h1><?= "Annuncio di " . $annuncio["Username"] ?></h1>
                        <hr>
                        <h2><span>Postato in Data:</span> <?= $annuncio['Data'] ?></h2>
                        <hr>
                        <p><?= $annuncio['Testo'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>