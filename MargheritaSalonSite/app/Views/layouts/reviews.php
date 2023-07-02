<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
            <div class="works-block" style="height: 100%; overflow-y: hidden;">
                <?php if(isset($result)): ?>
                    <?php foreach($result as $row): ?>
                        <div class="rev-block">
                            <h1><?= "Username Cliente: " . $row["C_Username"] ?></h1>
                            <hr>
                            <h1><?= "Username Personale: " . $row["P_Username"] ?></h1>
                            <hr>
                            <h2><span>Data:</span> <?= $row["Data"]?></h2>
                            <h2><span>Ora:</span> <?= $row["Ora"]?></h2>
                            <hr>
                            <div class="rev-stars">
                                <?php for($i = 0; $i < $row["Rating"]; $i++): ?>
                                    <div class="star"><img src="<?php echo base_url();?>assets/logo/star.png" alt="starPng"></div>
                                <?php endfor; ?>
                            </div>
                            <hr>
                            <h2><span>Trattamenti fatti: </span><?= str_replace(",",", ", str_replace(["{", "}", '"'], "", $row["Titoli_Trattamenti"])) ?></h2>
                            <hr>
                            <p>
                                <?= $row["Testo"]?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php elseif(isset($error)): ?>
                    <div style="height:120vh;">
                        <div class="error-box" style=" margin-top: 5px; text-align: center;">
                            <p class="error-message"><?= $error ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>