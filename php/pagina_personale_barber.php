<!--//VANNO SISTEMATI I LINK DELLA NAVBAR!!! -->
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
    <title>Appuntamenti barber</title>
    <link rel="stylesheet" href="./../css/index1.css" media="screen">
    <script src="./../js/effects.js"></script>
    <!-- PER LA VISUALIZZAZIONE DEVICES DI CHROME -->
    <script src="./../js/ajax/ajaxManager.js"></script>  
    <script src="./../js/ajax/barberGestoreEventi.js"></script>  
    <script src="./../js/ajax/CaricatoreAppuntamenti.js"></script>
    <script src="./../js/ajax/ListaAppuntamenti.js"></script>
    <script src="./../js/ajax/DashboardUtente.js"></script>
    <script src="./../js/ajax/CaricatoreUtente.js"></script>
    <meta name="viewport" content="width=device-width">  
</head>
<?php
    $tipoRicerca = APPUNTAMENTI_BARBER;
    echo '<body class = "background" onload="CaricatoreAppuntamenti.inizializza(); ';
    echo 'CaricatoreUtente.SegnaFerieCalendario(\'' . $_SESSION["nomeUtente"] . '\'); ';
    echo 'CaricatoreAppuntamenti.CaricaDati(' . $tipoRicerca . ')">';
?>
    <main>
        <nav>
            <div class="navbar" id="myNavbar">
                <a href="./../index.php" class="logo">Barbershop</a>
                <?php
                    if($_SESSION["admin"] == 1)
                        echo '<a href="./gestione_utenti.php">Gestisci utenti</a>';
                ?>
                <?php
                    if($_SESSION["admin"] == 1)
                        echo '<a href="./richieste_ferie.php">Richieste ferie</a>';
                    else
                        echo '<a href="./piano_ferie.php">Piano ferie</a>';
                ?>
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
            <div class="contenitore_img2" id="margin_img">
                <h1 class="logo" id="scritta_logo">Barbershop</h1>
            </div>
            <section>
                <!-- Alert per stampa di eventuali errori-->
                <div class="alert"></div>
                
                <!-- Calendario mese corrente del barbiere-->
                <div class="mese">      
                    <ul class="no_punto">
                        <li>
                            <?php
                                echo date("M") . "<br>";
                                echo '<span class = "anno">' . date("Y") . '</span>';
                            ?>
                        </li>
                    </ul>
                </div>
                <table id="calendario">
                        <tr>
                                <th class="giorni_settimana">Lu</th>
                                <th class="giorni_settimana">Ma</th>
                                <th class="giorni_settimana">Me</th>
                                <th class="giorni_settimana">Gi</th>
                                <th class="giorni_settimana">Ve</th>
                                <th class="giorni_settimana">Sa</th>
                                <th class="giorni_settimana">Do</th>
                        </tr>
                        <?php 
                            $first_day = date("Y") . "-" . date("m") . "-01";
                            $cday=1;
                            $days=cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y"));
                            $w=date("w", strtotime($first_day))-1;
                            if($w < 0)
                                $w = 6;
                            $i=0;
                            $contatore=0;

                            for(; $w > 0; $w--){
                                if($i==0)
                                    echo"<tr>";
                                echo '<td class="giorni"></td>';
                                if($i==6){
                                        $i=0;
                                        echo "</tr>";
                                }
                                else
                                    $i++;
                                $contatore++;
                            }
                                
                            for(;$days > 0; $days --){
                                if($i==0)
                                    echo"<tr>";
                                if($cday == date("d"))
                                    echo '<td class="giorni" id = "gg' . $cday . '"><span class="active">' . $cday . "</span></td>";
                                else 
                                    echo '<td class="giorni" id = "gg' . $cday . '">' . $cday . '</td>';
                                $cday++;
                                if($i==6){
                                    $i=0;
                                    echo "</tr>";
                                }
                                else
                                    $i++;
                                $contatore++;
                            }

                            while(($contatore % 7) != 0){
                                echo '<td class="giorni"></td>';
                                $contatore ++;
                            }
                        ?>
                </table>
            </section>
            <div class="prenotazione"> 
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