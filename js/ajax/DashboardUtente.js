function DashboardUtente(){}

//Chiusura dell'alert relativo alle operazioni che vengono svolte 
DashboardUtente.chiudiAlert = 
	function(){
		var alert = document.getElementsByClassName("alert");
		while(alert[0].firstChild !== null){
			alert[0].removeChild(alert[0].firstChild);
		}
		alert[0].style.backgroundColor='#414042';
	}
  
 //Creazione alert relativo ad un tentativo di eseguire un operazione
DashboardUtente.riprova = 
	function(messaggio){
		var span = document.createElement("span");
		span.setAttribute("class", "chiudi_alert");
		span.setAttribute("onclick", "DashboardUtente.chiudiAlert()");
		span.setAttribute("title","Chiudi alert");
		span.textContent = '\u2718';

		var testo = document.createElement("p");
		testo.textContent = messaggio;
		testo.setAttribute("class", "testo_alert");

		DashboardUtente.chiudiAlert();

		var alert = document.getElementsByClassName("alert");
		alert[0].appendChild(span);
		alert[0].appendChild(testo);
		alert[0].style.backgroundColor='#f44336';
		alert[0].style.display="block";
	}

//Rimozione elementi di scelta per la prenotazione di un nuovo appuntamento
DashboardUtente.rimuoviContenuto = 
	function(i){
		DashboardUtente.chiudiAlert();
		var id = ["servizi", "barber", "orari"];
		var idAnalaizzato = document.getElementById(id[i]);
		if (idAnalaizzato === null){
			return;
		}

		while(idAnalaizzato.firstChild !== null){
			idAnalaizzato.removeChild(idAnalaizzato.firstChild);
		}
	}

//Aggiornamento degli elementi di scelta per la prenotazione di una appuntamento
DashboardUtente.aggiornaDati = 
	function(dati, i){
		DashboardUtente.rimuoviContenuto(i);
		DashboardUtente.chiudiAlert();

		switch(i){
			case 0:
				DashboardUtente.setServizio(dati);
				break;
			case 1:
				DashboardUtente.setBarber(dati);
				break;
			case 2:
				DashboardUtente.setOrario(dati);
				break;
		}
	}

//Inserimento servizi che l'utente cliente puo' scegliere
DashboardUtente.setServizio = 
	function(dati = null){
		var label = document.createElement("label");
		label.setAttribute("class", "etichetta");
		label.textContent = "Tipologia servizio";

		var select = document.createElement("select");
		select.setAttribute("name", "tipo_servizio");
		select.setAttribute("class", "ins_dati");
		select.setAttribute("required", "");

		var option = [];

		if(dati == null){
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].textContent = "Non ci sono dati da caricare";
		}
		else{
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].setAttribute("id", "valore_nullo_servizio");
			option[0].textContent = "Seleziona un servizio..";

			if(dati != null){
				for (var j = 0; j < dati.length; j++){
					option[j+1] = document.createElement("option");
					option[j+1].setAttribute("value", dati[j]);
					option[j+1].textContent = dati[j];
				}
			}
		}
		if(option != null){
			for (var j = 0; j < option.length; j++){
				select.appendChild(option[j]);
			}
		}

		var tipoServizio = document.getElementById("servizi");
		tipoServizio.appendChild(label);
		tipoServizio.appendChild(select);
	}

//Inserimenti orario che il cliente può scegliere sulla base del barber e giorno selezionato
DashboardUtente.setOrario = 
	function(dati = null){
		var label = document.createElement("label");
		label.setAttribute("class", "etichetta");
		label.textContent = "Orario appuntamento";

		var select = document.createElement("select");
		select.setAttribute("name", "orario_appuntamento");
		select.setAttribute("class", "ins_dati");
		select.setAttribute("required", "");

		var option = [];

		if(dati == null){
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].textContent = "Seleziona prima barber e data";
		}
		else{
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].textContent = "Seleziona orario..";
			var pari_dispari = 0;

			for (var j = 1, i = 9; j < 21; j++, i++){
				option[j] = document.createElement("option");

				//pausa pranzo
				if(i == 13){
					i++;
				}

				if(!pari_dispari){
					option[j].textContent = i + ":00";
				}
				else{
					option[j].textContent = i + ":30";
				}

				if(i == 9){
					option[j].textContent = "0" + option[j].textContent;
				}

				option[j].setAttribute("value",option[j].textContent);

				if(dati != null){
					for(var z = 0; z < dati.length; z++){
						if(option[j].textContent == dati[z].substring(0,5)){
							option[j].textContent = "occupato";
						}
					}
				}

				if(!pari_dispari){
					pari_dispari = 1;
					i--;
				}
				else{
					pari_dispari = 0;	
				}
			}
		}

		if(option != null){
			for (var j = 0; j < option.length; j++){
				if(option[j].textContent != "occupato")
					select.appendChild(option[j]);
			}
		}

		var tipoServizio = document.getElementById("orari");
		tipoServizio.appendChild(label);
		tipoServizio.appendChild(select);
	}

