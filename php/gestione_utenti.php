<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione utenti</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <script src="./../js/controlli.js"></script>
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/DashboardAdmin.js"></script>
    <script src="./../js/ajax/utenteGestoreEventi.js"></script>
    <script src="./../js/ajax/CaricatoreAdmin.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<?php
    echo '<body class = "background" onload="CaricatoreAdmin.CaricaDashboardAmministrazione()">';
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

        <section>
            <div class="alert"></div>
            <section class = "amministrazione">
                <h2 class = "intestazione">Amministrazione barbers</h2>
                <div id = "contenitore_personale"></div>
            </section>
            <section class = "amministrazione">
                <h2 class = "intestazione">Amministrazione utenti</h2>
                <div id = "contenitore_utenti"></div>
            </section>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header --> 