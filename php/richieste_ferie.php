<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Richiesta ferie</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <script src="./../js/controlli.js"></script>
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/DashboardRichiestaFerie.js"></script>
    <script src="./../js/ajax/DashboardAdmin.js"></script>
    <script src="./../js/ajax/CaricatoreAdmin.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<?php
    echo '<body class = "background" onload="CaricatoreAdmin.CaricaRichiesteFerie()">';
?>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="./../index.php" class="logo">Barbershop</a>
                <a href="./gestione_utenti.php">Gestisci utenti</a>
                <a href="./richieste_ferie.php">Richieste ferie</a>
                <a href="./logout.php" class="nav_sx">Logout</a>
                <a href="./pagina_personale_barber.php" class="nav_sx"> 
                  <?php
                    echo $_SESSION['nomeUtente'];
                  ?>
                </a>
                <a href="javascript:void(0);" class="icona" onclick="Hamburger()">
                    <img src="./../img/hamburger_icon.svg" alt="hamburger icon"></img>
                </a>
            </div>  
        </nav>
        
        <section class="ferie">
            <section class = "intestazione" id = "intestazione_scelta"> 
                <p class = "selezionato scelta_visuale" onClick = "CaricatoreAdmin.CaricaRichiesteFerie()">Richieste ferie</p>
                <p class = "scelta_visuale">/</p>
                <p class = "non_selezionato scelta_visuale" onClick = "CaricatoreAdmin.CaricaFerieAccettate()">Ferie accettate</p>
            </section>
            <div class="alert"></div>
            <section>
                <div id = "contenitore_richieste"></div>
                <div id = "contenitore_accettate"></div>
            </section>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header --> 