function CaricatoreUtente(){}

CaricatoreUtente.DEFAUL_METHOD = "GET";
CaricatoreUtente.URL_FORM = "./ajax/caricatoreForm.php";
CaricatoreUtente.URL_PAGINA_UTENTE = "./ajax/paginaUtente.php";
CaricatoreUtente.URL_CALENDARIO = "./ajax/caricatoreCalendario.php";

CaricatoreUtente.ASYNC_TYPE = true;

CaricatoreUtente.RISPOSTA_OK = "0";
CaricatoreUtente.NO_DATI = "-1";

//Caricamento elementi del form per prenotare un appuntamento dalla parte dell'utente cliente
CaricatoreUtente.CaricaDati =
	function(){
		var url = CaricatoreUtente.URL_FORM;
		var funzioneRisposta = CaricatoreUtente.onAjaxResponseDati;
		AjaxManager.eseguiAjaxRequest(CaricatoreUtente.DEFAUL_METHOD, 
						url, CaricatoreUtente.ASYNC_TYPE, 
						null, funzioneRisposta);
	}

//Caricamento dati del profilo dell'utente cliente
CaricatoreUtente.CaricaProfilo =
	function(){
		var url = CaricatoreUtente.URL_PAGINA_UTENTE;
		var funzioneRisposta = CaricatoreUtente.onAjaxResponseProfilo;
		AjaxManager.eseguiAjaxRequest(CaricatoreUtente.DEFAUL_METHOD, 
						url, CaricatoreUtente.ASYNC_TYPE, 
						null, funzioneRisposta);
	}

//Richiesta di ferie da parte di un utente barber
CaricatoreUtente.SegnaFerieCalendario = 
	function(nomeUtente){
		var url = CaricatoreUtente.URL_CALENDARIO + "?nomeUtente=" + nomeUtente;
		var funzioneRisposta = CaricatoreUtente.onAjaxResponseCalendario;
		AjaxManager.eseguiAjaxRequest(CaricatoreUtente.DEFAUL_METHOD, 
						url, CaricatoreUtente.ASYNC_TYPE, 
						null, funzioneRisposta);
	}
	
CaricatoreUtente.onAjaxResponseDati = 
	function(risposta){
		for(var i = 0; i < 3; i++){
			if(risposta[i].codiceRisposta === CaricatoreUtente.NO_DATI){
				DashboardUtente.aggiornaDati(null, i);
			}
			if (risposta[i].codiceRisposta === CaricatoreUtente.RISPOSTA_OK){
				DashboardUtente.aggiornaDati(risposta[i].dati, i); 
			}
		}
	}

CaricatoreUtente.onAjaxResponseProfilo = 
	function(risposta){
		if(risposta[0].codiceRisposta === CaricatoreUtente.NO_DATI 
			|| risposta[1].codiceRisposta === CaricatoreUtente.NO_DATI){
			DashboardUtente.riprova("Errore nel caricamento dei dati richiesti, riprovare più tardi");  
		}
		if(risposta[0].codiceRisposta === CaricatoreUtente.RISPOSTA_OK){
			DashboardUtente.rimuoviDatiProfilo();
			DashboardUtente.caricaProfilo(risposta[0].dati);
		} 
		if(risposta[1].codiceRisposta === CaricatoreUtente.RISPOSTA_OK){
			if(risposta[0].codiceRisposta !== CaricatoreUtente.RISPOSTA_OK){
				DashboardUtente.rimuoviDatiProfilo();
			}
			DashboardUtente.caricaContatori(risposta[1].dati);  
		}
	}

CaricatoreUtente.onAjaxResponseCalendario = 
	function(risposta){
		if(risposta.codiceRisposta === CaricatoreUtente.NO_DATI){
			DashboardUtente.riprova(risposta.messaggio);  
		}
		if (risposta.codiceRisposta === CaricatoreUtente.RISPOSTA_OK && risposta.messaggio != ""){
			DashboardUtente.segnaFerieCalendario(risposta.messaggio);
		}
	}
