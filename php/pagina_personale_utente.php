<?php
    require_once __DIR__ . "/config.php";
    session_start();
    include DIR_UTIL . "sessionUtil.php";

    if (!isLogged()){
        header('Location: ./../index.php');
        exit;
    } 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Appuntamenti utente</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/barberGestoreEventi.js"></script>  
    <script src="./../js/ajax/CaricatoreUtente.js"></script>
    <script src="./../js/ajax/DashboardUtente.js"></script>
    <script src="./../js/ajax/utenteGestoreEventi.js"></script>
    <script src="./../js/ajax/CaricatoreAppuntamenti.js"></script>
    <script src="./../js/ajax/ListaAppuntamenti.js"></script>
    <meta name="viewport" content="width=device-width">  
</head>
<?php
$tipoRicerca = APPUNTAMENTI_UTENTE;
echo '<body onload="CaricatoreUtente.CaricaDati(); ';
echo 'CaricatoreAppuntamenti.inizializza(); ';
echo 'CaricatoreAppuntamenti.CaricaDati(' . $tipoRicerca . ')">';
?>
<body class = "background" onload="CaricatoreUtente.CaricaDati()">
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="#home" class="logo">Barbershop</a>
                <a href="./profilo_utente.php">Profilo</a>
                <a href="./logout.php" class="nav_sx">Logout</a>
                <a href="./profilo_utente.php" class="nav_sx">
                    <?php
                        echo $_SESSION['nomeUtente'];
                    ?>
                </a>
                <a href="javascript:void(0);" class="icona" onclick="Hamburger()">
                    <img src="./../img/hamburger_icon.svg" alt="hamburger icon"></img>
                </a>
            </div>  
        </nav>

        <div class="id1 modulo" onclick="chiudiFuori()"></div>

        <section>
            <div class="contenitore_img" id="margin_img">
                <img src="./../img/hair_cut.svg" alt="servio taglio barba" class="immagine_pp">
            </div>
            <div class="prenotazione">
                <section>
                    <h2 class="intestazione">Prenotazione</h2>
                    <p class="stile_testo">Completa il form per prenotare un appuntamento, per uno dei nostri servizi</p>
                    <div class="alert"></div>
                    <div class="elemento">
                        <label class="etichetta">Data appuntamento</label>
                        <input type="date" name="data_appuntamento" onChange="utenteGestoreEventi.onChange(this.value, null)" class="ins_dati" required>
                    </div>
                    <div class="elemento" id = "barber"></div>
                    <div class="elemento" id = "orari"></div>
                    <div class="elemento" id = "servizi"></div>
                    <button type="submit" class="bottone" onclick="utenteGestoreEventi.riepilogoAppuntamento()">Prenota appuntamento!</button>
                </section>
                <section>
                    <h2>Prossimi appuntamenti</h2>
                    <div class="contenitore_tabella">
                        <?php 
                            echo '<div class="elementi_navigazione">';
                            echo '<input type="button" value=" " class="precedente" disabled ';
                            echo 'onClick="CaricatoreAppuntamenti.precedente(' . $tipoRicerca . ', 0)">'; 
                            echo '<input type="button" value=" " class="successivo" disabled ';
                            echo 'onClick="CaricatoreAppuntamenti.successivo(' . $tipoRicerca . ', 0)">';
                            echo '<div class="pagina_corrente">Pagina 1</div>';
                            echo '</div>';
                        ?>
                    </div>
                </section>
                <section>
                    <h2>Cronologia appuntamenti</h2>
                    <div class="contenitore_tabella">
                        <?php 
                            echo '<div class="elementi_navigazione">';
                            echo '<input type="button" value=" " class="precedente" disabled ';
                            echo 'onClick="CaricatoreAppuntamenti.precedente(' . $tipoRicerca . ', 1)">'; 
                            echo '<input type="button" value=" " class="successivo" disabled ';
                            echo 'onClick="CaricatoreAppuntamenti.successivo(' . $tipoRicerca . ', 1)">';
                            echo '<div class="pagina_corrente">Pagina 1</div>';
                            echo '</div>';
                        ?>
                    </div>
                </section> 
            </div>
        </section>
    </main>
</body>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header -->