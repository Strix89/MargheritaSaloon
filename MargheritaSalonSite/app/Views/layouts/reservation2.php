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
                    <form method="post" action="/makeres" target="_self">
                        <div class="row-data-ora-operatore">
                            <div class="data-rev">
                                <label for="data">Data:</label>
                                <select name="data" style="height: 40px;font-size: 16px;" required>
                                        <option value="<?= $data ?>"><?= $data ?></option>
                                </select>
                            </div>
                            <div class="orario-rev">
                                <label for="orario">Orario:</label>
                                <select name="ora" style="height: 40px;font-size: 16px;" required>
                                    <option value="<?= $ora ?>"><?= $ora ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row-data-ora-operatore">
                            <div class="trattamento-rev">
                                <label for="trattamento" style="display: block; margin-bottom: 8px;">Trattamento:</label>
                                <select id="trattamento-option" name="trattamento[]" multiple size="3" style="display: block; width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                                    <?php foreach($treatments as $treatment): ?>
                                        <option value="<?= $treatment["ID"] ?>" style="padding: 8px; background-color: #f9f9f9;"><?php echo $treatment["Titolo"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="operatore-rev">
                                <label for="operatore">Operatore:</label>
                                <select id="operatore-option" name="operatore" required>
                                    <?php foreach($users as $user): ?>
                                        <option value="<?= $user["Telefono"] ?>"><?= $user["Username"] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="rev-submit" style="margin-top: 40px;">
                            <input type="submit" value="Prenota">
                            <a href="/makeresdate" style="padding: 10px 20px; background-color: #ddd;
                         border: 3px solid black; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; text-decoration: 
                         none; color: #333;">Torna a scegliere gli orari</a>
                        </div>
                    </form>
                </div>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>