//Inserimento dei barber disponibili per fissare un appuntamento
DashboardUtente.setBarber = 
	function(dati = null){
		var label = document.createElement("label");
		label.setAttribute("class", "etichetta");
		label.textContent = "Barber";

		var select = document.createElement("select");
		select.setAttribute("name", "barber");
		select.setAttribute("onChange", "utenteGestoreEventi.onChange(null, "+ this.value + ")");
		select.setAttribute("class", "ins_dati");
		select.setAttribute("required", "");

		var option = [];

		if(dati == null){
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].textContent = "Non ci sono barber da caricare";
		}
		else{
			option[0] = document.createElement("option");
			option[0].setAttribute("value", "");
			option[0].setAttribute("disabled", "");
			option[0].setAttribute("selected", "");
			option[0].setAttribute("id", "valore_nullo_barber")
			option[0].textContent = "Seleziona un barber..";

			if(dati != null){
				for (var j = 0; j < dati.length; j++){
					option[j+1] = document.createElement("option");
					option[j+1].setAttribute("value", dati[j]);
					option[j+1].textContent = dati[j];
				}
			}
		}

		if(option != null){
			for (var j = 0; j < option.length; j++){
				select.appendChild(option[j]);
			}
		}

		var tipoServizio = document.getElementById("barber");
		tipoServizio.appendChild(label);
		tipoServizio.appendChild(select);
	}

//Creazione popup per la conferma di un appuntamento con relativo riepilogo
DashboardUtente.creaPopupConferma = 
	function(data, barber, orario, servizio){
		var section = document.createElement("section");
		section.setAttribute("class", "id1 modulo_contenuto animazione");
		section.setAttribute("onclick", "chiudiFuori()");

		var span = document.createElement("span");
		span.setAttribute("class", "chiudi_conferma");
		span.setAttribute("onclick", "chiudiX()");
		span.setAttribute("title","Chiudi modulo");
		span.textContent = '\u2718';

		var contenitore = document.createElement("div");
		contenitore.setAttribute("class", "contenitore");

		var titolo = document.createElement("h3");
		titolo.setAttribute("class", "titolo_conferma");		
		titolo.textContent = 'Conferma appuntamento';

		var testo = document.createElement("p");
		testo.setAttribute("class", "");		
		testo.textContent = "Confermi l'appuntamento del " + data + " con il nostro barber " + barber + 
								" alle " + orario + " per un " + servizio + "?";	

		var bottone = document.createElement("button");
		bottone.setAttribute("type", "submit");	
		bottone.setAttribute("class", "bottone");
		
		bottone.setAttribute("onclick", "utenteGestoreEventi.prenotaAppuntamento('" + data + "', '" + 
											barber + "', '" + orario + "', '" + servizio + "')");
		bottone.textContent = 'VAI';	

		contenitore.appendChild(titolo);
		contenitore.appendChild(testo);
		contenitore.appendChild(bottone);

		section.appendChild(span);
		section.appendChild(contenitore);

		var modulo = document.getElementsByClassName("id1");
		modulo[0].appendChild(section);

		(document.getElementsByClassName("id1"))[0].style.display='block';
	}

//Eliminazione degli elementi relativi alla pagina personale del profilo personale utente cliente
DashboardUtente.rimuoviDatiProfilo =
	function(){
		DashboardUtente.chiudiAlert();
		var elAnalizzato = document.getElementById("info_profilo");
		while(elAnalizzato.firstChild !== null){
			elAnalizzato.removeChild(elAnalizzato.firstChild);
		}

		elAnalizzato = document.getElementsByClassName("contenitore_ip");
		if(elAnalizzato[0].firstChild !== null)
		elAnalizzato[0].removeChild(elAnalizzato[0].firstChild);

		for(var i = 0; i < 5; i++){
			elAnalizzato = document.getElementById("contatore_" + (i+1));
			if(elAnalizzato.firstChild !== null)
				elAnalizzato.removeChild(elAnalizzato.firstChild);
		}
	}

