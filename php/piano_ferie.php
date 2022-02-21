<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Piano ferie</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <script src="./../js/controlli.js"></script>
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/DashboardRichiestaFerie.js"></script>
    <script src="./../js/ajax/barberGestoreEventi.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <meta name="viewport" content="width=device-width">  
</head>
<?php
    echo '<body class = "background" onload="barberGestoreEventi.CaricaFerie(\'' . $_SESSION['nomeUtente'] . '\')">';
?>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="./../index.php" class="logo">Barbershop</a>
                <a href="./piano_ferie.php">Piano ferie</a>
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
            <section>
                <div class="alert"></div>
                <h2 class="intestazione">Richiesta ferie</h2>
                <table class="tabella_ferie" id = "inserimento">
                    <tr class="riga_ferie">
                        <th class = "col_ferie grand_colonna">Data inizio</th>
                        <th class = "col_ferie grand_colonna">Data fine</th>
                        <th class = "col_ferie grand_colonna" id = "richiedi">Richiedi</th>
                    </tr>
                    <tr class="riga_ferie">
                        <td class = "col_ferie grand_colonna">
                            <input type="date" name="data_inizio" onChange="controllaDate('data_inizio', 'data_fine')" onclick = "pulisciStile('data_inizio')" id ="data_inizio" class = "ins_ferie">
                        </td>
                        <td class = "col_ferie grand_colonna">
                            <input type="date" name="data_fine" onChange="controllaDate('data_inizio', 'data_fine')" onclick = "pulisciStile('data_fine')" id = "data_fine" class = "ins_ferie">
                        </td>
                        <td class = "col_ferie grand_colonna">
                            <p class="conferma_richiesta" onClick = "barberGestoreEventi.richiediFerie('<?php echo $_SESSION["nomeUtente"] ?>')">&#10003;</p>
                        </td>
                    </tr>
                </table>
            </section>
            <section>
                <h2 class = "intestazione">Ferie in approvazione</h2>
                <div id = "contenitore_pending"></div>
            </section>
            <section>
                <h2 class = "intestazione">Ferie accettate</h2>
                <div id = "contenitore_rifiutate"></div>
            </section>
            <section id = "ultimo_elemento_piano">
                <h2 class = "intestazione">Ferie rifiutate</h2>
                <div id = "contenitore_accettate"></div>
            </section>
        </section>
    </main>
</body>
</html>

<!-- Warning:
        - Il lang è presente
        - Nelle section segnalate non ho previsto header --> 