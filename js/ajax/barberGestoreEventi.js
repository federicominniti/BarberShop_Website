function barberGestoreEventi(){}

barberGestoreEventi.DEFAULT_METHOD = "GET";
barberGestoreEventi.URL_REQUEST = "./ajax/interazioniUtenti.php";
barberGestoreEventi.ASYNC_TYPE = true;

barberGestoreEventi.SUCCESS_RESPONSE = "0";
barberGestoreEventi.NO_DATI = "-1";
barberGestoreEventi.ERRORE = "-2";

barberGestoreEventi.ON_CLICK = "0";
barberGestoreEventi.CARICA_FERIE_ANNO = "8";
barberGestoreEventi.RICHIESTA_FERIE = "7";
barberGestoreEventi.ELIMINA_RICHIESTA = "6";

//Evento di spunta appuntamento 'fatto' da parte del barber
barberGestoreEventi.fatto = 
	function(codiceAppuntamento) {
		var queryString = "?codiceAppuntamento=" + codiceAppuntamento + "&evento=" + barberGestoreEventi.ON_CLICK;
		var url = barberGestoreEventi.URL_REQUEST + queryString;
		var responseFunction = barberGestoreEventi.onAjaxResponse;
	
		AjaxManager.eseguiAjaxRequest(barberGestoreEventi.DEFAULT_METHOD, 
						url, barberGestoreEventi.ASYNC_TYPE, 
						null, responseFunction);
	}

//Caricamento del piano ferie in seguito all'apertura della sezione dedicata
barberGestoreEventi.CaricaFerie = 
	function(nomeUtente){
		var queryString = "?evento=" + barberGestoreEventi.CARICA_FERIE_ANNO + "&nomeUtente=" + nomeUtente;
		var url = barberGestoreEventi.URL_REQUEST + queryString;
		var responseFunction = barberGestoreEventi.onAjaxResponseOperazioneFerie;
	
		AjaxManager.eseguiAjaxRequest(barberGestoreEventi.DEFAULT_METHOD, 
						url, barberGestoreEventi.ASYNC_TYPE, 
						null, responseFunction);
	}

//Eliminazione di una richiesta di ferie eseguita da parte di un barber ma non ancora accettata
barberGestoreEventi.eliminaRichiesta = 
	function(id){
		var queryString = "?evento=" + barberGestoreEventi.ELIMINA_RICHIESTA + "&codiceRichiesta=" + id;
		var url = barberGestoreEventi.URL_REQUEST + queryString;
		var responseFunction = barberGestoreEventi.onAjaxResponseOperazioneFerie;
	
		AjaxManager.eseguiAjaxRequest(barberGestoreEventi.DEFAULT_METHOD, 
						url, barberGestoreEventi.ASYNC_TYPE, 
						null, responseFunction);
	}

//Creazione richiesta di ferie da far approvare all'admin/direttore
barberGestoreEventi.richiediFerie = 
	function(nomeUtente){
		var inserimenti = document.getElementsByClassName("ins_ferie");
		if(inserimenti[0].value == '' || inserimenti[1].value == ''){
			DashboardRichiestaFerie.riprova("Inserisci entrambe le date!"); 
			return; 
		}
		var queryString = "?evento=" + barberGestoreEventi.RICHIESTA_FERIE + "&nomeUtente=" + nomeUtente
							+ "&data1=" + inserimenti[0].value + "&data2=" + inserimenti[1].value;
		var url = barberGestoreEventi.URL_REQUEST + queryString;
		var responseFunction = barberGestoreEventi.onAjaxResponseOperazioneFerie;
	
		AjaxManager.eseguiAjaxRequest(barberGestoreEventi.DEFAULT_METHOD, 
						url, barberGestoreEventi.ASYNC_TYPE, 
						null, responseFunction);
	}

barberGestoreEventi.onAjaxResponse = 
	function(risposta){
		if(risposta.codiceRisposta === barberGestoreEventi.NO_DATI){
			DashboardRichiestaFerie.riprova("Qualcosa è andato storto!");  
		}
		if (risposta.codiceRisposta === barberGestoreEventi.SUCCESS_RESPONSE)
			CaricatoreAppuntamenti.CaricaDati(0);
	}

barberGestoreEventi.onAjaxResponseOperazioneFerie = 
	function(risposta){
		if(risposta.codiceRisposta === barberGestoreEventi.NO_DATI){
			DashboardRichiestaFerie.rimuoviContenuto('contenitore_pending');
			DashboardRichiestaFerie.rimuoviContenuto('contenitore_rifiutate');
			DashboardRichiestaFerie.rimuoviContenuto('contenitore_accettate');
			DashboardRichiestaFerie.riprova(risposta.messaggio);
		}
		if(risposta.codiceRisposta === barberGestoreEventi.ERRORE){
			DashboardRichiestaFerie.riprova(risposta.messaggio);
		}
		if (risposta.codiceRisposta === barberGestoreEventi.SUCCESS_RESPONSE){
			var inserimenti = document.getElementsByClassName("ins_ferie");
			inserimenti[0].value = null;
			inserimenti[1].value = null;
			pulisciStile('data_inizio');
			pulisciStile('data_fine');
			DashboardRichiestaFerie.CaricaFerie(risposta.dati[0], "contenitore_pending");
			DashboardRichiestaFerie.CaricaFerie(risposta.dati[1], "contenitore_rifiutate");
			DashboardRichiestaFerie.CaricaFerie(risposta.dati[2], "contenitore_accettate");
		}
	}

