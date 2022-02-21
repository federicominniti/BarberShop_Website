function DashboardAdmin(){}

//Chiusura dell'alert di notifica degli errori
DashboardAdmin.chiudiAlert = 
	function(){
		var alert = document.getElementsByClassName("alert");
		while(alert[0].firstChild !== null){
			alert[0].removeChild(alert[0].firstChild);
		}
		alert[0].style.backgroundColor='#414042';
		alert[0].setAttribute("class", "alert");
	}

//Visualizzazione di un alert per la notifica degli errori
DashboardAdmin.riprova = 
	function(messaggio){
		DashboardAdmin.chiudiAlert();
		var span = document.createElement("span");
		span.setAttribute("class", "chiudi_alert");
		span.setAttribute("onclick", "DashboardAdmin.chiudiAlert()");
		span.setAttribute("title","Chiudi alert");
		span.textContent = '\u2718';

		var testo = document.createElement("p");
		testo.textContent = messaggio;
		testo.setAttribute("class", "testo_alert");

		var alert = document.getElementsByClassName("alert");
		alert[0].setAttribute("class", "alert alert_no_imm");
		alert[0].appendChild(span);
		alert[0].appendChild(testo);
		alert[0].style.backgroundColor='#f44336';
		alert[0].style.display="block";
	}

//Creazione della tabella contenente i barber con la possibilità di attivare e disattivare gli account
DashboardAdmin.creaTabellaPersonale =
	function(){
		var tabella = document.createElement("table");
		tabella.setAttribute("class", "tabella_dashboard");
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		var thEl1 = document.createElement("th");
		thEl1.setAttribute("class", "col_dashboard grand_colonna");
		thEl1.textContent = "Cognome";
		var thEl2 = document.createElement("th");
		thEl2.setAttribute("class", "col_dashboard grand_colonna");
		thEl2.textContent = "Nome";
		var thEl3 = document.createElement("th");
		thEl3.setAttribute("class", "col_dashboard grand_colonna");
		thEl3.textContent = "Nome utente";
		var thEl4 = document.createElement("th");
		thEl4.setAttribute("class", "col_dashboard grand_colonna");
		thEl4.textContent = "Password";
		var thEl5 = document.createElement("th");
		thEl5.setAttribute("class", "col_dashboard grand_colonna");
		thEl5.textContent = "Stato";

		trEl.appendChild(thEl1);
		trEl.appendChild(thEl2);
		trEl.appendChild(thEl3);
		trEl.appendChild(thEl4);
		trEl.appendChild(thEl5);

		tabella.appendChild(trEl);	
		return tabella;
	}

//Rimozione della tabella dei barber
DashboardAdmin.rimuoviContenuto = 
	function(){
		var contenitoreTabella = document.getElementById("contenitore_personale");
		if (contenitoreTabella === null)
			return;

		var firstChild = contenitoreTabella.firstChild;
		if (firstChild !== null)
			contenitoreTabella.removeChild(firstChild);
	}

