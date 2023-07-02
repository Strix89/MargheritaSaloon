<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="panel-block">
            <div class="user-actions">
                <?php if(session("user")["Tipologia"] === "t"): ?>
                    <button class="action"><a href="/reviews">RECENSIONI</a></button>
                    <button class="action"><a href="/addworks">LAVORI</a></button>
                    <button class="action"><a href="/postannouncements">ANNUNCI</a></button>
                    <button class="action"><a href="/addproducts">PRODOTTI</a></button>
                    <button class="action"><a href="/personalcalendar">CALENDARIO PERSONALE</a></button>
                    <button class="action"><a href="/saloncalendar">CALENDARIO DEL SALONE</a></button>
                    <button class="action"><a href="/treatments">TRATTAMENTI</a></button>
                    <button class="action"><a href="/resetpsw">RESETTA LA PASSWORD</a></button>
                    <button class="action"><a href="/logout">LOGOUT</a></button>
                <?php else: ?>
                    <button class="action"><a href="/works">VEDI LAVORI</a></button>
                    <button class="action"><a href="/products">VEDI PRODOTTI</a></button>
                    <button class="action"><a href="/reviews">VEDI RECENSIONI</a></button>
                    <button class="action"><a href="/getannouncements">ANNUNCI</a></button>
                    <button class="action"><a href="/writerev">SCRIVI UNA RECENSIONE</a></button>
                    <button class="action"><a href="/saloncalendar">CALENDARIO DEL SALONE</a></button>
                    <button class="action"><a href="/makeresdate">EFFETTUA UNA PRENOTAZIONE</a></button>
                    <button class="action"><a href="/resetpsw">RESETTA LA PASSWORD</a></button>
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
                <?php if(session("user")["Tipologia"] === "t"): ?>
                    <p id="visitors">
                        Numero di visitatori dall'apertura del sito: <?= $visitors ?><br>
                        Numero di visitatori loggati adesso sul sito: <?= $logged_users ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>