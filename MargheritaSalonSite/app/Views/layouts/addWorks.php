<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body style="height: 100%;">
		<?= view("templates/header") ?>
        <div class="write-rev-block"  style="height: 100%">
            <div class="write-rev" style="overflow-y: hidden; height:100%; margin-bottom: 40px;">
                <h1>Aggiungi Lavoro</h1>
                <?php if(isset($error)): ?>
                    <hr>
                    <div class="error-box" style="margin-top: 5px;">
                        <p class="error-message"><?= $error ?></p>
                    </div>
                <?php endif; ?>
                <hr>
                <form method="post" action="/addworks" target="_self" enctype="multipart/form-data">
                    <div class="row-data-ora-operatore">
                        <div class="nome-rev">
                            <label for="titolo">Titolo:</label>
                            <textarea style="resize:none" name="titolo" id="nomeProdotto-text" cols="15" rows="1" placeholder="Nome"></textarea>
                            </select>
                        </div>
                        <div class="data-rev">
                            <label for="data">Data:</label>
                            <input type="date" id="data" name="data" required>
                        </div>
                    </div>
                    <div class="rev-textarea">
                        <textarea name="descrizione" id="Recensione" cols="50" rows="10" placeholder="Descrizione"></textarea>
                    </div>
                    <div class="rev-submit">
                            <input type="file" id="myFile" multiple accept="image/jpeg" max="3" name="immagine[]" hidden onchange="updateFileName()"/>
                            <label class="chooseFile" for="myFile" style="background-color: rgb(221, 221, 221); text-align:center;">Choose File</label>
                            <label id="filevisualizer"></label>
                            <input type="submit" value="Aggiungi">
                          </form>
                    </div>
                    <script>
                        function updateFileName() {
                            var input = document.getElementById('myFile');
                            var output = document.getElementById('filevisualizer');
                            var numFiles = input.files.length;
                            var fileNames = "";

                            for (var i = 0; i < numFiles; i++) {
                                fileNames += input.files[i].name + " ";
                            }

                            output.textContent = "Numero di file caricati: " + numFiles + " -> " + fileNames;
                            }
                    </script>
                </form>
            </div>
            <?php if(isset($result)): ?>
                    <div class="works-block"  style="height: 100%; border-radius: 20px;">
                    <?php foreach($result as $row): ?>
                        <div class="work-block">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <h1 style="margin: 0 auto;"><?= $row["Titolo"]?></h1>
                                <a href="<?php echo base_url() . "/deletework/" . $row["ID"]; ?>" style="color: #fff; background-color: #f44336; padding: 10px 15px; border-radius: 5px; text-decoration: none;" onmouseover="this.style.backgroundColor='#d32f2f'" onmouseout="this.style.backgroundColor='#f44336'">Elimina</a>
                            </div>
                            <hr style="margin: 10px 0;">
                            <h2><span>Data:</span> <?= $row["Data"]?></h2>
                            <h2><span>Lavoro di:</span> <?= $row["Username"]?></h2>
                            <hr>
                            <div class="works-images">
                                <?php $row["NomiImmagini"] = str_replace(["{", "}"], "", $row["NomiImmagini"]); ?>
                                <?php foreach(explode(",", $row["NomiImmagini"]) as $image): ?>
                                    <div class="work-image">
                                        <img src="<?php echo base_url();?>assets/works/<?= $row["ID"] . "_" . $image . ".jpg"; ?>" alt="product_<?= array_search($image, explode(",", $row["NomiImmagini"])); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                            <p>
                                <?= $row["Descrizione"]?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                    </div>
            <?php endif; ?>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>