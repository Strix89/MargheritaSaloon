<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="register-block">
            <div class="register">
                <h1>SignUp</h1>
                <form method="post" target="#">
                    <div class="txt_field">
                        <input type="text" required>
                        <span></span>
                        <label>Nome</label>
                    </div>
                    <div class="txt_field">
                        <input type="text" required>
                        <span></span>
                        <label>Cognome</label>
                    </div>
                    <div class="txt_field">
                        <input type="text" required>
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="txt_field">
                        <input type="tel" maxlength="10" required>
                        <span></span>
                        <label>Cellulare (MAX: 10 Cifre)</label>
                    </div>
                    <div class="txt_field">
                        <input type="email" placeholder="Email" required>
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="password" required>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <input type="submit" value="Register">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>