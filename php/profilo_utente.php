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
    <title>Profilo</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <script src="./../js/controlli.js"></script>
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/DashboardUtente.js"></script>
    <script src="./../js/ajax/utenteGestoreEventi.js"></script>
    <script src="./../js/ajax/CaricatoreUtente.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<?php
echo '<body class = "background" onload="CaricatoreUtente.CaricaProfilo()">';
?>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="#home" class="logo">Barbershop</a>
                <a href="./pagina_personale_utente.php">Appuntamenti</a>
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
        
        <section>
            <h1 class = "saluto">Ciao, <?php echo $_SESSION["nomeUtente"] ?></h1>
            <div class="alert"></div>
            <section class="contenitore_profilo">
                <div class="contenitore_ip allineamento_profilo"></div>
                <div class="profilo allineamento_profilo">
                    <div id="info_profilo"></div>
                    <div class="finestra_cambio_psw">
                        <div class="elemento_cambio">
                            <label for="password_vecchia" class="etichetta">Vecchia Password</label>
                            <input type="password" placeholder="Inserisci vecchia Password" name="password_vecchia" 
                            class="ins_dati" onblur = "utenteGestoreEventi.verificaVecchiaPassword(this.value, '<?php echo $_SESSION["nomeUtente"] ?>')" 
                            onclick = "pulisciStile('password_vecchia')" id = "password_vecchia" required>
                        </div>
                        <div class="elemento_cambio">
                            <label for="password_nuova" class="etichetta">Password *</label>
                            <input type="password" placeholder="Inserisci nuova Password" name="password_nuova" 
                            class="ins_dati" onblur = "controllaPassword('password_nuova'); controllaUguaglianzaPassword('password_nuova', 'ripeti_nuova_password')" 
                            onclick = "pulisciStile('password_nuova')" id = "password_nuova" required>
                        </div>
                        <div class="elemento_cambio">
                            <label for="ripeti_nuova_password" class="etichetta">Ripeti Password *</label>
                            <input type="password" placeholder="Ripeti nuova Password" name="ripeti_nuova_password" class="ins_dati"
                            onblur = "controllaPassword('ripeti_nuova_password'); controllaUguaglianzaPassword('password_nuova', 'ripeti_nuova_password')" 
                            onclick = "pulisciStile('ripeti_nuova_password')" id = "ripeti_nuova_password" required>
                        </div>
                        <div class="elemento_cambio allineamento_bottone">
                            <button type="submit" class="bottone cambia_psw" 
                            onclick="utenteGestoreEventi.cambiaPassword('<?php echo $_SESSION["nomeUtente"] ?>')">
                            Cambia</button>
                        </div>
                        <p class = "larghezza_paragrafo">* Deve iniziare con una lettera; UN simbolo deve essere seguito subito dopo da una lettera; lunghezza compresa tra 4 e 9</p>
                    </div> 
                </div>

            </section>
            <section>
                <div id="c_slide3_1_contatore">
                    <section class="c_slide3_contatore">
                        <img src="./../img/icon_forbici.svg" alt="icona forbici" id="forbici_contatore">
                        <div id = "contatore_1"></div>
                    </section>
                    <section class="c_slide3_contatore">
                        <img src="./../img/icon_rasoioelettrico.svg" alt="icona rasoio elettrico" id="rasoioelt_contatore">
                        <div id = "contatore_2"></div>
                    </section>
                    <section class="c_slide3_contatore">
                        <img src="./../img/icon_barba.svg" alt="icona barba" id="barba_contatore">
                        <div id = "contatore_3"></div>
                    </section>
                    <section class="c_slide3_contatore">
                        <img src="./../img/icon_rasoio.svg" alt="icona rasoio" id="rasoio_contatore">
                        <div id = "contatore_4"></div>
                    </section>
                    <section class="c_slide3_contatore">
                        <img src="./../img/icon_colore.svg" alt="icona colore" id="colore_contatore">
                        <div id = "contatore_5"></div>
                    </section>
                </div>
            </section>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header -->