<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="register-block">
            <div class="register">
                <h1>SignUp</h1>
                <?php if(isset($error)) { ?>
                    <div class="error-box">
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                <?php } ?>
                <form method="post" action="signup" target="_self">
                    <div class="txt_field">
                        <input type="text" name="name" value="<?php if(isset($name)) { echo $name; }?>" required>
                        <span></span>
                        <label>Nome</label>
                    </div>
                    <div class="txt_field">
                        <input type="text" name="surname" value="<?php if(isset($surname)) { echo $surname; }?>" required>
                        <span></span>
                        <label>Cognome</label>
                    </div>
                    <div class="txt_field">
                        <input type="text" name="username" value="<?php if(isset($username)) { echo $username; }?>" required>
                        <span></span>
                        <label>Username</label>
                    </div>
                    <div class="txt_field">
                        <input type="tel" name="phone" maxlength="10" value="<?php if(isset($phone)) { echo $phone; }?>" required>
                        <span></span>
                        <label>Cellulare (MAX: 10 Cifre)</label>
                    </div>
                    <div class="txt_field">
                        <input type="email" name="email" placeholder="Email" value="<?php if(isset($email)) { echo $email; }?>" required>
                        <span></span>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="psw" required>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <div class="txt_field">
                        <input type="password" name="psw_confirm" required>
                        <span></span>
                        <label>Confirm Password</label>
                    </div>
                    <input type="submit" value="Register">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>