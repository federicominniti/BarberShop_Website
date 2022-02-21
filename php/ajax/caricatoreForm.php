<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";

	//Caricamento dati dal db per permetere al cliente di prenotare una appuntamento e degli orari 
	//disponibili sulla base di degli altri appuntamenti

	if(isset($_GET['evento'])){
		if (!isset($_GET['data']) || (strcmp($_GET['barber'], "") == 0)){
			$risposta = new AjaxRisposta();
			echo json_encode($risposta);
			return;
		}
		else{
			$data = $_GET['data'];
			$barber = $_GET['barber'];
			$nomeUtente = getNomeUBarberByNome($barber);
			$riga = $nomeUtente->fetch_assoc();
			$risultato[0] = getOrariOccupati($riga['NomeUBarber'], $data);
		}
	}else{
		$risultato[0] = getServizi();
		$risultato[1] = getBarbers();
		$risultato[2] = null;
	}

	for($j = 0; $j < count($risultato); $j++){
		$risposta[$j] = new AjaxRisposta();
		$risposta[$j] = setRisposta($risultato[$j]);
	}
	echo json_encode($risposta);
	return;

	
	function controllaValori($risultato){
		if ($risultato === null || !$risultato)
			return true;
			
		return ($risultato->num_rows) <= 0;
	}
	
	function rispostaVuota(){
		$messaggio = "Non ci sono elementi da caricare";
		return new AjaxRisposta("-1", $messaggio);
	}
	
	function setRisposta($risultato){
		if(controllaValori($risultato) && !isset($_GET['evento'])){
			$risposta = rispostaVuota();
		}else{
			$risposta = new AjaxRisposta("0", "OK");
			$i = 0;
			while ($riga = $risultato->fetch_assoc()){
				$risposta->dati[$i] = $riga["dato"];
				$i++;
			}
			if(isset($_GET['evento']) && ($risposta->dati == null)){
				$risposta->dati = "libero";
			}
		}
		return $risposta;
	}

?>