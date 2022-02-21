<?php
	require_once __DIR__ . "/config.php";
    require_once DIR_UTIL . "barbershopDbManager.php";
    require_once DIR_UTIL . "sessionUtil.php";

	$nomeUtente = $_POST['nomeUtente'];
	$password = $_POST['password'];

	$ris = login($nomeUtente, $password);
	if($ris == "barber")
		header('location: ./pagina_personale_barber.php');
	elseif($ris == "utente")
		header('location: ./pagina_personale_utente.php');
	else
		header('location: ./../index.php?errorMessage=' . $ris);


	function login($nomeUtente, $password){   
		if ($nomeUtente != null && $password != null){
			$app = autenticazione($nomeUtente, $password);
    		if ($app){
    			session_start();
    			setSession($nomeUtente, $app);
    			if($app == "admin")
    				$app = "barber";
    			return $app;
    		}
    	} else
    		return 'Devi prima completare i campi!';
    	
    	return 'Nome utente e/o password non validi!';
	}
	
	function autenticazione ($nomeUtente, $password){   
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$password = $barbershop_db->sqlInjectionFilter($password);

		$query = "SELECT * "
					. "FROM utente "
					. "WHERE NomeUtente='" . $nomeUtente . "' AND Password='" . md5($password) . "' "
					. 		"AND Attivo = 1;";

		$resultSet = $barbershop_db->queryExe($query);
		$ris = mysqli_num_rows($resultSet);
		if ($ris == 1){
			$barbershop_db->chiudiConnessione();
			return "utente";
		}
		
		$query = "SELECT * "
					. "FROM barber "
					. "WHERE NomeUBarber='" . $nomeUtente . "' AND password='" . md5($password) . "' "
					. 		"AND Attivo = 1;";

		$resultSet = $barbershop_db->queryExe($query);
		$ris = mysqli_num_rows($resultSet);
		if ($ris == 1){
			$barbershop_db->chiudiConnessione();
			$riga = $resultSet->fetch_assoc();
			if($riga["Admin"] == 0)
				return "barber";
			else
				return "admin";
		}
		$barbershop_db->chiudiConnessione();
		return false;
	}

?>