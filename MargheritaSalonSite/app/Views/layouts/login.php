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
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                <?php } ?>
                <form method="post" target="_self" action="/login">
                    <div class="txt_field">
                        <input type="text" name="username" value="<?php if(isset($username)) { echo $username; }?>" required>
                        <span></span>
                        <label>Username o Email</label>
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
                            padding: 0px 16px;
                            border-radius: 4px;
                            font-size: 18px;
                            font-weight: 500;
                            text-transform: uppercase;
                            text-align: center;
                            background-color: #4CAF50;
                            color: #fff;
                            margin-bottom: 15px;
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
                    <div class="forgot_pass"><a href="forgot">Forgot Password?</a></div>
                    <input type="submit" value="Login">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>