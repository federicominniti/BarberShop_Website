function DashboardRichiestaFerie(){}

//Chiusura dell'alert per la notifica degli errori nella pagina del piano ferie
DashboardRichiestaFerie.chiudiAlert = 
	function(){
		var alert = document.getElementsByClassName("alert");
		while(alert[0].firstChild !== null){
			alert[0].removeChild(alert[0].firstChild);
		}
		alert[0].style.backgroundColor='#414042';
		alert[0].setAttribute("class", "alert");
	}

//Creazione dell'alert per la notifica degli errori nella pagina del piano ferie
DashboardRichiestaFerie.riprova = 
	function(messaggio){
		var span = document.createElement("span");
		span.setAttribute("class", "chiudi_alert");
		span.setAttribute("onclick", "DashboardRichiestaFerie.chiudiAlert()");
		span.setAttribute("title","Chiudi alert");
		span.textContent = '\u2718';

		var testo = document.createElement("p");
		testo.textContent = messaggio;
		testo.setAttribute("class", "testo_alert");

		var alert = document.getElementsByClassName("alert");
		alert[0].appendChild(span);
		alert[0].appendChild(testo);
		alert[0].style.backgroundColor='#f44336';
		alert[0].style.display="block";
		alert[0].setAttribute("class", "alert alert_no_imm");
	}

//Rimozione record relativi alle tabelle di gestione delle ferie dell'utente barber
DashboardRichiestaFerie.rimuoviContenuto = 
	function(tabella){
		DashboardRichiestaFerie.chiudiAlert();
		var contenitoreTabella = document.getElementById(tabella);
		if (contenitoreTabella === null)
			return;

		var firstChild = contenitoreTabella.firstChild;
		if (firstChild !== null)
			contenitoreTabella.removeChild(firstChild);
	}

//Creazione delle tabelle relative al piano ferie dell'utente barber
DashboardRichiestaFerie.creaTabellaFerie =
	function(pending, admin){
		var tabella = document.createElement("table");
		tabella.setAttribute("class", "tabella_ferie");
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_ferie");
		var thEl1 = document.createElement("th");
		if(admin == 0)
			thEl1.setAttribute("class", "col_ferie grand_colonna");
		else
			thEl1.setAttribute("class", "col_ferie grand_colonna5");
		thEl1.textContent = "Codice richiesta";
		var thEl2 = document.createElement("th");
		if(admin == 0)
			thEl2.setAttribute("class", "col_ferie grand_colonna");
		else
			thEl2.setAttribute("class", "col_ferie grand_colonna5");
		thEl2.textContent = "Data inizio";
		var thEl3 = document.createElement("th");
		if(admin == 0)
			thEl3.setAttribute("class", "col_ferie grand_colonna");
		else
			thEl3.setAttribute("class", "col_ferie grand_colonna5");
		thEl3.textContent = "Data fine";
		var thEl4 = document.createElement("th");
		if(admin == 0)
			thEl4.setAttribute("class", "col_ferie grand_colonna");
		else
			thEl4.setAttribute("class", "col_ferie grand_colonna5");
		thEl4.textContent = "Data richiesta";
		if(pending == true){
			var thEl5 = document.createElement("th");
			if(admin == 0)
				thEl5.setAttribute("class", "col_ferie grand_colonna");
			else
				thEl5.setAttribute("class", "col_ferie grand_colonna5");
			thEl5.textContent = "Elimina";
		}

		if(admin == 1){
			var thEl6 = document.createElement("th");
			thEl6.setAttribute("class", "col_ferie grand_colonna5");
			thEl6.textContent = "Nome utente";
		}

		trEl.appendChild(thEl1);
		if(admin == 1)
			trEl.appendChild(thEl6);
		trEl.appendChild(thEl2);
		trEl.appendChild(thEl3);
		trEl.appendChild(thEl4);
		if(pending == true)
			trEl.appendChild(thEl5);

		tabella.appendChild(trEl);	
		return tabella;
	}

//Creazione di un record inerente ad una richiesta di ferie effettuata da un utente barber
DashboardRichiestaFerie.creaElTabella = 	
	function(dato, pending, admin){
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_ferie");
		
		var tdEl1 = document.createElement("td");
		if(admin == 0)
			tdEl1.setAttribute("class", "col_ferie grand_colonna");
		else
			tdEl1.setAttribute("class", "col_ferie grand_colonna5");
		tdEl1.textContent = dato.codiceRichiesta;
		var tdEl2 = document.createElement("td");
		if(admin == 0)
			tdEl2.setAttribute("class", "col_ferie grand_colonna");
		else
			tdEl2.setAttribute("class", "col_ferie grand_colonna5");
		tdEl2.textContent = dato.data1;
		var tdEl3 = document.createElement("td");
		if(admin == 0)
			tdEl3.setAttribute("class", "col_ferie grand_colonna");
		else
			tdEl3.setAttribute("class", "col_ferie grand_colonna5");
		tdEl3.textContent = dato.data2;
		var tdEl4 = document.createElement("td");
		if(admin == 0)
			tdEl4.setAttribute("class", "col_ferie grand_colonna");
		else
			tdEl4.setAttribute("class", "col_ferie grand_colonna5");
		tdEl4.textContent = dato.dataRichiesta;
		if(pending == true){
			var tdEl5 = document.createElement("td");
			if(admin == 0)
				tdEl5.setAttribute("class", "col_dashboard grand_colonna elimina");
			else
				tdEl5.setAttribute("class", "col_dashboard grand_colonna5 elimina");
			tdEl5.textContent = '\u2718';
			tdEl5.setAttribute("onClick", "barberGestoreEventi.eliminaRichiesta(" + dato.codiceRichiesta + ")");
		}
		if(admin == 1){
			var tdEl6 = document.createElement("td");
			tdEl6.setAttribute("class", "col_dashboard grand_colonna5");
			tdEl6.textContent = dato.nomeUBarber;
		}

		trEl.appendChild(tdEl1);
		if(admin == 1)
			trEl.appendChild(tdEl6);
		trEl.appendChild(tdEl2);
		trEl.appendChild(tdEl3);
		trEl.appendChild(tdEl4);
		if(pending == true)
			trEl.appendChild(tdEl5);

		return trEl; 
	}

//Caricamento e aggiornamento delle tabelle inerenti alle ferie del piano ferie dell'utente barber
DashboardRichiestaFerie.CaricaFerie = 
	function(dati, id, admin = 0){
		DashboardRichiestaFerie.rimuoviContenuto(id);
		
		var pending = false;
		if(id == "contenitore_pending")
			pending = true;
		var nuovaTabella = DashboardRichiestaFerie.creaTabellaFerie(pending, admin);
		if(dati != null){
			for (var j = 0; j < dati.length; j++){
				var riga = DashboardRichiestaFerie.creaElTabella(dati[j], pending, admin);
				nuovaTabella.appendChild(riga);
			}
		}

		var contenitoreTabella = document.getElementById(id);
		contenitoreTabella.appendChild(nuovaTabella);
	}

