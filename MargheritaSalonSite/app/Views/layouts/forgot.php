<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<header>
            <div id="logo">
                <a href="/"><img src="assets/logo/Logo.png"></a>
			</div>
        </header>
        <div class="login-block">
            <div class="login">
                <h1>Oh no!</h1>
                <form method="post" target="#">
                    <div class="txt_field">
                        <input type="email" placeholder="Email Registrazione" required>
                        <span></span>
                    </div>
                    <p>Controlla la tua casella di posta dopo averci inviato la tua email.</p>
                    <input type="submit" value="Cerca">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
       <?= view("templates/footer") ?>
    </body>
</html>