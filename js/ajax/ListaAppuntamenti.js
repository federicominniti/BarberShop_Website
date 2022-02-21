function ListaAppuntamenti(){}

//Rimozione appuntamenti dei record dalle tabelle degli appuntamenti prenotati e/o svolti
ListaAppuntamenti.rimuoviContenuto = 
	function(i){
		var contenitoreTabella = document.getElementsByClassName("contenitore_tabella");
		if (contenitoreTabella[i] === null)
			return;

		var firstChild = contenitoreTabella[i].firstChild;
		if (firstChild !== null)
			contenitoreTabella[i].removeChild(firstChild);
	}

//Visualizzazione della lista degli appuntamenti vuota qualora non siano presenti appuntamenti fissati
// e/o svolti 
ListaAppuntamenti.setListaVuota = 
	function(i){
		ListaAppuntamenti.rimuoviContenuto(i);
		var warningDivElem = document.createElement("div");
		warningDivElem.setAttribute("class", "warning");
		var warningSpanElem = document.createElement("span");
		warningSpanElem.textContent = "Non ci sono appuntamenti da caricare";

		var contenitoreTabella = document.getElementsByClassName("contenitore_tabella");
		contenitoreTabella[i].insertBefore(warningSpanElem, contenitoreTabella[i].firstChild);
	}

//Aggiornamento della visualizzazione delle tabelle relative agli appuntamenti
ListaAppuntamenti.aggiornaDati =
	function(dati, i, tipoRicerca){
		ListaAppuntamenti.rimuoviContenuto(i);
		
		var nuovaTabella = ListaAppuntamenti.creaTabella(i, tipoRicerca);

		if(dati != null){
			for (var j = 0; j < dati.length; j++){
				var riga = ListaAppuntamenti.creaElTabella(dati[j], i, tipoRicerca);
				nuovaTabella.appendChild(riga);
			}
		}		

		var contenitoreTabella = document.getElementsByClassName("contenitore_tabella");
		contenitoreTabella[i].insertBefore(nuovaTabella, contenitoreTabella[i].firstChild);
	}
	
//Creazione delle tabelle per gli appuntamenti
ListaAppuntamenti.creaTabella = 
	function(i, tipoRicerca){
		var tabella = document.createElement("table");
		tabella.setAttribute("class", "appuntamenti_barber");
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_appuntamenti");
		var thEl1 = document.createElement("th");
		thEl1.setAttribute("class", "col_appuntamenti grand_colonna");
		switch(tipoRicerca){
				case "0":
					thEl1.textContent = "Nome utente";
					break;
				case "1":
					thEl1.textContent = "Barber";
					break;
		}
		var thEl2 = document.createElement("th");
		thEl2.setAttribute("class", "col_appuntamenti grand_colonna");
		thEl2.textContent = "Data appuntamento";
		var thEl3 = document.createElement("th");
		thEl3.setAttribute("class", "col_appuntamenti grand_colonna");
		thEl3.textContent = "Orario appuntamento";
		var thEl4 = document.createElement("th");
		thEl4.setAttribute("class", "col_appuntamenti grand_colonna");
		thEl4.textContent = "Servizio";
		if(i == 0){
			var thEl5 = document.createElement("th");
			thEl5.setAttribute("class", "col_appuntamenti fatto_annulla");
			switch(tipoRicerca){
				case "0":
					thEl5.textContent = "Fatto";
					break;
				case "1":
					thEl5.textContent = "Annulla";
					break;
			}
		}

		trEl.appendChild(thEl1);
		trEl.appendChild(thEl2);
		trEl.appendChild(thEl3);
		trEl.appendChild(thEl4);
		if(i == 0){
			trEl.appendChild(thEl5);
		}
		tabella.appendChild(trEl);

		return tabella;
	}

//Creazione di un record delle tabelle relative agli appuntamenti prenotati e/o fatti
ListaAppuntamenti.creaElTabella = 	
	function(dato, i, tipoRicerca){

		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_appuntamenti");
		
		var tdEl1 = document.createElement("td");
		tdEl1.setAttribute("class", "col_appuntamenti grand_colonna");
		tdEl1.textContent = dato.nomeUtente;
		var tdEl2 = document.createElement("td");
		tdEl2.setAttribute("class", "col_appuntamenti grand_colonna");
		tdEl2.textContent = dato.dataAppuntamento;
		var tdEl3 = document.createElement("td");
		tdEl3.setAttribute("class", "col_appuntamenti grand_colonna");
		tdEl3.textContent = (dato.oraAppuntamento).substring(0,5);
		var tdEl4 = document.createElement("td");
		tdEl4.setAttribute("class", "col_appuntamenti grand_colonna");
		tdEl4.textContent = dato.nomeServizio;
		if(i == 0){
			var tdEl5 = document.createElement("td");
			tdEl5.setAttribute("class", "col_appuntamenti");
			var spanEl = document.createElement("span");
			switch(tipoRicerca){
				case "0":
					spanEl.setAttribute("onClick", "barberGestoreEventi.fatto("+ dato.codiceAppuntamento + ")");
					spanEl.setAttribute("class", "spunta_fatto");
					spanEl.textContent = '\u2714';
					break;
				case "1":
					spanEl.setAttribute("onClick", "utenteGestoreEventi.annulla("+ dato.codiceAppuntamento + ")");
					spanEl.setAttribute("class", "annulla_appuntamento");
					spanEl.textContent = '\u2718';
					break;
			}
			
			tdEl5.appendChild(spanEl);
		}

		trEl.appendChild(tdEl1);
		trEl.appendChild(tdEl2);
		trEl.appendChild(tdEl3);
		trEl.appendChild(tdEl4);
		if(i == 0){
			trEl.appendChild(tdEl5);
		}

		return trEl; 
	}
	
//Gestione frecce per navigazione delle tabelle degli appuntamenti
ListaAppuntamenti.aggiornaElNavigazione = 
	function(paginaCorrente, datiFiniti, i){
		var elementoPagCorrente = document.getElementsByClassName("pagina_corrente");
		elementoPagCorrente[i].textContent = "Pagina " + paginaCorrente;
		
		var elementoPrecedente = document.getElementsByClassName("precedente");
		if (paginaCorrente === 1) // abilita evento precedente
			elementoPrecedente[i].disabled = true;
		else // abilita evento precedente
			elementoPrecedente[i].disabled = false;
		
		var prossimoElemento = document.getElementsByClassName("successivo");
		if (datiFiniti) // disabilita evento successivo
			prossimoElemento[i].disabled = true;
		else // abilita evento successivo
			prossimoElemento[i].disabled = false;	
	}
	