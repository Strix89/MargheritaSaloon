<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="login-block">
            <div class="login">
                <h1>Login</h1>
                <form method="post" target="#">
                    <div class="txt_field">
                        <input type="text" required>
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" required>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <div class="forgot_pass"><a href="forgot">Forgot Password?</a></div>
                    <input type="submit" value="Login">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>