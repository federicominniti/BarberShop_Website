function controllaNomeUtente(){
  var nomeUtente = document.getElementById("nome_utente_reg");
  /*
  inizia con una lettere (maiuscola o minuscola)
  continua con altre lettere e simboli dove nel caso dei siboli abbiamo: 
    UN simbolo obbligatoriamente seguito subito dopo da una lettera
  ha lunghezza tra 4 e 9 
  */
  var regex = new RegExp("^[a-zA-Z]+([!_.]?[a-zA-Z0-9]){4,9}$");
  var controlloRegex = regex.test(nomeUtente.value);
  setStile("nome_utente_reg", controlloRegex);
}

function controllaStringaLetterale(id){
  var stringa = document.getElementById(id);
  /*
  puo iniziare con maiuscola e minuscola e procede con
  solo lettere e la lunghezza deve essere almeno 2 lettere
  */
  var regex = new RegExp("^[a-zA-Z][a-z]{1,}$");
  var controlloRegex = regex.test(stringa.value);
  setStile(id, controlloRegex);
}

//Controllo data di nascita che sia maggiorenne
function controllaDataDiNascita(){
  var data = document.getElementById("data_nascita_reg");
  var dataNascita = new Date(data.value)
  var dataOggi = new Date();
  var eta = new Date(dataOggi.getTime() - dataNascita.getTime()).getUTCFullYear()-1970;
  setStile("data_nascita_reg", eta >= 18);
}

//Controllo password che contenga maiuscole, minuscole, numeri e abbia lunghezza almeno 8
function controllaPassword(id){
  var stringa = document.getElementById(id);
  var patternRispettato = true;
  
  var lettereMinuscole = /[a-z]/g;
  if(!stringa.value.match(lettereMinuscole)){  
    patternRispettato = false;
  }

  var lettereMaiuscole = /[A-Z]/g;
  if(!stringa.value.match(lettereMaiuscole)){  
    patternRispettato = false;
  }

  var numeri = /[0-9]/g;
  if(!stringa.value.match(numeri)){  
    patternRispettato = false;
  }
  
  if(!(stringa.value.length >= 8)){
    patternRispettato = false;
  }

  setStile(id, patternRispettato);
}

//Controllo che i campi password e ripeti password siano uguali
function controllaUguaglianzaPassword(id1, id2){
  var password = document.getElementById(id1);
  var ripeti_password = document.getElementById(id2);
  if(password.value != '' && ripeti_password.value != ''){
    if(password.value === ripeti_password.value){
      setStile(id1, true);
      setStile(id2, true);
    } else{
      setStile(id1, false);
      setStile(id2, false);
    }
  }
}

//Colore cornice per indicare la correttezza o meno del campo inserito
function setStile(id, controllo){
  var elemento = document.getElementById(id);
  if(controllo){
    elemento.style.borderColor = "green";
    elemento.style.borderStyle = "solid";
    elemento.style.borderWidth = "thick";
  }else{
    elemento.style.borderColor = "red";
    elemento.style.borderStyle = "solid";
    elemento.style.borderWidth = "thick";
  }
}

//Reset colore del campo
function pulisciStile(id){
  var elemento = document.getElementById(id);
  elemento.style.removeProperty('border-color');
  elemento.style.removeProperty('border-style');
  elemento.style.removeProperty('border-width');
}

//Verifica la correttezza di tutti i campi e li evidenzia
function evidenziaCampiOVai(){
  var nomeUtente = document.getElementById("nome_utente_reg");
  var data = document.getElementById("data_nascita_reg");
  var password = document.getElementById("password_reg");
  var ripeti_password = document.getElementById("ripeti_password_reg");
  var nome = document.getElementById("nome_reg");
  var cognome = document.getElementById("cognome_reg");
  var email = document.getElementById("email_reg");
  var immagine = document.getElementById("file_da_caricare");

  if(nomeUtente.style.borderColor == "green" && data.style.borderColor == "green"
      && password.style.borderColor == "green" && ripeti_password.style.borderColor == "green"
      && nome.style.borderColor == "green" && cognome.style.borderColor == "green" && email
      && immagine.file[0].name != ''){

      document.getElementsByClassName("bottone")[0].disabled = false;
    }
  else{
    if(nomeUtente.value == "")
      setStile('nome_utente_reg', false);
    if(data.value == "")
      setStile('data_nascita_reg', false);
    if(password.value == "")
      setStile('password_reg', false);
    if(ripeti_password.value == "")
      setStile('ripeti_password_reg', false);
    if(nome.value == "")
      setStile('nome_reg', false);
    if(cognome.value == "")
      setStile('cognome_reg', false);
    if(email.value == "")
      setStile('email_reg', false);
    if(!immagine.files[0])
      setStile('ins_immagine', false);
  }
}

//Rimozione l'immangine caricata
function togliImmagine(){
  document.getElementById("file_da_caricare").value = "";
}

//Controllo correttezza dell'ordine coppia data fine - data inizio delle ferie 
function controllaDate(dataInizio, dataFine){
  var dataInizio1 = document.getElementById(dataInizio);
  var dataFine1 = document.getElementById(dataFine);
  if(dataInizio1.value != '' && dataFine1.value == ''){
    var dataInizio2 = new Date(dataInizio1.value);
    var dataOggi = new Date();
    setStile(dataInizio, dataInizio2 > dataOggi);
  }
  if(dataFine1.value != '' && dataInizio1.value == ''){
    var dataFine2 = new Date(dataFine1.value);
    var dataOggi = new Date();
    setStile(dataFine, dataFine2 > dataOggi);
  }
  if(dataInizio1.value != '' && dataFine1.value != ''){
    var dataInizio2 = new Date(dataInizio1.value)
    var dataFine2 = new Date(dataFine1.value);
    var dataOggi = new Date();
    setStile(dataInizio, (dataFine2 > dataInizio2 && dataInizio2 > dataOggi));
    setStile(dataFine, (dataFine2 > dataInizio2 && dataFine2 > dataOggi));
  }
}
