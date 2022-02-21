function utenteGestoreEventi(){}

utenteGestoreEventi.DEFAULT_METHOD = "GET";
utenteGestoreEventi.URL_FORM = "./ajax/caricatoreForm.php";
utenteGestoreEventi.URL_GESTIONE = "./ajax/interazioniUtenti.php";
utenteGestoreEventi.ASYNC_TYPE = true;

utenteGestoreEventi.SUCCESS_RESPONSE = "0";

utenteGestoreEventi.ON_CHANGE = "onChange";
utenteGestoreEventi.ANNULLA = "1";
utenteGestoreEventi.PRENOTA = "2";
utenteGestoreEventi.CONTROLLA_NOME_UTENTE = "3";
utenteGestoreEventi.CAMBIO_PASSWORD = "4";
utenteGestoreEventi.VECCHIA_PASSWORD = "5";

//Selezione giorno e barber da parte dell'utente cliente -> visualizzazione degli orari ancora 
//disponibili per quel giorno - barber
utenteGestoreEventi.onChange = 
	function(data, barber) {
		var inserimenti = document.getElementsByClassName("ins_dati");
		if(inserimenti[0].value != "" && inserimenti[1].value != ""){
			if(data == null){
				data = inserimenti[0].value;
			}
			if(barber == null){
				barber = inserimenti[1].value;
			}
			var queryString = "?data=" + data + "&barber=" + barber + "&evento=" + utenteGestoreEventi.ON_CHANGE;
			var url = utenteGestoreEventi.URL_FORM + queryString;
			var responseFunction = utenteGestoreEventi.onAjaxResponseChange;
		
			AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
											url, utenteGestoreEventi.ASYNC_TYPE, 
											null, responseFunction);
		}
	}

//Annullamento di un appuntamento non ancora da parte di un utente cliente
utenteGestoreEventi.annulla = 
	function(codiceAppuntamento) {
		var queryString = "?codiceAppuntamento=" + codiceAppuntamento + "&evento=" + utenteGestoreEventi.ANNULLA;
		var url = utenteGestoreEventi.URL_GESTIONE + queryString;
		var responseFunction = utenteGestoreEventi.onAjaxResponseGestione;
	
		AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
										url, utenteGestoreEventi.ASYNC_TYPE, 
										null, responseFunction);
	}

//Visualizzazione alert contenente il riepilogo dell'appuntamento che l'utente cliente sta cercando di 
//prenotare
utenteGestoreEventi.riepilogoAppuntamento = 
	function() {
		var inserimenti = document.getElementsByClassName("ins_dati");

		var modulo = document.getElementsByClassName("id1");
		if(modulo[0].firstChild !== null){
			modulo[0].removeChild(modulo[0].firstChild);
		}

		DashboardUtente.creaPopupConferma(inserimenti[0].value, inserimenti[1].value,
											inserimenti[2].value, inserimenti[3].value);

		DashboardUtente.pulisciSelezioni();
	}

//Prenotazione da parte dell'utente cliente di un nuovo appuntamento
utenteGestoreEventi.prenotaAppuntamento =
	function(data, barber, orario, servizio){
		var queryString = "?data=" + data + "&barber=" + barber + "&orario=" + orario +
							"&servizio=" + servizio + "&evento=" + utenteGestoreEventi.PRENOTA;
		var url = utenteGestoreEventi.URL_GESTIONE + queryString;
		var responseFunction = utenteGestoreEventi.onAjaxResponseGestione;
	
		AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
										url, utenteGestoreEventi.ASYNC_TYPE, 
										null, responseFunction);
	}

//Verifica se il nome utente scelto in fase di registrazione e' univoco o se gia' esiste un utente 
//con lo stesso nome utente registrato al sito
utenteGestoreEventi.controllaSeGiaEsistente =
	function(nomeUtente){
		var nomeUtente = document.getElementById("nome_utente_reg");
		if(nomeUtente.style.borderColor == "green"){
			var queryString = "?nomeUtente=" + nomeUtente.value + "&evento=" + utenteGestoreEventi.CONTROLLA_NOME_UTENTE;
			var url = utenteGestoreEventi.URL_GESTIONE + queryString;
			var responseFunction = utenteGestoreEventi.onAjaxResponseRicercaNomeUtente;

			AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
											url, utenteGestoreEventi.ASYNC_TYPE, 
											null, responseFunction);
		}
	}

