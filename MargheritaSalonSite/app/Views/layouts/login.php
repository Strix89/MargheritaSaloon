<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="login-block">
            <div class="login">
                <h1>Login</h1>
                <?php if(isset($error)) { ?>
                    <div class="error-box">
                        <p class="error-message"><?= $error ?></p>
                    </div>
                <?php } ?>
                <form method="post" target="_self" action="login">
                    <div class="txt_field">
                        <input type="text" name="username" value=" <?php if(isset($username)) { echo $username; } ?>" required>
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="psw" value=" <?php if(isset($password)) { echo $password; } ?>" required>
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