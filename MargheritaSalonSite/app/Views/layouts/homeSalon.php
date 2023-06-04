<!DOCTYPE html>
<html lang="it">
    <?= view("templates/head", ['title' => $title]) ?>
	<body>
        <?= view("templates/header") ?>
        <?= view("templates/slides") ?>
        <?= view("templates/randomWorks", ["works_images" => $works_images]) ?>
        <?= view("templates/randomProducts", ['product_images' => $product_images]) ?>
        <?= view("templates/randomRew", ['reviews' => $reviews]) ?>
        <?= view("templates/footer.php"); ?>
    </body>
</html>