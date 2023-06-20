<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="panel-block">
            <div class="user-actions">
                <?php if(session("user")["Tipologia"] == true): ?>
                    <button class="action"><a href="./addWork.html">LAVORI</a></button>
                    <button class="action"><a href="./addAds.html">ANNUNCI</a></button>
                    <button class="action"><a href="./addProduct.html">PRODOTTI</a></button>
                    <button class="action"><a href="./personalCalendar.html">CALENDARIO PERSONALE</a></button>
                    <button class="action"><a href="./salonCalendar.html">CALENDARIO DEL SALONE</a></button>
                    <button class="action"><a href="./addTratement.html">TRATTAMENTI DEL SALONE</a></button>
                    <button class="action"><a href="./resetPwd.html">RESETTA LA PASSWORD</a></button>
                    <button class="action"><a href="/logout">LOGOUT</a></button>
                <?php else: ?>
                    <button class="action"><a href="./worksPage.html">VEDI LAVORI DEL SALON</a></button>
                    <button class="action"><a href="./productsPage.html">VEDI PRODOTTI DEL SALON</a></button>
                    <button class="action"><a href="./reviewsPage.html">VEDI RECENSIONI</a></button>
                    <button class="action"><a href="./annunciPage.html">ANNUNCI</a></button>
                    <button class="action"><a href="./writeRev.html">SCRIVI UNA RECENSIONE</a></button>
                    <button class="action"><a href="./salonCalendar.html">CALENDARIO DEL SALONE</a></button>
                    <button class="action"><a href="./makeRes.html">EFFETTUA UNA PRENOTAZIONE</a></button>
                    <button class="action"><a href="./resetPwd.html">RESETTA LA PASSWORD</a></button>
                    <button class="action"><a href="/logout">LOGOUT</a></button>
                <?php endif; ?>
            </div>
            <div class="user-info">
                <h1>Ciao <?= session("user")["Nome"] . " ". session("user")["Cognome"]; ?></h1>
                <p>
                    <span>Email:</span> <?= session("user")["Email"]; ?><br>
                    <span>Telefono:</span> <?= session("user")["Telefono"]; ?><br>
                    <span>Username:</span> <?= session("user")["Username"]; ?>
                </p>
                <?php if(session("user")["Tipologia"] == true): ?>
                    <p id="visitors">
                        Numero di visitatori dall'apertura del sito: XXXX<br>
                        Numero di visitatori attivi adesso sul sito: XXXX
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>