<!DOCTYPE html>
<html lang="it">
	<?= view("templates/head", ['title' => $title]) ?>
	<body>
		<?= view("templates/header") ?>
            <div class="salon-calendar-block">
                <?php if(isset($result)): ?>
                    <div class="calendar">
                        <?php foreach($result as $row): ?>
                            <div class="book">
                                <h2><span>Data Prenotazione: </span><?= $row["Data_P"]; ?></h2>
                                <h2><span>Ora Prenotazione: </span><?= $row["Ora_P"]; ?></h2>
                                <hr>
                                <p><span>Username Cliente: </span><?= $row["Cliente_Username"]; ?></p>
                                <p><span>Username Personale: </span><?= $row["Personale_Username"]; ?></p>
                                <hr>
                                <h2>Trattamenti Richiesti:</h2> 
                                <ul>
                                    <?php $row["Titoli"] = str_replace(["{", "}", '"'], "", $row["Titoli"]); 
                                          $row["Durate"] = str_replace(["{", "}", '"'], "", $row["Durate"]);
                                          $row["Titoli"] = explode(",", $row["Titoli"]);
                                          $row["Durate"] = explode(",", $row["Durate"]);
                                    ?>
                                    <?php if(is_array($row["Titoli"])): ?>
                                        <?php $info = array_combine($row["Titoli"], $row["Durate"]); ?>
                                        <?php foreach($info as $titolo => $durata): ?>
                                            <li><?= $titolo . " (" . $durata .")"; ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li><?= $row["Titoli"] . " (" . $row["Durate"] .")"; ?></li>
                                    <?php endif; ?>
                                </ul>
                                <?php if(is_array($row["Durate"])): ?>
                                    <?php $durata_totale = 0;
                                        foreach($row["Durate"] as $durata):
                                            $durata_totale += strtotime($durata);
                                        endforeach;
                                    ?>
                                <?php else: ?>
                                    <?php $durata_totale = strtotime($row["Durate"]); ?>
                                <?php endif; ?>
                                <hr>
                                <h2><span>Durata totale stimata del servizio: </span><?= date("H:i", $durata_totale); ?></h2>
                                <?php if($mode !== true and (session("user")["Telefono"] === $row["Telefono_C"] || session("user")["Telefono"] === $row["Telefono_P"])): ?>
                                    <hr style="background-color:#F0A04B;">
                                <?php endif; ?>
                                <?php if($mode === true and session("user")["Tipologia"] === "t" and $row["Data_P"] !== date("Y-m-d")): ?>
                                    <div style="margin-left:auto; margin-right:auto;">
                                        <a href="<?php echo base_url()?>rmreservation/<?= $row["Telefono_C"] . "/". $row["Personale_Username"] . "/". $row["Data_P"] . "/". $row["Ora_P"]; ?>" style="text-decoration: none; background-color: #dc3545; color: #fff; padding: 5px 10px; border-radius: 5px; margin-top: 10px; display: inline-block;">Disdici</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif(isset($error)): ?>
                        <div class="error-box" style=" margin-top: 5px; text-align: center;">
                            <p class="error-message"><?= $error ?></p>
                        </div>
                <?php endif; ?>
            </div>
        <?= view("templates/footer") ?>
    </body>
</html>