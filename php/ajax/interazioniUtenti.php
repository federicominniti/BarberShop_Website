<?php
	session_start();
	
	require_once __DIR__ . "/../config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_AJAX_UTIL . "AjaxResponse.php";
	
	//Gestione di alcuni degli eventi generati da un utente barber

	/*
	evento = 0 -> appuntamento che era stato prenotato da un cliente e' stato completato e viene spuntato 
					come fatto
	evento = 1 -> Eliminazione appuntamento non ancora da parte di un utente cliente
	evento = 2 -> Inserimento di un nuovo appuntamento prenotato dall'utente cliente
	evento = 3 -> Selezione di un utente con un nome utente dato per il controllo ai fini di evitare 
					nomi utenti doppioni
	evento = 4 -> update della password nuova dell'utente cliente
	evento = 5 -> Ricerca della vecchia password per la verifica di correttezza nella procedura di 
					cambio password dell'utente cliente
	evento = 6 -> eliminazione di una richiesta di ferie effettuata da un utente barber ma non ancora 
					accettata dall'admin/direttore
	evento = 7 -> richiesta di ferie da parte di un utente barber
	evento = 8 -> caricamento del piano ferie dell'utente barber in seguito dell'omonima sezione
	evento = onChange -> ricerca orari ancora disponibili data la coppia giorno - barber
	
	*/

	$risposta = new AjaxRisposta();
	
	if (!isset($_GET['evento'])){
		echo json_encode($risposta);
		return;
	}		
	$evento = $_GET['evento'];
	switch ($evento) {
		case 0:
			if(!isset($_GET['codiceAppuntamento'])){
				echo json_encode($risposta);
				return;
			}
			$codiceAppuntamento = $_GET['codiceAppuntamento'];
			$risultato = setFatto($codiceAppuntamento); 
			break;
		case 1:
			if(!isset($_GET['codiceAppuntamento'])){
				echo json_encode($risposta);
				return;
			}
			$codiceAppuntamento = $_GET['codiceAppuntamento'];
			$risultato = cancellaAppuntamento($codiceAppuntamento);
			break;
		case 2:
			if(!isset($_GET['data']) || !isset($_GET['barber']) || !isset($_GET['orario']) || !isset($_GET['servizio'])){
				echo json_encode($risposta);
				return;
			}
			$data = $_GET['data'];
			$barber = $_GET['barber'];
			$orario = $_GET['orario'];
			$servizio = $_GET['servizio'];
			$nomeUBarber = getNomeUBarberByNome($barber);
			$riga = $nomeUBarber->fetch_assoc();
			$barber = $riga["NomeUBarber"];
			$numeroServizio = getNumeroServizioByNome($servizio);
			$riga = $numeroServizio->fetch_assoc();
			$servizio = $riga["NumeroServizio"];
			$errore = controllaData($barber, $data, $orario);
			if($errore == null){
				$risultato = prenotaAppuntamento($data, $barber, $orario, $servizio, $_SESSION["nomeUtente"]);
			}
			else{
				$risposta = new AjaxRisposta("1", $errore);
				echo json_encode($risposta);
				return;
			}
			break;
		case 3:
			if(!isset($_GET['nomeUtente'])){
				echo json_encode($risposta);
				return;
			}
			$nomeUtente = $_GET['nomeUtente'];
			$errore = getUtente($nomeUtente);
			if($errore->num_rows > 0){
				$risposta = new AjaxRisposta("1", "Utente non disponibile");
				echo json_encode($risposta);
				return;
			}
			else{
				$risultato = true;
			}
			break;
		case 4:
			if(!isset($_GET['nuova']) || !isset($_GET['nomeUtente'])){
				echo json_encode($risposta);
				return;
			}
			$nuova = md5($_GET['nuova']);
			$nomeUtente = $_GET['nomeUtente'];
			$risultato = updatePassword($nuova, $nomeUtente);
			break;
		case 5:
			if(!isset($_GET['vecchia']) || !isset($_GET['nomeUtente'])){
				echo json_encode($risposta);
				return;
			}
			$vecchia = md5($_GET['vecchia']);
			$nomeUtente = $_GET['nomeUtente'];
			$risultato = verificaPassword($nomeUtente);
			$riga = $risultato->fetch_assoc();
			if($vecchia != $riga["Password"]){
				$risposta = new AjaxRisposta("1", "Password errata");
				echo json_encode($risposta);
				return;
			}
			break;
		case 6:
		case 7:
			if($evento == 6){
				$codiceRichiesta = $_GET['codiceRichiesta'];
				$risultato = prendiNomeDaRichiesta($codiceRichiesta);
				$risultato = $risultato->fetch_assoc();
				$nomeUtente = $risultato["NomeUBarber"];
				$risultato = rimuoviRichiestaFerie($codiceRichiesta);
				if($risultato != 1){
					$risposta = new AjaxRisposta("-2", "Impossibile eseguire l'opereazione!");
					echo json_encode($risposta);
					return;
				}
			}
			if($evento == 7){
				$nomeUtente = $_GET['nomeUtente'];
				$data1 = $_GET['data1'];
				$data2 = $_GET['data2'];
				$risultato = controllaSovrapposizioni($nomeUtente, $data1, $data2);
				if($risultato->num_rows > 0){
					$risposta = new AjaxRisposta("-2", "Una data si sovrappone con una richiesta di ferie già eseguita!");
					echo json_encode($risposta);
					return;
				}
				$risultato = inserisciRichistaFerie($nomeUtente, $data1, $data2);
				if($risultato == 0){
					$risposta = new AjaxRisposta("-2", "Errore durante l'inserimento della richiesta!");
					echo json_encode($risposta);
					return;
				}
			}
		case 8:
			if($evento == 8)
				$nomeUtente = $_GET['nomeUtente'];
			$ferieRifiutate = getFerie($nomeUtente, "rifiutate");
			$ferieAccettate = getFerie($nomeUtente, "accettate");
			$feriePending = getFerie($nomeUtente, "pending");
			$risposta = setElencoFerie($ferieRifiutate, $ferieAccettate, $feriePending);
			echo json_encode($risposta);
			return;
		default:
			# code...
			break;
	}
	if($risultato)
		$risposta = new AjaxRisposta("0", "OK");
	echo json_encode($risposta);
	return;


	function setFatto($codiceAppuntamento){
		$risultato = false;
		if(codiceAppuntamentoPresente($codiceAppuntamento))
			$risultato = setFlagFatto($codiceAppuntamento);
		return $risultato;
	}

	function cancellaAppuntamento($codiceAppuntamento){
		$risultato = false;
		if(codiceAppuntamentoPresente($codiceAppuntamento))
			$risultato = deleteAppuntamento($codiceAppuntamento);
		return $risultato;
	}

	function prenotaAppuntamento($data, $barber, $orario, $servizio, $nomeUtente){
		$risultato = false;
		$risultato = inserisciAppuntamento($data, $barber, $orario, $servizio, $nomeUtente);
		return $risultato;
	}

	function codiceAppuntamentoPresente($codiceAppuntamento){
		$risultato = getAppuntamento($codiceAppuntamento);
		$numeroRighe = $risultato->num_rows;
		return $numeroRighe === 1;
	}

	function controllaData($barber, $data, $orario){
		if($data < date("Y-m-d") || ($data == date("Y-m-d") && $orario < date("h:i"))){
			return "Data o ora inserita non coretta";
		}
		else{
			$giorno = substr($data, 8);
			$mese =	substr($data, 5, 2);
			$anno =	substr($data, 0, 4);
			$jd = gregoriantojd($mese, $giorno, $anno);
			if(jddayofweek($jd) == 0){
				return "Domenica il negozio è chiuso come da orario";
			}	

			$risultato = getBarberNonDisponibile($barber, $data, $orario);
			if ($risultato != null && $risultato->num_rows > 0){
				$riga = $risultato->fetch_assoc();
				return "Il barber scelto è in FERIE dal giorno " . $riga["Data1"] . " al giorno " 
						. $riga["Data2"];
			}
			return null;
		}
	}

	function controllaValori($risultato){
		if ($risultato === null || !$risultato)
			return true;
			
		return ($risultato->num_rows) <= 0;
	}
	
	function rispostaVuota(){
		$messaggio = "Non ci sono elementi da caricare";
		return new AjaxRisposta("-1", $messaggio);
	}

	function setElencoFerie($ferieRifiutate, $ferieAccettate, $feriePending){
		if(controllaValori($ferieRifiutate) && controllaValori($ferieAccettate) && controllaValori($feriePending)){
			$risposta = rispostaVuota();
		}else{
			$risposta = new AjaxRisposta("0", "OK");
			if($feriePending != null){
				$i = 0;
				while($riga = $feriePending->fetch_assoc()){
					$richiesta = new Ferie($riga["CodiceRichiesta"], null, $riga["Data1"], $riga["Data2"], $riga["DataRichiesta"]);
					$risposta->dati[0][$i] = $richiesta;
					$i++;
				}	
			}
			else{
				$risposta->dati[0] = null;
			}

			if($ferieRifiutate != null){
				$i = 0;
				while($riga = $ferieRifiutate->fetch_assoc()){
					$richiesta = new Ferie($riga["CodiceRichiesta"], null, $riga["Data1"], $riga["Data2"], $riga["DataRichiesta"]);
					$risposta->dati[1][$i] = $richiesta;
					$i++;
				}	
			}
			else{
				$risposta->dati[1] = null;
			}

			if($ferieAccettate != null){
				$i = 0;
				while($riga = $ferieAccettate->fetch_assoc()){
					$richiesta = new Ferie($riga["CodiceRichiesta"], null, $riga["Data1"], $riga["Data2"], $riga["DataRichiesta"]);
					$risposta->dati[2][$i] = $richiesta;
					$i++;
				}	
			}
			else{
				$risposta->dati[2] = null;
			}	
		}
		return $risposta;
	}

?>
