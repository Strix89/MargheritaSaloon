<header>
			<div class="left-bar">
				<a href="/info">Informazioni</a>
				<a href="/contacts">Contatti</a>
			</div>
            <div id="logo">
                <a href="/"><img src="assets/logo/Logo.png"></a>
			</div>
			<div class="right-bar">
				<?php if(null === session('user')): ?>
                	<button class="btnuser"><a href="/login">Login</a></button>
                	<button class="btnuser"><a href="/signup">Sign Up</a></button>
				<?php else: ?>
					<button class="btnuser" id="userpanel"><a href="/userdashboard"><?= session('user')["Username"] ?></a></button>
				<?php endif; ?>
			</div>
</header>