//Creazione di un recod corrispondente ad un barber della tabella con il personale
DashboardAdmin.creaElTabella = 	
	function(dato){
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		
		var tdEl1 = document.createElement("td");
		tdEl1.setAttribute("class", "col_dashboard grand_colonna");
		if(dato != null)
			tdEl1.textContent = dato.cognome;
		else{
			var ins1 = document.createElement("input");
			ins1.setAttribute("type", "text");
			ins1.setAttribute("placeholder", "Cognome");
			ins1.setAttribute("name", "cognome");
			ins1.setAttribute("id", "cognome_barber");
			ins1.setAttribute("class", "ins_barber");
			tdEl1.appendChild(ins1);
		}
		var tdEl2 = document.createElement("td");
		tdEl2.setAttribute("class", "col_dashboard grand_colonna");
		if(dato != null)
			tdEl2.textContent = dato.nome;
		else{
			var ins2 = document.createElement("input");
			ins2.setAttribute("type", "text");
			ins2.setAttribute("placeholder", "Nome");
			ins2.setAttribute("name", "nome");
			ins2.setAttribute("id", "nome_barber");
			ins2.setAttribute("class", "ins_barber");
			tdEl2.appendChild(ins2);
		}
		var tdEl3 = document.createElement("td");
		tdEl3.setAttribute("class", "col_dashboard grand_colonna");
		if(dato != null)
			tdEl3.textContent = dato.nomeUBarber;
		else{
			var ins3 = document.createElement("input");
			ins3.setAttribute("type", "text");
			ins3.setAttribute("placeholder", "Nome utente");
			ins3.setAttribute("name", "nome_utente");
			ins3.setAttribute("id", "nome_utente_barber");
			ins3.setAttribute("class", "ins_barber");
			tdEl3.appendChild(ins3);

		}
		var tdEl4 = document.createElement("td");
		tdEl4.setAttribute("class", "col_dashboard grand_colonna");
		if(dato != null)
			tdEl4.textContent = dato.password;
		else{
			var ins4 = document.createElement("input");
			ins4.setAttribute("type", "text");
			ins4.setAttribute("placeholder", "Password");
			ins4.setAttribute("name", "password");
			ins4.setAttribute("id", "password_barber");
			ins4.setAttribute("class", "ins_barber");
			tdEl4.appendChild(ins4);
		}
		var tdEl5 = document.createElement("td");
		tdEl5.setAttribute("class", "col_dashboard grand_colonna");
		if(dato != null && dato.attivo == "1"){
			tdEl5.textContent = "Disattiva";
			tdEl5.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoAccount(2, '" + dato.nomeUBarber + "', " + dato.attivo + ")");
			tdEl5.setAttribute("class", "disattiva");
		}else{
			if(dato != null){
				tdEl5.textContent = "Attiva";
				tdEl5.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoAccount(2, '" + dato.nomeUBarber + "', " + dato.attivo + ")");
				tdEl5.setAttribute("class", "attiva");
			}
			else{
				tdEl5.textContent = '\u2714';
				tdEl5.setAttribute("onClick", "CaricatoreAdmin.CreaBarber()");
				tdEl5.setAttribute("id", "conferma_barber");
			}
		}

		trEl.appendChild(tdEl1);
		trEl.appendChild(tdEl2);
		trEl.appendChild(tdEl3);
		trEl.appendChild(tdEl4);
		trEl.appendChild(tdEl5);

		return trEl; 
	}

//Aggiornamento della tabella contenente gli utenti barber
DashboardAdmin.aggiornaDatiPersonale =
	function(dati){
		DashboardAdmin.rimuoviContenuto();
		
		var nuovaTabella = DashboardAdmin.creaTabellaPersonale();
		if(dati != null){
			for (var j = 0; j < dati.length; j++){
				var riga = DashboardAdmin.creaElTabella(dati[j]);
				nuovaTabella.appendChild(riga);
			}
		}

		var riga = DashboardAdmin.creaElTabella(dati[j]);
		nuovaTabella.appendChild(riga);

		var contenitoreTabella = document.getElementById("contenitore_personale");
		contenitoreTabella.appendChild(nuovaTabella);
	}

//Rimozione della tabella degli utenti clienti registrati al sito
DashboardAdmin.rimuoviContenutoUtenti = 
	function(){
		DashboardAdmin.chiudiAlert();
		
		var contenitoreTabella = document.getElementById("contenitore_utenti");
		if (contenitoreTabella === null)
			return;

		var firstChild = contenitoreTabella.firstChild;
		if (firstChild !== null)
			contenitoreTabella.removeChild(firstChild);
	}

