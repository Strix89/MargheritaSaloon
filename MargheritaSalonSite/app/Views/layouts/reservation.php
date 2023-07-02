<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
            <div class="write-rev-block">
                <div class="write-rev" style="overflow-y:hidden;">
                    <h1>Prenota</h1>
                    <?php if(isset($error)): ?>
                        <hr>
                        <div class="error-box" style=" margin-top: 5px; text-align: center;">
                            <p class="error-message"><?= $error ?></p>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <form method="post" action="/makeresdate" target="_self">
                        <div class="row-data-ora-operatore">
                            <div class="data-rev">
                                <label for="data">Data:</label>
                                <select name="data" style="height: 40px;font-size: 16px;" required>
                                    <?php foreach($date as $data): ?>
                                        <option value="<?= $data ?>"><?= $data ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="orario-rev">
                                <label for="orario">Orario:</label>
                                <select name="ora" style="height: 40px;font-size: 16px;" required>
                                    <?php foreach($orari as $orario): ?>
                                        <option value="<?= $orario ?>"><?= $orario ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="rev-submit" style="margin-top: 40px;">
                            <input type="submit" value="Cerca" style="margin-left: auto; margin-right: auto;">
                        </div>
                    </form>
                </div>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>