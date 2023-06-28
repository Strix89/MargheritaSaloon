<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="login-block">
            <div class="login" style="margin-top: 40px;">
                <h1>Reset Password</h1>
                <?php if(isset($error)) { ?>
                    <div class="error-box">
                        <p class="error-message"><?= $error; ?></p>
                    </div>
                <?php } else if(isset($success)) { ?>
                    <div class="success-box">
                        <p class="success-message"><?= $success; ?></p>
                    </div>
                <?php } ?>
                <form method="post" target="_self" action="/resetpsw" id="rstform">
                <div class="txt_field"> 
                    <input type="password" name="oldpsw" id="oldpsw" required> 
                    <span></span> 
                    <label>Old Password</label> 
                </div> 
                <i class="toggle-password" onclick="togglePassword('oldpsw', 'toogle1')" id="toogle1">visibility_off</i> 
                <div class="txt_field"> 
                    <input type="password" name="newpsw" id="newpsw" required> 
                    <span></span> <label>New Password</label>  
                </div>
                <i class="toggle-password" onclick="togglePassword('newpsw', 'toogle2')" id="toogle2">visibility_off</i>
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
                        <input type="password" name="newrespsw" id="newrespsw" required>
                        <span></span>
                        <label>Retype New Password</label>
                    </div>
                    <input type="submit" value="Cambia Password">
                    <input type="reset" value="Reset">
                </form>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>