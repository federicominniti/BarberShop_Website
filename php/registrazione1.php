<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <script src="./../js/controlli.js"></script>
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/DashboardUtente.js"></script>
    <script src="./../js/ajax/utenteGestoreEventi.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<body>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="./../index.php" class="logo">Barbershop</a>
                <a onclick="(document.getElementsByClassName('id1'))[0].style.display='block'" 
                        style="width:auto;" class="nav_sx">Login</a>
                <a href="#registrati" class="nav_sx">Registrati</a>
                <a href="javascript:void(0);" class="icona" onclick="Hamburger()">
                    <img src="./../img/hamburger_icon.svg" alt="hamburger icon"></img>
                </a>
            </div>  
        </nav>
        <!--  modulo di login -->
        <div class="id1 modulo" onclick="chiudiFuori()">
            <form class="modulo_contenuto animazione" action="./php/login.php" method="post">
                <div class="contenitore_img">
                    <!-- &times è la x per chudere il popup -->
                    <span onclick="chiudiX()" class="chiudi_login" title="Chiudi modulo">&times;</span>
                    <img src="./../img/coming_soon.svg" alt="Avatar" class="avatar" id="usr_login">
                </div>
                <div class="contenitore">
                    <label class="lb_login">Username</label>
                    <input type="text" placeholder="Inserisci Username" name="nomeUtente" class="ins_dati" required>
                    <label class="lb_login">Password</label>
                    <input type="password" placeholder="Inserisci Password" name="password" class="ins_dati" required>
                    <button type="submit" class="bottone">Login</button>
                    <?php
                    if (isset($_GET['errorMessage'])){
                        echo '<script type="text/javascript">
                                (document.getElementsByClassName("id1"))[0].style.display="block"
                              </script>';
                        echo '<div>';
                        echo '<span class="errore_imm_dati">' . $_GET['errorMessage'] . '</span>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </form>
        </div>
        <section class="background">
            <div class="contenitore_img">
                <img src="./../img/barber.svg" alt="servio taglio barba" id="immagine_reg">
            </div>
            <div id="registrazione">
                <h1 class="intestazione">Registrazione</h1>
                <p class="stile_testo">Perfavore completa questo form per creare un account</p>
                <?php
                    if(isset($_SESSION['messaggioErrore']))
                    {
                ?>
                        <div class="alert sfondo_alert">
                            <span class="chiudi_alert" onclick="this.parentElement.style.display='none';">&times;</span> 
                            <p class = "testo_alert"><?php echo $_SESSION["messaggioErrore"] ?></p>
                        </div>
                <?php
                    }
                ?>
                <form action="./upload1.php" method="post" enctype="multipart/form-data">
                    <div class="elemento">
                        <label for="nome_reg" class="etichetta">Nome</label>   
                        <input type="text" placeholder="Inserisci nome" name="nome_reg" class="ins_dati" 
                        value="<?php echo isset($_SESSION['nome_reg']) ? $_SESSION['nome_reg'] : ''; ?>"
                        onblur = "controllaStringaLetterale('nome_reg')" onclick = "pulisciStile('nome_reg')"
                        id = "nome_reg" required>
                    </div>
                    <div class="elemento">
                        <label for="cognome_reg" class="etichetta">Cognome</label>   
                        <input type="text" placeholder="Inserisci cognome" name="cognome_reg" class="ins_dati" 
                        value="<?php echo isset($_SESSION['cognome_reg']) ? $_SESSION['cognome_reg'] : ''; ?>"
                        onblur = "controllaStringaLetterale('cognome_reg')" onclick = "pulisciStile('cognome_reg')"
                        id = "cognome_reg" required>
                    </div>
                    <div class="elemento">
                        <label for="nome_utente_reg" class="etichetta">Nome utente *</label>
                        <input type="text" placeholder="Inserisci nome utente" name="nome_utente_reg" class="ins_dati" 
                        value="<?php echo isset($_SESSION['nome_utente_reg']) ? $_SESSION['nome_utente_reg'] : ''; ?>"
                        onblur = "controllaNomeUtente(); utenteGestoreEventi.controllaSeGiaEsistente(this.value)" 
                        onclick = "pulisciStile('nome_utente_reg')" id = "nome_utente_reg" required>
                    </div>
                    <div class="elemento">
                        <label for="data_nascita_reg" class="etichetta">Data di nascita</label>
                        <input type="date" name="data_nascita_reg" class="ins_dati" 
                        value="<?php echo isset($_SESSION['data_nascita_reg']) ? $_SESSION['data_nascita_reg'] : ''; ?>"
                        onblur = "controllaDataDiNascita()" onclick = "pulisciStile('data_nascita_reg')" id = "data_nascita_reg"
                        required>
                    </div>
                    <div class="elemento">
                        <div id="ins_immagine">
                            <label for="file_da_caricare" class="etichetta">Seleziona immagine del profilo:</label>
                            <input type="file" name="file_da_caricare" id="file_da_caricare" accept="image/*" 
                            onclick = "pulisciStile('ins_immagine')" style = "display: inline" required>
                            <span class="rimuovi_immagine" onclick="togliImmagine()" style = "display: inline;">&times;</span> 
                        </div>
                    </div>
                    <div class="elemento">
                        <label for="email_reg" class="etichetta">Email</label>   
                        <input type="email" placeholder="Inserisci Email" name="email_reg" class="ins_dati" 
                        value="<?php echo isset($_SESSION['email_reg']) ? $_SESSION['email_reg'] : ''; ?>" 
                        id="email_reg" onclick = "pulisciStile('email_reg')" required>
                    </div>
                    <div class="elemento">
                        <label for="password_reg" class="etichetta">Password **</label>
                        <input type="password" placeholder="Inserisci Password" name="password_reg" class="ins_dati"
                        onblur = "controllaPassword('password_reg'); controllaUguaglianzaPassword('password_reg', 'ripeti_password_reg')" 
                        onclick = "pulisciStile('password_reg')" id = "password_reg" required>
                    </div>
                    <div class="elemento">
                        <label for="ripeti_password_reg" class="etichetta">Ripeti Password **</label>
                        <input type="password" placeholder="Ripeti Password" name="ripeti_password_reg" class="ins_dati"
                        onblur = "controllaPassword('ripeti_password_reg'); controllaUguaglianzaPassword('password_reg', 'ripeti_password_reg')" 
                        onclick = "pulisciStile('ripeti_password_reg')" id = "ripeti_password_reg" required>
                    </div>
                    <p class = "larghezza_paragrafo">* Deve iniziare con una lettera; UN simbolo deve essere seguito subito dopo da una lettera; lunghezza compresa tra 4 e 9 <br>
                                                     ** Deve contenere maiuscole, minuscole, numeri e esser lunga almeno 8 caratteri</p>
                    <button type="submit" class="bottone" onmousedown="evidenziaCampiOVai()">
                        Registrati
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente --> 