//Creazione della tabella contenente i clienti registrati al sito con la possibilità di attivare 
//e disattivare gli account
DashboardAdmin.creaTabellaUtenti =
	function(){
		var tabella = document.createElement("table");
		tabella.setAttribute("class", "tabella_dashboard");
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		var thEl1 = document.createElement("th");
		thEl1.setAttribute("class", "col_dashboard grand_colonna");
		thEl1.textContent = "Nome";
		var thEl2 = document.createElement("th");
		thEl2.setAttribute("class", "col_dashboard grand_colonna");
		thEl2.textContent = "Cognome";
		var thEl3 = document.createElement("th");
		thEl3.setAttribute("class", "col_dashboard grand_colonna");
		thEl3.textContent = "Nome utente";
		var thEl4 = document.createElement("th");
		thEl4.setAttribute("class", "col_dashboard grand_colonna");
		thEl4.textContent = "Email";
		var thEl5 = document.createElement("th");
		thEl5.setAttribute("class", "col_dashboard grand_colonna");
		thEl5.textContent = "Stato";

		trEl.appendChild(thEl1);
		trEl.appendChild(thEl2);
		trEl.appendChild(thEl3);
		trEl.appendChild(thEl4);
		trEl.appendChild(thEl5);

		tabella.appendChild(trEl);	
		return tabella;
	}

//Creazione di un recod corrispondente ad un utente cliente della tabella con i clienti
DashboardAdmin.creaElTabellaUtenti = 	
	function(dato){
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		
		var tdEl1 = document.createElement("td");
		tdEl1.setAttribute("class", "col_dashboard grand_colonna");
		tdEl1.textContent = dato.nome;
		var tdEl2 = document.createElement("td");
		tdEl2.setAttribute("class", "col_dashboard grand_colonna");
		tdEl2.textContent = dato.cognome;
		var tdEl3 = document.createElement("td");
		tdEl3.setAttribute("class", "col_dashboard grand_colonna");
		tdEl3.textContent = dato.nomeUtente;
		var tdEl4 = document.createElement("td");
		tdEl4.setAttribute("class", "col_dashboard grand_colonna");
		tdEl4.textContent = dato.email;
		var tdEl5 = document.createElement("td");
		tdEl5.setAttribute("class", "col_dashboard grand_colonna");
		if(dato.attivo == "1"){
			tdEl5.textContent = "Disattiva";
			tdEl5.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoAccount(3, '" + dato.nomeUtente + "', " + dato.attivo + ")");
			tdEl5.setAttribute("class", "disattiva");
		}else{
			tdEl5.textContent = "Attiva";
			tdEl5.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoAccount(3, '" + dato.nomeUtente + "', " + dato.attivo + ")");
			tdEl5.setAttribute("class", "attiva");
		}

		trEl.appendChild(tdEl1);
		trEl.appendChild(tdEl2);
		trEl.appendChild(tdEl3);
		trEl.appendChild(tdEl4);
		trEl.appendChild(tdEl5);

		return trEl; 
	}

//Aggiornamento della tabella contenente gli utenti clienti
DashboardAdmin.aggiornaDatiUtenti =
	function(dati){
		DashboardAdmin.rimuoviContenutoUtenti();
		var nuovaTabella = DashboardAdmin.creaTabellaUtenti();

		if(dati != null){
			for (var j = 0; j < dati.length; j++){
				var riga = DashboardAdmin.creaElTabellaUtenti(dati[j]);
				nuovaTabella.appendChild(riga);
			}
		}

		var contenitoreTabella = document.getElementById("contenitore_utenti");
		contenitoreTabella.appendChild(nuovaTabella);
	}

//Rimozione della tabella contenente le richieste di ferie da parte dei barber
DashboardAdmin.rimuoviContenutoRichieste = 
	function(){
		DashboardAdmin.chiudiAlert();
		var contenitoreTabella = document.getElementById("contenitore_richieste");
		if (contenitoreTabella === null)
			return;

		var firstChild = contenitoreTabella.firstChild;
		if (firstChild !== null)
			contenitoreTabella.removeChild(firstChild);
	}

