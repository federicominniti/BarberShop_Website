<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";
	
	//Caricamento dal db delle informazioni personali dell'utente e di alcune semplici statistiche 
	//relativamente agli appuntamenti svolti dal cliente

	$risultato[0] = getInformazioniUtente($_SESSION["nomeUtente"]);
	$risultato[1] = getStatisticheUtente($_SESSION["nomeUtente"]);

	for($j = 0; $j < 2; $j++){
		$risposta[$j] = setRisposta($risultato[$j], $j);
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
	
	function setRisposta($risultato, $j){
		if(controllaValori($risultato)){
			$risposta = rispostaVuota();
		}else{
			$risposta = new AjaxRisposta("0", "OK");
			switch ($j) {
				case 0:
					$utente = new Utente();
					$riga = $risultato->fetch_assoc();
					$utente->nome = $riga["Nome"];
					$utente->cognome = $riga["Cognome"];
					$utente->dataDiNascita = $riga["DataDiNascita"];
					$utente->nomeUtente = $riga["NomeUtente"];
					$utente->email = $riga["Email"];
					$utente->immagineProfilo = $riga["ImmagineProfilo"];
					$utente->attivo = $riga["Attivo"];
					$risposta->dati = $utente;
					break;
				case 1:
					$i = 0;
					while($riga = $risultato->fetch_assoc()){
						$contatoreServizio = new ContatoreServizio($riga["NumeroServizio"], $riga["numeroAppuntamenti"]);
						while($riga["NumeroServizio"] > ($i+1)){ //se il contatore è a 0
							$contatoreServizio0 = new ContatoreServizio(($i+1), 0);
							$risposta->dati[$i] = $contatoreServizio0;
							$i++;
						}
						$risposta->dati[$i] = $contatoreServizio;
						$i++;
					}
					break;
			}
		}
		return $risposta;
	}

?>
