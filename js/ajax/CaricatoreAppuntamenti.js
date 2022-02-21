function CaricatoreAppuntamenti(){}

CaricatoreAppuntamenti.DEFAUL_METHOD = "GET";
CaricatoreAppuntamenti.URL_REQUEST = "./ajax/caricatoreAppuntamenti.php";

CaricatoreAppuntamenti.ASYNC_TYPE = true;

//F = FATTI
//NF = NON FATTI
CaricatoreAppuntamenti.APP_DA_CARICARE = [2, 5];
CaricatoreAppuntamenti.CURRENT_PAGE_INDEX = [1, 1];

CaricatoreAppuntamenti.SUCCESS_RESPONSE = "0";
CaricatoreAppuntamenti.NO_MORE_DATA = "-1";

CaricatoreAppuntamenti.inizializza = 
	function() {
		CaricatoreAppuntamenti.CURRENT_PAGE_INDEX = [1, 1];
	}

//Caricamento degli appuntamenti prenotati da un utente cliente e della cronologia degli appuntamenti fatti
CaricatoreAppuntamenti.CaricaDati =
	function(tipoRicerca){
		var queryString = "?tipoRicerca=" + tipoRicerca + "&appDaCaricareF=" + CaricatoreAppuntamenti.APP_DA_CARICARE[1]
							+ "&offsetF=" + (CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[1] - 1) * CaricatoreAppuntamenti.APP_DA_CARICARE[1]
							+ "&appDaCaricareNF=" + CaricatoreAppuntamenti.APP_DA_CARICARE[0] 
							+ "&offsetNF=" + (CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[0] - 1) * CaricatoreAppuntamenti.APP_DA_CARICARE[0];
		var url = CaricatoreAppuntamenti.URL_REQUEST + queryString;
		var funzioneRisposta = CaricatoreAppuntamenti.onAjaxResponse;
		AjaxManager.eseguiAjaxRequest(CaricatoreAppuntamenti.DEFAUL_METHOD, 
										url, CaricatoreAppuntamenti.ASYNC_TYPE, 
										null, funzioneRisposta);
	}

//Caricamento degli elementi successivi dopo la pressione della relativa freccia
CaricatoreAppuntamenti.successivo =
	function(tipoRicerca, i){
		CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i]++;
		CaricatoreAppuntamenti.CaricaDati(tipoRicerca);
	}
	
//Caricamento degli elementi successivi dopo la pressione della relativa freccia
CaricatoreAppuntamenti.precedente = 
	function(tipoRicerca, i){
		CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i]--;
		if (CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i] <= 1)
			CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i] = 1;
		
		CaricatoreAppuntamenti.CaricaDati(tipoRicerca);
	}
	
CaricatoreAppuntamenti.onAjaxResponse = 
	function(risposta){
		var MAX = 2;
		for(var i = 0; i < MAX; i++){
			if(risposta[i].codiceRisposta === CaricatoreAppuntamenti.NO_MORE_DATA){
					ListaAppuntamenti.setListaVuota(i);
					ListaAppuntamenti.aggiornaElNavigazione(CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i], true, i);
			}
			
			if (risposta[i].codiceRisposta === CaricatoreAppuntamenti.SUCCESS_RESPONSE){
				ListaAppuntamenti.aggiornaDati(risposta[i].dati, i, risposta[i].tipoRicerca); 
				var datiFiniti = (risposta[i].dati === null || risposta[i].dati.length < CaricatoreAppuntamenti.APP_DA_CARICARE[i]);
				ListaAppuntamenti.aggiornaElNavigazione(CaricatoreAppuntamenti.CURRENT_PAGE_INDEX[i], datiFiniti, i);
			}
		}
	}
	