//Creazione della tabella contenente le richieste di ferie da parte del personale (barber) con 
//possibilità di accettarle o rifiutarle quelle 
DashboardAdmin.creaTabellaRichieste =
	function(){
		var tabella = document.createElement("table");
		tabella.setAttribute("class", "tabella_dashboard");
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		var thEl1 = document.createElement("th");
		thEl1.setAttribute("class", "col_dashboard colonna_richieste");
		thEl1.textContent = "Codice richiesta";
		var thEl2 = document.createElement("th");
		thEl2.setAttribute("class", "col_dashboard colonna_richieste");
		thEl2.textContent = "Nome utente";
		var thEl3 = document.createElement("th");
		thEl3.setAttribute("class", "col_dashboard colonna_richieste");
		thEl3.textContent = "Data inizio";
		var thEl4 = document.createElement("th");
		thEl4.setAttribute("class", "col_dashboard colonna_richieste");
		thEl4.textContent = "Data fine";
		var thEl5 = document.createElement("th");
		thEl5.setAttribute("class", "col_dashboard colonna_richieste");
		thEl5.textContent = "Data richiesta";
		var thEl6 = document.createElement("th");
		thEl6.setAttribute("class", "col_dashboard colonna_richieste");
		thEl6.textContent = "Azione";

		trEl.appendChild(thEl1);
		trEl.appendChild(thEl2);
		trEl.appendChild(thEl3);
		trEl.appendChild(thEl4);
		trEl.appendChild(thEl5);
		trEl.appendChild(thEl6);

		tabella.appendChild(trEl);	
		return tabella;
	}

//Creazione di un recod corrispondente ad una richiesta di ferie da parte di un barber
DashboardAdmin.creaElTabellaRichieste = 	
	function(dato){
		var trEl = document.createElement("tr");
		trEl.setAttribute("class", "riga_dashboard");
		
		var tdEl1 = document.createElement("td");
		tdEl1.setAttribute("class", "col_dashboard colonna_richieste");
		tdEl1.textContent = dato.codiceRichiesta;
		var tdEl2 = document.createElement("td");
		tdEl2.setAttribute("class", "col_dashboard colonna_richieste");
		tdEl2.textContent = dato.nomeUBarber;
		var tdEl3 = document.createElement("td");
		tdEl3.setAttribute("class", "col_dashboard colonna_richieste");
		tdEl3.textContent = dato.data1;
		var tdEl4 = document.createElement("td");
		tdEl4.setAttribute("class", "col_dashboard colonna_richieste");
		tdEl4.textContent = dato.data2;
		var tdEl5 = document.createElement("td");
		tdEl5.setAttribute("class", "col_dashboard colonna_richieste");
		tdEl5.textContent = dato.dataRichiesta;
		var tdEl6 = document.createElement("td");
		tdEl6.setAttribute("class", "col_dashboard colonna_richieste");
			
		var accetta = document.createElement("p");
		accetta.setAttribute("class", "attiva pulsantiera");
		accetta.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoRichiesta('" + dato.codiceRichiesta + "', 1)");
		accetta.textContent = '\u2714';

		var barra = document.createElement("p");
		barra.textContent = "/";
		barra.setAttribute("class", "pulsantiera");

		var rifiuta = document.createElement("p");
		rifiuta.setAttribute("class", "disattiva pulsantiera");
		rifiuta.setAttribute("onClick", "CaricatoreAdmin.CambiaStatoRichiesta('" + dato.codiceRichiesta + "', 0)");
		rifiuta.textContent = '\u2718';

		tdEl6.appendChild(accetta);
		tdEl6.appendChild(barra);
		tdEl6.appendChild(rifiuta);

		trEl.appendChild(tdEl1);
		trEl.appendChild(tdEl2);
		trEl.appendChild(tdEl3);
		trEl.appendChild(tdEl4);
		trEl.appendChild(tdEl5);
		trEl.appendChild(tdEl6);

		return trEl; 
	}

//Aggiornamento della tabella contenente le richieste di ferie dei barber
DashboardAdmin.aggiornaRichieste = 
	function(dati){
		DashboardAdmin.rimuoviContenutoRichieste();
		var nuovaTabella = DashboardAdmin.creaTabellaRichieste();

		if(dati != null){
			for (var j = 0; j < dati.length; j++){
				var riga = DashboardAdmin.creaElTabellaRichieste(dati[j]);
				nuovaTabella.appendChild(riga);
			}
		}

		var contenitoreTabella = document.getElementById("contenitore_richieste");
		contenitoreTabella.appendChild(nuovaTabella);
	}