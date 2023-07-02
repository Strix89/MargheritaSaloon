<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
            <div class="write-rev-block" style="<?= isset($error) ? "height:120vh" : "height:100%;" ?>">
                <?php if(isset($result) and count($result) > 0): ?>
                    <div class="write-rev" style="overflow-y:hidden; height: 100%;">
                    <h1>Raccontaci!</h1>
                    <?php if(isset($error1)): ?>
                        <hr>
                        <div class="error-box" style=" margin-top: 5px; text-align: center;">
                            <p class="error-message"><?= $error1 ?></p>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <form method="post" action="/writerev" target="_self">
                        <div class="rev-pren">
                            <label for="Prenotazione">Scegli la prenotazione di cui vuoi scrivere la recensione: </label>
                            <select id="sceltaPren" name="prenotazione">
                                <?php foreach($result as $row): ?>
                                    <option value="<?= $row["Data_P"] . "|" . $row["Ora_P"] ?>"><?= $row["Data_P"] . " - " . $row["Ora_P"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="stars-rev">
                            <div class="rating">
                                <input type='radio' hidden name='rate' value="5" id='rating-opt5' data-idx='0'>	
                                <label for='rating-opt5'><span>Very satisfied</span></label>
                        
                                <input type='radio' hidden name='rate' value="4" id='rating-opt4' data-idx='1'>
                                <label for='rating-opt4'><span>Somewhat satisfied</span></label>
                        
                                <input type='radio' hidden name='rate' value="3" id='rating-opt3' data-idx='2' checked>
                                <label for='rating-opt3'><span>Neutral</span></label>
                        
                                <input type='radio' hidden name='rate' value="2" id='rating-opt2' data-idx='3'>
                                <label for='rating-opt2'><span>Dissatisfied</span></label>
                        
                                <input type='radio' hidden name='rate' value="1" id='rating-opt1' data-idx='4'>
                                <label for='rating-opt1'><span>Very Dissatisfied</span></label>
                            </div>
                        </div>
                        <div class="rev-textarea">
                            <textarea name="recensione" id="Recensione" cols="50" rows="10" placeholder="Scrivi qui la tua recensione"></textarea>
                        </div>
                        <div class="rev-submit">
                            <input type="submit" value="Invia Recensione">
                            <input type="reset" value="Reset">
                        </div>
                    </form>
                <?php else: ?>
                        <div class="error-box" style=" margin-top: 5px; text-align: center;">
                            <p class="error-message"><?= $error ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>