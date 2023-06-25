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
                <form method="post" action="/signup" target="_self">
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
                        <input type="password" name="psw" id="psw" required>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <i class="toggle-password" onclick="togglePassword('psw', 'toogle')" id="toogle">visibility_off</i> 
                    <style>
                        .toggle-password {
                            cursor: pointer;
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            width: 140px;
                            height: 40px;
                            padding: 0 16px;
                            border-radius: 4px;
                            font-size: 18px;
                            font-weight: 500;
                            text-transform: uppercase;
                            text-align: center;
                            background-color: #4CAF50;
                            color: #fff;
                            border: none;
                            transition: background-color 0.3s ease;
                        }
                        .toggle-password:hover {
                            background-color: #3e8e41;
                        }
                    </style>
                    <script>
                        function togglePassword(inputId, inputToggle) {
                            var x = document.getElementById(inputId);
                            var icon = document.getElementById(inputToggle);
                            if (x.type === "password") {
                                x.type = "text";
                                icon.innerHTML = "visibility";
                            } else {
                                x.type = "password";
                                icon.innerHTML = "visibility_off";
                            }
                        }
                    </script>
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