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
                <?php if(isset($error)) { ?>
                    <div class="error-box">
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                <?php } else if(isset($success)) {?>
                    <div class="success-box">
                        <p class="success-message"><?= $success; ?></p>
                    </div>
                <?php } ?>
                <form method="post" target="_self"  action="/forgotpass">
                    <div class="txt_field">
                        <input type="email" placeholder="Email Registrazione" name="email" required>
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