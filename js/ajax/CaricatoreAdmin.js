function CaricatoreAdmin(){}

CaricatoreAdmin.DEFAUL_METHOD = "GET";
CaricatoreAdmin.URL_OPERAZIONI_ADMIN = "./ajax/operazioniAdmin.php";

CaricatoreAdmin.ASYNC_TYPE = true;

CaricatoreAdmin.RISPOSTA_OK = "0";
CaricatoreAdmin.NO_DATI = "-1";
CaricatoreAdmin.CARICA_DASHBOARD = "1";
CaricatoreAdmin.STATO_BARBER = "2";
CaricatoreAdmin.STATO_UTENTE = "3";
CaricatoreAdmin.CREA_BARBER = "4";
CaricatoreAdmin.CARICA_RICHIESTE = "5";
CaricatoreAdmin.CARICA_ACCETTATE = "6";
CaricatoreAdmin.STATO_RICHIESTA = "7";

//Richiesta caricamento dati relativi agli utenti
CaricatoreAdmin.CaricaDashboardAmministrazione =
	function(){
		var queryString = "?tipoOperazione=" + CaricatoreAdmin.CARICA_DASHBOARD;
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		var funzioneRisposta = CaricatoreAdmin.onAjaxResponseDashboard;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}	

//Abilitazione/disabilitazione account utente e/o barber
CaricatoreAdmin.CambiaStatoAccount = 
	function(i, nomeUtente, attivo){
		var queryString;
		var funzioneRisposta;
		if(i == 2){
			queryString = "?tipoOperazione=" + CaricatoreAdmin.STATO_BARBER + "&nomeUtente=" + nomeUtente + "&attivo=" + attivo;
			funzioneRisposta = CaricatoreAdmin.onAjaxResponseRefreshPersonale;
		}
		if(i == 3){
			queryString = "?tipoOperazione=" + CaricatoreAdmin.STATO_UTENTE + "&nomeUtente=" + nomeUtente + "&attivo=" + attivo;
			funzioneRisposta = CaricatoreAdmin.onAjaxResponseRefreshUtenti;
		}
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}
	
//Creazione utente barber
CaricatoreAdmin.CreaBarber = 
	function() {
		var inserimenti = document.getElementsByClassName("ins_barber");
		if(inserimenti[0].value == '' || inserimenti[1].value == '' || inserimenti[2].value == ''
			|| inserimenti[3].value == ''){
			DashboardAdmin.riprova("Compilare tutti i campi prima di procedere");  
			return;
		}

		var queryString = "?tipoOperazione=" + CaricatoreAdmin.CREA_BARBER + 
							"&cognome=" + inserimenti[0].value + "&nome="  + inserimenti[1].value + 
							"&nomeUBarber=" + inserimenti[2].value + "&password=" + inserimenti[3].value;
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		var funzioneRisposta = CaricatoreAdmin.onAjaxResponseRefreshPersonale;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}

//Richiesta caricamento delle ferie richieste dai barber
CaricatoreAdmin.CaricaRichiesteFerie = 
	function(){
		var intestazioni = document.getElementsByClassName("scelta_visuale");
		intestazioni[0].setAttribute("class", "selezionato scelta_visuale");
		intestazioni[2].setAttribute("class", "non_selezionato scelta_visuale");
		DashboardRichiestaFerie.rimuoviContenuto("contenitore_accettate");
		var queryString = "?tipoOperazione=" + CaricatoreAdmin.CARICA_RICHIESTE;
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		var funzioneRisposta = CaricatoreAdmin.onAjaxResponseCaricaRichiesteFerie;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}

//Richiesta caricamento delle ferie gia accettate in precedenza
CaricatoreAdmin.CaricaFerieAccettate = 
	function(){
		var intestazioni = document.getElementsByClassName("scelta_visuale");
		intestazioni[0].setAttribute("class", "non_selezionato scelta_visuale");
		intestazioni[2].setAttribute("class", "selezionato scelta_visuale");
		DashboardAdmin.rimuoviContenutoRichieste();
		var queryString = "?tipoOperazione=" + CaricatoreAdmin.CARICA_ACCETTATE;
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		var funzioneRisposta = CaricatoreAdmin.onAjaxResponseCaricaFerieAccettate;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}

//Accetta/rifiuta della richiesta da parte di un barber delle ferie
CaricatoreAdmin.CambiaStatoRichiesta =
	function(codiceRichiesta, si_no){
		var queryString = "?tipoOperazione=" + CaricatoreAdmin.STATO_RICHIESTA + 
							"&codiceRichiesta=" + codiceRichiesta + "&si_no=" + si_no;
		var url = CaricatoreAdmin.URL_OPERAZIONI_ADMIN + queryString;
		var funzioneRisposta = CaricatoreAdmin.onAjaxResponseCaricaRichiesteFerie;
		AjaxManager.eseguiAjaxRequest(CaricatoreAdmin.DEFAUL_METHOD, 
										url, CaricatoreAdmin.ASYNC_TYPE, 
										null, funzioneRisposta);
	}

CaricatoreAdmin.onAjaxResponseDashboard =
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreAdmin.NO_DATI){
			var alert = document.getElementsByClassName("alert");
			alert[0].setAttribute("class", "alert alert_no_imm");
			DashboardAdmin.riprova("Non sono presenti barber registrati!");  
		}
		if(risposta.codiceRisposta === CaricatoreAdmin.RISPOSTA_OK){
			DashboardAdmin.aggiornaDatiPersonale(risposta.dati[0]);
			DashboardAdmin.aggiornaDatiUtenti(risposta.dati[1]);
		}
	}

CaricatoreAdmin.onAjaxResponseRefreshPersonale = 
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreAdmin.NO_DATI){
			DashboardAdmin.riprova("Non è stato possibile eseguire l'operazione!");  
		}
		if(risposta.codiceRisposta === CaricatoreAdmin.RISPOSTA_OK){
			DashboardAdmin.aggiornaDatiPersonale(risposta.dati[0]);
		}
	}

CaricatoreAdmin.onAjaxResponseRefreshUtenti = 
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreAdmin.NO_DATI){
			DashboardAdmin.riprova("Non è stato possibile eseguire l'operazione!");  
		}
		if(risposta.codiceRisposta === CaricatoreAdmin.RISPOSTA_OK){
			DashboardAdmin.aggiornaDatiUtenti(risposta.dati[1]);
		}
	}

CaricatoreAdmin.onAjaxResponseCaricaRichiesteFerie = 
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreAdmin.NO_DATI){
			DashboardAdmin.rimuoviContenutoRichieste();
			DashboardAdmin.riprova(risposta.messaggio); 
		}
		if(risposta.codiceRisposta === CaricatoreAdmin.RISPOSTA_OK){
			DashboardAdmin.aggiornaRichieste(risposta.dati);
		}
	}

CaricatoreAdmin.onAjaxResponseCaricaFerieAccettate = 
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreAdmin.NO_DATI){
			DashboardAdmin.riprova(risposta.messaggio);  
		}
		if(risposta.codiceRisposta === CaricatoreAdmin.RISPOSTA_OK){
			DashboardRichiestaFerie.CaricaFerie(risposta.dati, "contenitore_accettate", 1);
		}	
	}