//Creazione degli elementi relativi alla pagina del profilo personale dell'utente cliente
DashboardUtente.caricaProfilo =
	function(dati){
		var nome = document.createElement("p");
		nome.setAttribute("class", "allineamento_profilo info");
		nome.textContent = dati.nome;
		
		var cognome = document.createElement("p");
		cognome.setAttribute("class", "allineamento_profilo info");
		cognome.textContent = dati.cognome;

		var dataDiNascita = document.createElement("p");
		dataDiNascita.setAttribute("class", "allineamento_profilo info");
		dataDiNascita.textContent = dati.dataDiNascita;

		var nomeUtente = document.createElement("p");
		nomeUtente.setAttribute("class", "allineamento_profilo info");
		nomeUtente.textContent = dati.nomeUtente;

		var email = document.createElement("p");
		email.setAttribute("class", "allineamento_profilo info");
		email.textContent = dati.email;

		var attivo = document.createElement("p");
		attivo.setAttribute("class", "allineamento_profilo info");
		if(dati.attivo == '0')
			attivo.textContent = "Profilo disattivo";
		else
			attivo.textContent = "Profilo attivo";

		var cambiaPassword = document.createElement("p");
		cambiaPassword.setAttribute("class", "allineamento_profilo info cambia");
		cambiaPassword.setAttribute("onclick", "DashboardUtente.cambiaPassword()");
		cambiaPassword.textContent = "Cambia Password";

		var immagineProfilo = document.createElement("img");
		immagineProfilo.alt = "immagine del profilo";
		immagineProfilo.src = "./uploads/" + dati.nomeUtente + "/" + dati.immagineProfilo;
		immagineProfilo.setAttribute("class", "immagine_profilo");

		var contenitoreImmagine = document.getElementsByClassName("contenitore_ip");
		contenitoreImmagine[0].appendChild(immagineProfilo);

		var infoProfilo = document.getElementById("info_profilo");
		infoProfilo.appendChild(nome);
		infoProfilo.appendChild(cognome);
		infoProfilo.appendChild(dataDiNascita);
		infoProfilo.appendChild(nomeUtente);
		infoProfilo.appendChild(email);
		infoProfilo.appendChild(attivo);
		infoProfilo.appendChild(cambiaPassword);
	}

//Visualizzazione del form per modificare la password dell'utente nella sezione del profilo personale 
//dell'utente cliente
DashboardUtente.cambiaPassword = 
	function(){
		var menu = document.getElementsByClassName('finestra_cambio_psw');
		if(menu[0].style.display == 'none')
			menu[0].style.display = 'block';
		else
			menu[0].style.display = 'none';
	}

//Visualizzazione dei contatori relativi agli appuntamenti svolti di un utente cliente 
DashboardUtente.caricaContatori =
	function(dati){
		for(var i = 0; i < 5; i++){
			var paragrafo = document.createElement("p");
			paragrafo.setAttribute("class", "contatore");
			paragrafo.textContent = dati[i].contatore;

			var contatore_x = document.getElementById("contatore_" + dati[i].numeroServizio);
			contatore_x.appendChild(paragrafo);
		}
	}

//Alert relativo ad un'operazione avvenuta con successo (es prenotazione di un appuntamento andata a buon fine)
DashboardUtente.alertSuccesso = 
	function(messaggio){
		DashboardUtente.chiudiAlert();
		DashboardUtente.riprova(messaggio);
		var alert = document.getElementsByClassName("alert");
		alert[0].style.backgroundColor='green';
	}

//Segnalazione grafica in verde nel calendario mensile dell'utente barber delle ferie accettate
DashboardUtente.segnaFerieCalendario = 
	function(dati){
		for(var i = 1; i <= 31; i++){
			var strI = " " + i + " ";
			if(dati.includes(strI)){
				var dataCambiaStile = document.getElementById("gg" + i);
				dataCambiaStile.style.backgroundColor = 'green';
				dataCambiaStile.style.color = 'white';
			}
		}
	}

DashboardUtente.pulisciSelezioni = 
	function(){
		var inserimenti = document.getElementsByClassName("ins_dati");
		inserimenti[0].value = null; 
		inserimenti[1].value = null;
		inserimenti[2].value = null; 
		inserimenti[3].value = null;
		var barber = document.getElementById("valore_nullo_barber");
		barber.selected = true;
		var servizio = document.getElementById("valore_nullo_servizio");
		servizio.selected = true;
		var tipoServizio = document.getElementById("orari");
		while(tipoServizio.firstChild != null){
			tipoServizio.removeChild(tipoServizio.firstChild);
		}
		DashboardUtente.setOrario(null);
	}