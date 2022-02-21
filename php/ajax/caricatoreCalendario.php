<?php
	session_start();

	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";

	//Ricerca dei giorni di ferie accettati per la visualizzazione del calendario del mese mostrato 
	//sulla pagina dell'utente barber

	$nomeUtente = $_GET['nomeUtente'];           

	$risultato = getFerieDelMese($_SESSION["nomeUtente"]);
	$stringa_ferie = "";
	if($risultato != null && $risultato->num_rows > 0){
		$i = 0;
	    while ($riga = $risultato->fetch_assoc()){
	        $inizio = new DateTime($riga["Data1"]);
	        $fine = new DateTime($riga["Data2"]);

	       
	        if(date("m",strtotime($riga["Data2"])) != date("m",strtotime($riga["Data1"])))
	        	$ultimo_giorno = date('t',strtotime($riga["Data1"]));
	        else 
	        	$ultimo_giorno = date("d",strtotime($riga["Data2"]));
	        $intervallo = DateInterval::createFromDateString('1 day');
	        $periodo = new DatePeriod($inizio, $intervallo, $fine);

	        foreach ($periodo as $dt) {
	            $stringa_ferie = $stringa_ferie . $dt->format(" d ");
	            if($dt->format("d") == $ultimo_giorno)
	        		break;
	        }
	    }
	    $risposta = new AjaxRisposta("0", $stringa_ferie);
	} else{
		$risposta = new AjaxRisposta("0", "");
	}

	echo json_encode($risposta);
	return;
?>