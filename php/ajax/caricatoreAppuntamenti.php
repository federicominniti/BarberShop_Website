<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";
	
	//Caricamento degli appuntamenti fatti e prenotati degli utenti barber e clienti

	/*
	tipoRicerca = 0 -> Ricerca con offset degli appuntamenti del barber 
	tipoRicerca = 1 -> Ricerca con offset degli appuntamenti del cliente 
	*/

	$risposta[0] = new AjaxRisposta();
	$risposta[1] = new AjaxRisposta();
	
	if (!isset($_GET['tipoRicerca']) || !isset($_GET['appDaCaricareF']) || !isset($_GET['offsetF'])
			|| !isset($_GET['appDaCaricareNF']) || !isset($_GET['offsetNF'])){
		echo json_encode($risposta);
		return;
	}		

	$tipoRicerca = $_GET['tipoRicerca'];
	$appDaCaricareF = $_GET['appDaCaricareF'];
	$offsetF = $_GET['offsetF'];
	$appDaCaricareNF = $_GET['appDaCaricareNF'];
	$offsetNF = $_GET['offsetNF'];
		
	switch ($tipoRicerca){
		case 0:
			$risultato[0] = getAppuntamentiBarber($_SESSION['nomeUtente'], $offsetNF, $appDaCaricareNF, 0);
			$risultato[1] = getAppuntamentiBarber($_SESSION['nomeUtente'], $offsetF, $appDaCaricareF, 1);
			break;
		case 1:
			$risultato[0] = getAppuntamentiUtente($_SESSION['nomeUtente'], $offsetNF, $appDaCaricareNF, 0);
			$risultato[1] = getAppuntamentiUtente($_SESSION['nomeUtente'], $offsetF, $appDaCaricareF, 1);
			break;
		default:
			$risultato = null;
			break;
	}
	
	$risposta = setRisposta($risultato, $tipoRicerca);
	echo json_encode($risposta);
	return;

	
	function controllaValori($appuntamenti){
		if ($appuntamenti === null || !$appuntamenti)
			return true;
			
		return ($appuntamenti->num_rows) <= 0;
	}
	
	function rispostaVuota(){
		$messaggio = "Non ci sono piu' appuntamenti da caricare";
		return new AjaxRisposta("-1", $messaggio);
	}
	
	function setRisposta($risultato, $tipoRicerca){
		$MAX = 2;
		for($j = 0; $j < $MAX; $j++){
			if(controllaValori($risultato[$j])){
				$risposta[$j] = rispostaVuota();
			} else{
				$risposta[$j] = new AjaxRisposta("0", "OK");
				$i = 0;
				while ($riga = $risultato[$j]->fetch_assoc()){
					$appuntamento = new Appuntamento();
					$appuntamento->nomeUtente = $riga['NomeUtente'];
					$appuntamento->dataAppuntamento = $riga['DataAppuntamento'];
					$appuntamento->oraAppuntamento = $riga['OraAppuntamento'];
					$appuntamento->codiceAppuntamento = $riga['CodiceAppuntamento'];
					$appuntamento->nomeServizio = $riga['Nome'];
					$risposta[$j]->dati[$i] = $appuntamento;
					$i++;
				}
				$risposta[$j]->tipoRicerca = $tipoRicerca;
			}
		}
		return $risposta;
	}

?>