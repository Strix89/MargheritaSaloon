<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
        <div class="social-block">
            <div class="social-logo">
                <div class="logo">
                    <img src="assets/contacts/facebook.png" alt="facebook">
                </div>
                <div class="logo">
                    <img src="assets/contacts/instagram.png" alt="instagram">
                </div>
                <div class="logo">
                    <img src="assets/contacts/twitter.png" alt="twitter">
                </div>
            </div>
            <div class="social-text">
                <h1>I nostri contatti</h1>
                <p>Benvenuti nella pagina Contatti del nostro sito web! Siamo lieti di metterci a vostra disposizione per qualsiasi necessità o richiesta di informazioni. Potete contattarci tramite:</p>
                <ul>
                    <li><span style="color: #F0A04B; font-weight: bold;">Telefono</span>: +39 123 456789</li>
                    <li><span style="color: #F0A04B; font-weight: bold;">Email</span>: <a href="mailto:margheritasalon@gmail.com"> margheritasalon@gmail.com</a></li>
                    <li><span style="color: #F0A04B; font-weight: bold;">Telefono</span>: Via dei Fiori 123, 75010 Marconia (MT)</li>
                </ul>
                <p>Siamo aperti dal martedì al sabato dalle 9:00 alle 19:00 e saremo felici di rispondere a qualsiasi domanda riguardo ai nostri servizi e prodotti, prenotazioni, promozioni e prezzi. Non esitate a contattarci anche per consigli sui migliori trattamenti e prodotti per i vostri capelli.Potete inoltre seguirci sui nostri canali social per rimanere sempre aggiornati sulle ultime novità e promozioni del nostro salone:</p>
                <ul>
                    <li><span style="color: #F0A04B; font-weight: bold;">Facebook</span>: @Margherita_Saloon</li>
                    <li><span style="color: #F0A04B; font-weight: bold;">Instagram</span>: @Margh_salonMarcony</li>
                    <li><span style="color: #F0A04B; font-weight: bold;">Twitter</span>: @Margh_salon</li>
                </ul>
                <p>In caso di necessità di assistenza tecnica per il sito web, vi preghiamo di contattare l'account <a href="mailto:margheritasalon@gmail.com">margheritasalon@gmail.com</a>. Siamo sempre pronti ad accogliervi nel nostro salone di famiglia a Marconia, in Basilicata, e a offrirvi i nostri migliori servizi e prodotti. Grazie per averci contattato e a presto!</p>
            </div>        
        </div>
        <?= view("templates/footer") ?>
    </body>
</html>