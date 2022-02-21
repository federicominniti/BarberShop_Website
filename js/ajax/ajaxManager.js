function AjaxManager(){}

AjaxManager.getAjaxObject = 
	function(){
		var xmlHttp = null;
		try { 
			xmlHttp = new XMLHttpRequest(); 
		} catch (e) {
			try { 
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); //IE (recenti versioni)
			} catch (e) {
				try { 
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); //IE (vecchie versioni)
				} catch (e) {
					xmlHttp = null; 
				}
			}
		}
		return xmlHttp;
	}

AjaxManager.eseguiAjaxRequest = 
	function(metodo, url, Async, datiDaInv, funzioneRisposta){
		var xmlHttp = AjaxManager.getAjaxObject();
		if (xmlHttp === null){
			window.alert("Il tuo browser non supporta AJAX!"); // funzione di errore
			return;
		}

		xmlHttp.open(metodo, url, Async); 
		xmlHttp.onreadystatechange = function (){
			if (xmlHttp.readyState == 4){
				console.log(xmlHttp.responseText);
				var dati = JSON.parse(xmlHttp.responseText);
				funzioneRisposta(dati);
			}
		}
		xmlHttp.send(datiDaInv);
}		