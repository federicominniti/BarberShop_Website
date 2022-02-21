<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";
	
	//Gestione di alcuni degli eventi generati da un utente admin

	/*
	tipoOperazione = 1 -> caricamento barber e utenti
	tipoOperazione = 2 -> cambio stato dell'account di un barber
	tipoOperazione = 3 -> cambio stato dell'account di un utente
	tipoOperazione = 4 -> creazione di un nuovo barber
	tipoOperazione = 5 -> caricamento richieste di ferie da parte dei barber
	tipoOperazione = 6 -> caricamento ferie accettate dei barber
	tipoOperazione = 7 -> accetta/rifiuta richiesta di ferie

	Ogni volta che viene eseguita un'operazione si mandera' anche il blocco di dati aggiornati coinovolti nell'operazione stessa
	*/

	$tipoOperazione = $_GET['tipoOperazione'];
	if($tipoOperazione == 1)
		$risultato1 = null;
	if($tipoOperazione == 2 || $tipoOperazione == 3){
		$nomeUtente = $_GET['nomeUtente'];
		$attivo = $_GET['attivo'];
		if($attivo == 1)
			$attivo = 0;
		else $attivo = 1;
	}
	if($tipoOperazione == 2){
		$risultato1 = cambiaStatoBarber($nomeUtente, $attivo);
	}
	if($tipoOperazione == 3){
		$risultato1 = cambiaStatoUtente($nomeUtente, $attivo);
	}
	if($tipoOperazione == 4){
		$cognome = $_GET['cognome'];
		$nome = $_GET['nome'];
		$nomeUtente = $_GET['nomeUBarber'];
		$password = $_GET['password'];
		$risultato1 = creaBarber($cognome, $nome, $nomeUtente, $password);
	}
	if($tipoOperazione == 1 || $tipoOperazione == 2 || $tipoOperazione == 4)
		$risultato2 = getPersonale();
	else $risultato2 = null;
	if($tipoOperazione == 1 || $tipoOperazione == 3)
		$risultato3 = getUtenti();
	else $risultato3 = null;

	if($tipoOperazione < 5)
		$risposta = setRispostaUtenti($tipoOperazione, $risultato1, $risultato2, $risultato3);

	if($tipoOperazione == 7){
		$codiceRichiesta = $_GET['codiceRichiesta'];
		$si_no = $_GET['si_no'];
		if($si_no == 1)
			$risultato = updateFerie($codiceRichiesta, "accettate");
		if($si_no == 0)
			$risultato = updateFerie($codiceRichiesta, "rifiutate");
		if($risultato == 1)
			$tipoOperazione  = 5;
		else
			$risposta = new AjaxRisposta("-1", "Errore nell'operazione!");
	}

	if($tipoOperazione == 5){
		$risultato = getFeriePending();
		$risposta = setRispostaFerie($risultato);
	}

	if($tipoOperazione == 6){
		$risultato = getFerieAccettate();
		$risposta = setRispostaFerie($risultato);
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
	
	function setRispostaUtenti($tipoOperazione, $risultato1, $risultato2, $risultato3){
		if(controllaValori($risultato2) && controllaValori($risultato3)){
			$risposta = rispostaVuota();
		}else{
			$risposta = new AjaxRisposta("0", "OK");
			if($risultato2 != null){
				$i = 0;
				while($riga = $risultato2->fetch_assoc()){
					$barber = new Barber($riga["Cognome"], $riga["Nome"], $riga["NomeUBarber"], $riga["Password"], $riga["Attivo"]);
					$risposta->dati[0][$i] = $barber;
					$i++;
				}	
			}
			if($risultato3 != null){
				$i = 0;
				while($riga = $risultato3->fetch_assoc()){
					$utente = new Utente($riga["Nome"], $riga["Cognome"], null,  $riga["NomeUtente"], $riga["Email"], null, $riga["Attivo"]);
					$risposta->dati[1][$i] = $utente;
					$i++;
				}
			}
		}
		if($risultato1 < 1 && $tipoOperazione != 1){
			$risposta->codiceRisposta = 0;
			$risposta->messaggio = "Operazione non andata a buon fine";
		}

		return $risposta;
	}

	function setRispostaFerie($risultato){
		if(controllaValori($risultato)){
			$risposta = rispostaVuota();
		}else{
			$risposta = new AjaxRisposta("0", "OK");
			$i = 0;
			while($riga = $risultato->fetch_assoc()){
				$ferie = new Ferie($riga["CodiceRichiesta"], $riga["NomeUBarber"], $riga["Data1"], $riga["Data2"], $riga["DataRichiesta"]);
				$risposta->dati[$i] = $ferie;
				$i++;
			}	
		}
		return $risposta;
	}
?>
