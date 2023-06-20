<!DOCTYPE html>
<html lang="it">
    <?= view("templates/head", ['title' => $title]) ?>
    <meta http-equiv="refresh" content="3;url=/userdashboard">
	<body>
		<header>
            <div id="logo">
                <a href="/"><img src="assets/logo/Logo.png"></a>
			</div>
        </header>
        <div class="loading-block">
            <p>Attendi... </p>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>