<?php
	class AjaxRisposta{
		public $codiceRisposta; // 0 all ok, 1 errori, -1 warning
		public $messaggio;
		public $dati;
		public $tipoRicerca; //-1 campo non usato
		
		function AjaxRisposta($codiceRisposta = 1, 
								$messaggio = "Riprova piu' tardi",
								$dati = null,
								$tipoRicerca = -1){
			$this->codiceRisposta = $codiceRisposta;
			$this->messaggio = $messaggio;
			$this->dati = null;
			$this->tipoRicerca = $tipoRicerca;
		}
	
	}

	//Oggetti per la gestione dei dati presi dal db dalle omonime tabelle 

	class Appuntamento{
		public $codiceAppuntamento;
		public $nomeUtente;
		public $nomeServizio;
		public $dataAppuntamento;
		public $oraAppuntamento;
		function Appuntamento($codiceAppuntamento = null, $nomeUtente = null, $nomeServizio = null, 
								$dataAppuntamento = null, $oraAppuntamento = null, $servizio = null){
			$this->nomeUtente = $nomeUtente;
			$this->nomeServizio = $nomeServizio;
			$this->codiceAppuntamento = $codiceAppuntamento;
			$this->dataAppuntamento = $dataAppuntamento;
			$this->oraAppuntamento = $oraAppuntamento;
		}
		
	}
		
	class Barber{
		public $cognome;
		public $nome;
		public $nomeUBarber;
		public $password;
		public $attivo;
	
		function Barber($cognome = null, $nome = null, $nomeUBarber = null, $password = null, $attivo = null){
			$this->cognome = $cognome;
			$this->nome = $nome;
			$this->nomeUBarber = $nomeUBarber;
			$this->password = $password;
			$this->attivo = $attivo;
		}
		
	}
	
	class ContatoreServizio{
		public $numeroServizio;
		public $contatore;
	
		function ContatoreServizio($numeroServizio = null, $contatore = null){
			$this->numeroServizio = $numeroServizio;
			$this->contatore = $contatore;
		}
		
	}

	class Utente{
		public $nome;
		public $cognome;
		public $dataDiNascita;
		public $nomeUtente;
		public $email;
		public $immagineProfilo;
		public $attivo;
	
		function Utente($nome = null, $cognome = null, $dataDiNascita = null, $nomeUtente = null,
							$email = null, $immagineProfilo = null, $attivo = null){
			$this->nome = $nome;
			$this->cognome = $cognome;
			$this->dataDiNascita = $dataDiNascita;
			$this->nomeUtente = $nomeUtente;
			$this->email = $email;
			$this->immagineProfilo = $immagineProfilo;
			$this->attivo = $attivo;
		}
		
	}

	class Ferie{
		public $codiceRichiesta;
		public $nomeUBarber;
		public $data1;
		public $data2;
		public $dataRichiesta;
		
		function Ferie($codiceRichiesta = null, $nomeUBarber = null, $data1 = null, $data2 = null, 
							$dataRichiesta = null){
			$this->codiceRichiesta = $codiceRichiesta;
			$this->nomeUBarber = $nomeUBarber;
			$this->data1 = $data1;
			$this->data2 = $data2;
			$this->dataRichiesta = $dataRichiesta;
		}
		
	}

?>