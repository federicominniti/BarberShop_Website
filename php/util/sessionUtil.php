<?php
	//Imposta variabili di sessione
	function setSession($nomeUtente, $tabella){
		$_SESSION['nomeUtente'] = $nomeUtente;
		if($tabella == "admin"){
			$_SESSION['admin'] = 1;
			$tabella = "barber";
		} else{
			$_SESSION['admin'] = 0;
		}
		$_SESSION['tabella'] = $tabella;
	}

	//Verifica se un utente ha effettuato il login e in caso positivo ritorna il nome
	function isLogged(){		
		if(isset($_SESSION['nomeUtente']) && isset($_SESSION['tabella']))
			return $_SESSION['tabella'];
		else
			return false;
	}

?>