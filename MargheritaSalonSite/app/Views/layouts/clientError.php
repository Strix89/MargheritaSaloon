<?php header("HTTP/1.0 404 Not Found"); ?>
<!DOCTYPE html>
<html lang="it">
    <?= view("templates/head", ['title' => $title]) ?>
	<body>
		<header>
            <div id="logo">
                <a href="/"><img src="<?php echo base_url();?>assets/logo/logo.png"></a>
			</div>
        </header>
        <div class="error-block">
            <p>! Error 404</p>
            <div class="error-image">
                <img src="<?php echo base_url();?>assets/error/error.png" alt="errorImage">
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>