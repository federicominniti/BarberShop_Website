<?php
    session_start();
    require_once __DIR__ . "/php/config.php";
    include DIR_UTIL . "sessionUtil.php";

    if (isLogged() == "utente"){
            header('Location: ./php/pagina_personale_utente.php');
            exit;
    }elseif(isLogged() == "barber"){
            header('Location: ./php/pagina_personale_barber.php');
            exit;
    } 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Barber</title>
    <link rel="stylesheet" href="css/index1.css" media="screen">
    <script src="./js/effects.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<body>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="#immagine1" class="logo">Barbershop</a>
                <a href="#slide3_1">Servizi</a>
                <a href="#slide4_1">Barber</a>
                <a href="#slide5_1">Orari</a>
                <a href="./manuale_utente.html">Manuale</a>
                <a onclick="(document.getElementsByClassName('id1'))[0].style.display='block'" 
                        style="width:auto;" class="nav_sx">Login</a>
                <a href="./php/registrazione1.php" class="nav_sx">Registrati</a>
                <a href="javascript:void(0);" class="icona" onclick="Hamburger()">
                    <img src="img/hamburger_icon.svg" alt="hamburger icon"></img>
                </a>
            </div>  
        </nav>
        <!--  modulo di login -->
        <div class="id1 modulo" onclick="chiudiFuori()">
            <form class="modulo_contenuto animazione" action="./php/login.php" method="post">
                <div class="contenitore_img">
                    <!-- &times è la x per chudere il popup -->
                    <span onclick="chiudiX()" class="chiudi_login" title="Chiudi modulo">&times;</span>
                    <img src="img/coming_soon.svg" alt="Avatar" class="avatar" id="usr_login">
                </div>
                <div class="contenitore">
                    <label class="lb_login">Nome Utente</label>
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
        <!-- slide 1 -->
        <section class="immagine" id="immagine1">
            <div id="c_slide1">
                <h1>Barbershop!</h1>
            </div>
        </section>
        <!-- slide 2 -->
        <section class="immagine" id="immagine2">
                <div id="c_slide2">
                    <p>Ancora all’inizio degli anni sessanta la barba era fascista 
                        – ma occorreva disegnarne il profilo, rasandola sulle guance, alla Italo Balbo –
                         nel sessantotto era stata contestataria, e ora stava diventando neutra e universale, 
                        scelta di libertà. La barba è sempre stata maschera.</p>
                    <cite>-Umberto Eco</cite>
                </div>
        </section>
        <!-- slide 3 -->
        <section>
            <div id="slide3_1">
                <h1>Alcuni dei nostri servizi</h1>
                <h2>(Scopri di più nella sezione prenota)</h2>
                <section class="c_slide3">
                    <img src="img/icon_forbici.svg" alt="icona forbici" id="forbici">
                    <p>CAPIGLIATURA DI STILE</p>  
                </section>
                <section class="c_slide3">
                    <img src="img/icon_rasoioelettrico.svg" alt="icona rasoio elettrico" id="rasoioelt">
                    <p>SINGLE CLIPPER</p>  
                </section>
                <section class="c_slide3">
                    <img src="img/icon_barba.svg" alt="icona barba" id="barba">
                    <p>RITOCCO BARBA</p>  
                </section>
                <section class="c_slide3">
                    <img src="img/icon_rasoio.svg" alt="icona rasoio" id="rasoio">
                    <p>TAGLIO BARBA AL RASOIO</p> 
                </section>
                <section class="c_slide3">
                    <img src="img/icon_colore.svg" alt="icona colore" id="colore">
                    <p>COLORE</p> 
                </section>
            </div>
        </section>
        <!-- slide 4 -->
        <section class="immagine"  id="immagine4">
            <div id="slide4_1">
                <h1 class="intestazione">I nostri Barber</h1>
                <section class="c_slide4">
                   <img src="img/marco.svg" alt="avatar Marco" class="avatar">
                   <h2>Marco</h2>  
                   <p>Età: 26</p>
                   <p>Lui è Marco il BOSS e come ogni capo è meticoloso e attento,
                      pieno di spirito d'iniziativa e intraprendente nonchè un 
                      ottimo barber</p>
                </section>
                <section class="c_slide4">
                    <img src="img/paolo.svg" alt="avatar Paolo" class="avatar">
                    <h2>Paolo</h2>  
                    <p>Età: 23</p>
                    <p>Lui è Paolo meticoloso e attento ad ogni singolo dettaglio, che 
                       ricerca ogni giorno nuovi tagli sempre più articolati e di 
                       complessa esecuzione</p>
                </section>
                <section class="c_slide4">
                    <img src="img/alessio.svg" alt="avatar Alessio" class="avatar">
                    <h2>Alessio</h2>  
                    <p>Età: 25</p>
                    <p>Lui è Alessio un barber esuberante e preciso allo stesso tempo,
                       reputa il suo lavoro impeccabile ma voi criticatelo altrimenti 
                       si monta la testa!</p>
                </section>
                <section class="c_slide4">
                    <img src="img/nicolo.svg" alt="avatar Niccolò" class="avatar">
                    <h2>Nicolò</h2> 
                    <p>Età: 20</p>
                    <p>Lui è Nicolò è il più giovane del gruppo ma ha sempre avuto le idee molto chiare, 
                       vuole diventare un barber di successo</p>
                </section>
                <section class="c_slide4">
                    <img src="img/multiple_coming_soon.svg" alt="Nuovi Barbers stanno per arrivare" id="barbers">
                    <h2>Stanno per arrivare...</h2> 
                    <p>Siamo alla continua ricerca di barber talentuosi, che non vedono
                       l'ora di potersi mettere in gioco, fino ad ottenere l'ambito posto
                       nel web tra "I nostri Barbers". Ma spetta solo sa te la decisione...
                       prenota un servizio, dagli una possibilità e lasciasci il tuo feedback</p>
                </section>
            </div>
        </section>
        <!-- slide 5 -->
        <section>
            <div id="slide5_1">
                <h1>ORARI DI APERTURA</h1>  
                <p>LUN 14.3O - 19.3O<br>
                    MAR MER VEN 8.3O - 13.OO | 15.OO - 19.3O<br>
                    GIOV 1O.3O - 20.OO<br>
                    SAB 8.OO - 18.3O<br>
                    DOMENICA CHIUSO<br>
                    <br>
                    INFO E APPUNTAMENTI ONLINE<br>
                    OPPURE<br>
                    VIENI A TROVARCI IN<br>
                    VIALE DEI VIALI 43 LUCCA<br></p>
                <a href="mailto:info@barber-lucca.it">info@barber-lucca.it</a>
            </div>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header --> 