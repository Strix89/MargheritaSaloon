<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body style="height: 100%;">
        <?= view("templates/header") ?>
        <div class="write-rev-block" style="height: 100%">
            <div class="write-rev" style="overflow-y: hidden; height: 100%; margin-bottom: 40px;">
                <h1 style="text-align: center; margin-bottom: 20px;">Aggiungi Trattamento</h1>
                <?php if(isset($error)): ?>
                    <hr>
                    <div class="error-box" style="margin-top: 5px;">
                        <p class="error-message"><?= $error ?></p>
                    </div>
                <?php endif; ?>
                <hr>
                <form method="post" action="/treatments" target="_self">
                    <div class="titolo-rev">
                            <label for="Titolo">Titolo:</label>
                            <textarea style="resize:none;" name="titolo" id="nomeTratement-text" cols="15" rows="1" placeholder="Titolo"></textarea>
                    </div>
                    <div class="row-data-ora-operatore">
                        <div class="prezzo-rev">
                            <label for="prezzo">Prezzo:</label>
                            <input type="number" min="0" step="0.01" style="width: 50%; padding: 5px; margin-left: 5px;margin-right:10px;" name="prezzo" id="prezzo" placeholder="Valore"> €
                        </div>
                        <div class="surplus-rev">
                        <label for="surplus">Surplus:</label>
                            <input type="number" min="0" step="0.01" style="width: 50%; padding: 5px; margin-left: 5px;" name="surplus" id="surplus" placeholder="Valore"> €
                        </div>
                    </div>
                    <div class="durata-rev">
                        <label for="durata">Durata:</label>
                        <input type="number" min="30" style="width: 40%; padding: 5px; margin-right: 5px;" name="durata" id="durata" placeholder="Durata"> Minuti
                    </div>
                    <div>
                        <label for="descrizione" style="display: block; margin-bottom: 5px;">Descrizione:</label>
                        <textarea style="width: 100%; padding: 5px;" name="descrizione" id="descrizione" cols="50" rows="5" placeholder="Descrizione"></textarea>
                    </div>
                    <div class="rev-submit">
                            <input type="submit" value="Aggiungi">
                            <input type="reset" value="Cancella">
                    </div>
                </form>
            </div>
            <?php if(isset($result)): ?>
            <div class="table-container" style="height: 60vh; overflow-y: scroll; border-radius: 10px;">
                <table style="border-collapse: collapse; width: 100%;">
                    <thead>
                        <tr style="background-color: #4CAF50; color: white;">
                            <th style="padding: 10px; border: 1px solid #ddd;">Titolo</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Prezzo</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Surplus</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Durata</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Descrizione</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Inserito da</th>
                            <th style="padding: 10px; border: 1px solid #ddd;">Elimina</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $sium): ?>
                            <tr style="background-color: #f2f2f2;">
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Titolo'] ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Prezzo'] ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Surplus'] ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Durata'] ?> minuti</td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Descrizione'] ?></td>
                                <td style="padding: 10px; border: 1px solid #ddd;"><?= $sium['Username'] ?></td>
                                <td style="padding: 10px; border: 1px solid#ddd;text-align: center;"><a href="/rmtreatments/<?= $sium['ID']?>" style="color: red;text-decoration:none;">X</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>