<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
            <div class="works-block" style="height:100%;<?php if(isset($error)) { echo "height: 110vh;";}?>">
                <?php if(!isset($error)): ?>
                <?php foreach($result as $row): ?>
                    <div class="work-block">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h1 style="margin: 0 auto;"><?= $row["Nome"]?></h1>
                        </div>
                        <hr style="margin: 10px 0;">
                        <h2><span>Prezzo:</span> <?= $row["Prezzo"]?></h2>
                        <hr>
                        <div class="works-images">
                            <?php $row["NomiImmagini"] = str_replace(["{", "}"], "", $row["NomiImmagini"]); ?>
                            <?php foreach(explode(",", $row["NomiImmagini"]) as $image): ?>
                                <div class="work-image">
                                    <img src="<?php echo base_url();?>assets/products/<?= $row["ID"] . "_" . $image . ".jpg"; ?>" alt="product_<?= array_search($image, explode(",", $row["NomiImmagini"])); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <hr>
                        <p>
                            <?= $row["Descrizione"]?>
                        </p>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="error-box" style="margin-top: 5px; text-align: center;">
                    <p class="error-message"><?= $error ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>