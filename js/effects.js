// Hamburger quando viente rimpicciolita la pagina di index
function Hamburger() {
  var x = document.getElementById("myNavbar");
  if (x.className === "navbar") {
    x.className += " responsive";
  } else {
    x.className = "navbar";
  }
}

//Chiusura popup login quando l'utente preme al difuori del modulo
function chiudiFuori(){
      var modulo = document.getElementsByClassName("id1");

      window.onclick = function(event) {
          if (event.target == modulo[0]) {
              modulo[0].style.display = "none";
          }
      }
}

//Chiusura popup login quando l'utente preme la 'x' del modulo
function chiudiX(){
      (document.getElementsByClassName("id1"))[0].style.display='none';
}