//Evento di cambio password per l'utente cliente
utenteGestoreEventi.cambiaPassword =
	function(nomeUtente){
		var vecchia = document.getElementById("password_vecchia");
		var nuova = document.getElementById("password_nuova");
		var ripeti = document.getElementById("ripeti_nuova_password");

		if(vecchia.style.borderColor == "green" && nuova.style.borderColor == "green"
			&& ripeti.style.borderColor == "green"){
			var queryString = "?nuova=" + nuova.value + "&nomeUtente=" + nomeUtente 
								+ "&evento=" + utenteGestoreEventi.CAMBIO_PASSWORD;
			var url = utenteGestoreEventi.URL_GESTIONE + queryString;
			var responseFunction = utenteGestoreEventi.onAjaxResponseCambioPassword;

			AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
											url, utenteGestoreEventi.ASYNC_TYPE, 
											null, responseFunction);
		}
		else{
			if(vecchia.value == "")
      			setStile('password_vecchia', false);
    		if(nuova.value == "")
      			setStile('password_nuova', false);
    		if(ripeti.value == "")
      			setStile('ripeti_nuova_password', false);
      	}
	}

//Controllo che la vecchia password inserita sia corretta durate la procedura di cambio password 
//dell'utente cliente
utenteGestoreEventi.verificaVecchiaPassword = 
	function(vecchia, nomeUtente){
		if(vecchia !==''){
			var queryString = "?vecchia=" + vecchia + "&nomeUtente=" + nomeUtente
								+ "&evento=" + utenteGestoreEventi.VECCHIA_PASSWORD;
			var url = utenteGestoreEventi.URL_GESTIONE + queryString;
			var responseFunction = utenteGestoreEventi.onAjaxResponseVecchiaPassword;

			AjaxManager.eseguiAjaxRequest(utenteGestoreEventi.DEFAULT_METHOD, 
											url, utenteGestoreEventi.ASYNC_TYPE, 
											null, responseFunction);
		}else
			setStile("password_vecchia", false);
	}

utenteGestoreEventi.onAjaxResponseChange = 
	function(risposta){
		for(var i = 0; i < risposta.length; i++){
			if (risposta[i].codiceRisposta === utenteGestoreEventi.SUCCESS_RESPONSE){
				DashboardUtente.rimuoviContenuto(2);
				DashboardUtente.setOrario(risposta[i].dati);
			}
		}
	}

utenteGestoreEventi.onAjaxResponseGestione =
	function(risposta){
		chiudiX();
		if (risposta.codiceRisposta !== utenteGestoreEventi.SUCCESS_RESPONSE){
			DashboardUtente.riprova(risposta.messaggio); 
		}
		else{
			CaricatoreAppuntamenti.CaricaDati(1);	//APPUNTAMENTI_UTENTE
		}
		DashboardUtente.pulisciSelezioni();
	}


utenteGestoreEventi.onAjaxResponseRicercaNomeUtente =
	function(risposta){
		if (risposta.codiceRisposta !== utenteGestoreEventi.SUCCESS_RESPONSE){
			setStile("nome_utente_reg", false);
		}
		else{
			setStile("nome_utente_reg", true);
		}
	}


utenteGestoreEventi.onAjaxResponseCambioPassword =
	function(risposta){
		if (risposta.codiceRisposta !== utenteGestoreEventi.SUCCESS_RESPONSE){
			DashboardUtente.riprova(risposta.messaggio);
		}
		else{
			DashboardUtente.alertSuccesso("Cambio password avvenuto con successo!");
			DashboardUtente.cambiaPassword();
			pulisciStile("ripeti_nuova_password");
			pulisciStile("password_nuova");
			pulisciStile("password_vecchia");
			document.getElementById("password_vecchia").value = '';
			document.getElementById("password_nuova").value = '';
			document.getElementById("ripeti_nuova_password").value = '';
		}
	}
	

utenteGestoreEventi.onAjaxResponseVecchiaPassword =
	function(risposta){
		if (risposta.codiceRisposta !== utenteGestoreEventi.SUCCESS_RESPONSE){
			setStile("password_vecchia", false);
		}
		else{
			setStile("password_vecchia", true);
		}
	}