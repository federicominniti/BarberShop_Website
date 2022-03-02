<?php
    require_once __DIR__ . "/../config.php";
    require_once DIR_UTIL . "barbershopDbManager.php";
 	
    //Ricerche effettuate sul database

    function getAppuntamentiBarber($nomeUBarber, $offset, $appDaCaricare, $fatto){
    	global $barbershop_db;
		$nomeUBarber = $barbershop_db->sqlInjectionFilter($nomeUBarber);
 		$offset = $barbershop_db->sqlInjectionFilter($offset);
		$appDaCaricare = $barbershop_db->sqlInjectionFilter($appDaCaricare);
		$query = 'SELECT a.NomeUtente, a.CodiceAppuntamento, s.Nome, a.DataAppuntamento, a.OraAppuntamento '
				. 'FROM  Appuntamento a INNER JOIN Servizio s ON 
					a.NumeroServizio = s.NumeroServizio
					INNER JOIN Barber b ON 
					a.NomeUBarber = b.NomeUBarber '
				. 'WHERE a.NomeUBarber = \'' . $nomeUBarber . '\' AND Fatto = ' . $fatto . ' '
				. 'ORDER BY a.DataAppuntamento ASC '
				. 'LIMIT ' . $offset . ',' . $appDaCaricare ;
 		
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

	function setFlagFatto($codiceAppuntamento){
		global $barbershop_db;
		$codiceAppuntamento = $barbershop_db->sqlInjectionFilter($codiceAppuntamento);
    	$query = 'UPDATE Appuntamento '
			. 'SET Fatto=1 '
			. 'WHERE CodiceAppuntamento=' . $codiceAppuntamento;
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }    

    function getAppuntamento($codiceAppuntamento){
    	global $barbershop_db;
		$codiceAppuntamento = $barbershop_db->sqlInjectionFilter($codiceAppuntamento);
    	$query = 'SELECT * '
    			. 'FROM Appuntamento ' 
    			. 'WHERE CodiceAppuntamento=' . $codiceAppuntamento;
    	$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }
    
    function getServizi(){
    	global $barbershop_db;
		$query = 'SELECT Nome AS dato '
				. 'FROM servizio';
 
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet; 
    }

    function getBarbers(){
    	global $barbershop_db;
		$query = 'SELECT Nome AS dato '
				. 'FROM barber '
				. 'WHERE Attivo = 1 '
				. 'ORDER BY NomeUBarber';
 		
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet; 
    }

    function getNomeUBarberByNome($nome){
    	global $barbershop_db;
    	$nome = $barbershop_db->sqlInjectionFilter($nome);
		$query = 'SELECT NomeUBarber '
				. 'FROM barber '
				. 'WHERE Nome = \'' . $nome . '\' ' 
				. 'ORDER BY NomeUBarber';
 		
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet; 
    }

    function getNumeroServizioByNome($nome){
    	global $barbershop_db;
    	$nome = $barbershop_db->sqlInjectionFilter($nome);
		$query = 'SELECT NumeroServizio '
				. 'FROM servizio '
				. 'WHERE Nome = \'' . $nome . '\';';
 		
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet; 
    }
    
    function getOrariOccupati($nomeUBarber, $dataAppuntamento){
    	global $barbershop_db;
		$nomeUBarber = $barbershop_db->sqlInjectionFilter($nomeUBarber);
 		$dataAppuntamento = $barbershop_db->sqlInjectionFilter($dataAppuntamento);
		$query = 'SELECT OraAppuntamento AS dato '
				. 'FROM appuntamento '
				. 'WHERE NomeUBarber = \'' . $nomeUBarber . '\' AND ' 
				. 'DataAppuntamento = \'' . $dataAppuntamento . '\' AND '
				. ' Fatto = 0 AND DataAppuntamento >= CURRENT_DATE';
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet; 
    }

    function getAppuntamentiUtente($nomeUtente, $offset, $appDaCaricare, $fatto){
    	global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
 		$offset = $barbershop_db->sqlInjectionFilter($offset);
		$appDaCaricare = $barbershop_db->sqlInjectionFilter($appDaCaricare);
		$query = 'SELECT b.Nome as NomeUtente, s.Nome, a.DataAppuntamento, a.OraAppuntamento, a.CodiceAppuntamento '
				. 'FROM  appuntamento a INNER JOIN servizio s ON 
					a.NumeroServizio = s.NumeroServizio
					INNER JOIN utente u ON 
					a.NomeUtente = u.NomeUtente 
					INNER JOIN barber b ON 
					a.NomeUBarber = b.NomeUBarber '
				. 'WHERE u.NomeUtente = \'' . $nomeUtente . '\' AND Fatto = ' . $fatto . ' '
				. 'ORDER BY a.DataAppuntamento ASC '
				. 'LIMIT ' . $offset . ',' . $appDaCaricare ;
 		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function deleteAppuntamento($codiceAppuntamento){
		global $barbershop_db;
		$codiceAppuntamento = $barbershop_db->sqlInjectionFilter($codiceAppuntamento);
    	$query = 'DELETE FROM appuntamento '
    			. 'WHERE CodiceAppuntamento=' . $codiceAppuntamento;

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }  

    function getBarberNonDisponibile($barber, $data, $orario){
		global $barbershop_db;
		$barber = $barbershop_db->sqlInjectionFilter($barber);
		$data = $barbershop_db->sqlInjectionFilter($data);
		$orario = $barbershop_db->sqlInjectionFilter($orario);
    	$query = 'SELECT * '
    			. 'FROM ferie '
    			. 'WHERE NomeUBarber=\'' . $barber . '\' '
    			. 'AND Data1 <= \'' . $data . '\' AND Data2 >= \'' . $data . '\';';
    				
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function getUtente($nomeUtente){
    	global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'SELECT * '
    			. 'FROM utente '
    			. 'WHERE NomeUtente=\'' . $nomeUtente . '\''; 
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function inserisciAppuntamento($data, $barber, $orario, $servizio, $nomeUtente){
    	global $barbershop_db;
		$barber = $barbershop_db->sqlInjectionFilter($barber);
		$data = $barbershop_db->sqlInjectionFilter($data);
		$orario = $barbershop_db->sqlInjectionFilter($orario);
		$servizio = $barbershop_db->sqlInjectionFilter($servizio);
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'INSERT INTO appuntamento (NomeUtente, NumeroServizio, NomeUBarber, DataAppuntamento, OraAppuntamento) ' 
			. 'VALUES (\'' . $nomeUtente . '\', \'' . $servizio . '\', \'' . $barber . '\', \'' . $data . '\', \'' . $orario . '\');';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function creaUtente($nome, $cognome, $dataNascita, $nomeUtente, $email, $password, $fileName){
		global $barbershop_db;
		$nome = $barbershop_db->sqlInjectionFilter($nome);
		$cognome = $barbershop_db->sqlInjectionFilter($cognome);
		$dataNascita = $barbershop_db->sqlInjectionFilter($dataNascita);
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$email = $barbershop_db->sqlInjectionFilter($email);
		$password = $barbershop_db->sqlInjectionFilter($password);
		$fileName = $barbershop_db->sqlInjectionFilter($fileName);
    	$query = 'INSERT INTO utente (Nome, Cognome, DataDiNascita, NomeUtente, Email, Password, ImmagineProfilo) ' 
			. 'VALUES (\'' . $nome . '\', \'' . $cognome . '\', \'' . $dataNascita . '\', \'' 
				. $nomeUtente . '\', \'' . $email . '\', \'' . $password . '\', \'' 
				. $fileName . '\');';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function getInformazioniUtente($nomeUtente){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'SELECT * '
    			. 'FROM utente '
    			. 'WHERE NomeUtente=\'' . $nomeUtente . '\''; 

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function getStatisticheUtente($nomeUtente){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'SELECT NumeroServizio, COUNT(*) as numeroAppuntamenti '
    			. 'FROM appuntamento '
    			. 'WHERE NomeUtente=\'' . $nomeUtente . '\' '
    			. 'GROUP BY NumeroServizio '
    			. 'ORDER BY NumeroServizio'; 

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function updatePassword($nuova, $nomeUtente){
		global $barbershop_db;
		$nuova = $barbershop_db->sqlInjectionFilter($nuova);
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'UPDATE utente '
			. 'SET Password= \'' . $nuova . '\' '
			. 'WHERE NomeUtente=\'' . $nomeUtente . '\'';
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }
	
	function verificaPassword($nomeUtente){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'SELECT Password '
    			. 'FROM utente '
    			. 'WHERE NomeUtente=\'' . $nomeUtente . '\''; 

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function getPersonale(){
		global $barbershop_db;
    	$query = 'SELECT Cognome, Nome, NomeUBarber, Password, Attivo '
    			. 'FROM barber;';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function cambiaStatoBarber($nomeUtente, $attivo){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$attivo = $barbershop_db->sqlInjectionFilter($attivo);
    	$query = 'UPDATE barber '
			. 'SET Attivo= \'' . $attivo . '\' '
			. 'WHERE NomeUBarber=\'' . $nomeUtente . '\'';
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function cambiaStatoUtente($nomeUtente, $attivo){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$attivo = $barbershop_db->sqlInjectionFilter($attivo);
    	$query = 'UPDATE utente '
			. 'SET Attivo= \'' . $attivo . '\' '
			. 'WHERE NomeUtente=\'' . $nomeUtente . '\'';
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function creaBarber($cognome, $nome, $nomeUtente, $password){
    	global $barbershop_db;
    	$cognome = $barbershop_db->sqlInjectionFilter($cognome);
		$nome = $barbershop_db->sqlInjectionFilter($nome);
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$password = $barbershop_db->sqlInjectionFilter($password);
    	$query = 'INSERT INTO barber (Cognome, Nome, NomeUBarber, Password) ' 
			. 'VALUES (\'' . $cognome . '\', \'' . $nome . '\', \'' . $nomeUtente . '\', \'' 
				. md5($password) . '\');';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function getUtenti(){
    	global $barbershop_db;
    	$query = 'SELECT Nome, Cognome, NomeUtente, Email, Attivo '
    			. 'FROM utente;';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function getFerie($nomeUtente, $stato){
    	global $barbershop_db;
    	$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$stato = $barbershop_db->sqlInjectionFilter($stato);
    	$query = 'SELECT CodiceRichiesta, Data1, Data2, DataRichiesta '
    			. 'FROM ferie '
    			. 'WHERE Stato = \'' . $stato . '\' AND NomeUBarber = \'' . $nomeUtente . '\' '
    			. 'AND Data1 BETWEEN \'' . date("Y") . '-01-01\' AND \'' . date("Y") . '-12-31\' '
    			. 'ORDER BY DataRichiesta DESC;';
    				
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
    }

    function prendiNomeDaRichiesta($codiceRichiesta){
    	global $barbershop_db;
    	$codiceRichiesta = $barbershop_db->sqlInjectionFilter($codiceRichiesta);
    	$query = 'SELECT NomeUBarber '
    			. 'FROM ferie '
    			. 'WHERE CodiceRichiesta = \'' . $codiceRichiesta . '\';';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;

    }
			
	function rimuoviRichiestaFerie($codiceRichiesta){
		global $barbershop_db;
		$codiceRichiesta = $barbershop_db->sqlInjectionFilter($codiceRichiesta);
    	$query = 'DELETE FROM ferie '
    			. 'WHERE CodiceRichiesta=' . $codiceRichiesta . ' AND Stato=\'pending\'';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function controllaSovrapposizioni($nomeUtente, $data1, $data2){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$data1 = $barbershop_db->sqlInjectionFilter($data1);
		$data2 = $barbershop_db->sqlInjectionFilter($data2);
    	$query = 'SELECT CodiceRichiesta '
    			. 'FROM ferie '
    			. 'WHERE NomeUBarber = \'' . $nomeUtente . '\' '
    			. 'AND (Data1 BETWEEN \'' . $data1 . '\' AND \'' . $data2 . '\' '
    			. 'OR Data2 BETWEEN \'' . $data1 . '\' AND \'' . $data2 . '\');';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}
		
	function inserisciRichistaFerie($nomeUtente, $data1, $data2){
    	global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
		$data1 = $barbershop_db->sqlInjectionFilter($data1);
		$data2 = $barbershop_db->sqlInjectionFilter($data2);
    	$query = 'INSERT INTO ferie (NomeUBarber, Data1, Data2, DataRichiesta) ' 
			. 'VALUES (\'' . $nomeUtente . '\', \'' . $data1 . '\', \'' . $data2 . '\', \'' . date("Y-m-d") . '\');';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}		

	function getFeriePending(){
		global $barbershop_db;
    	$query = 'SELECT CodiceRichiesta, NomeUBarber, Data1, Data2, DataRichiesta '
    			. 'FROM ferie '
    			. 'WHERE Stato = \'pending\' '
    			. 'ORDER BY DataRichiesta;';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}

	function getFerieAccettate(){
		global $barbershop_db;
    	$query = 'SELECT CodiceRichiesta, NomeUBarber, Data1, Data2, DataRichiesta '
    			. 'FROM ferie '
    			. 'WHERE Stato = \'accettate\' '
    			. 'AND Data1 BETWEEN \'' . date("Y") . '-01-01\' AND \'' . date("Y") . '-12-31\' '
    			. 'ORDER BY DataRichiesta;';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}
		
	function updateFerie($codiceRichiesta, $a_r){
		global $barbershop_db;
		$codiceRichiesta = $barbershop_db->sqlInjectionFilter($codiceRichiesta);
		$a_r = $barbershop_db->sqlInjectionFilter($a_r);
    	$query = 'UPDATE ferie '
			. 'SET Stato= \'' . $a_r . '\' '
			. 'WHERE CodiceRichiesta=\'' . $codiceRichiesta . '\';';
		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}		
	
	function getFerieDelMese($nomeUtente){
		global $barbershop_db;
		$nomeUtente = $barbershop_db->sqlInjectionFilter($nomeUtente);
    	$query = 'SELECT Data1, Data2 '
    			. 'FROM ferie '
    			. 'WHERE Stato = \'accettate\' '
    			. 'AND Data1 BETWEEN \'' . date("Y-m") . '-01\' AND SUBDATE(\'' . date("Y") . '-' . (date("m") + 1) . '-01\', INTERVAL 1 DAY) '
    			. 'AND NomeUBarber = \'' . $nomeUtente . '\' '
    			. 'ORDER BY Data1;';

		$resultSet = $barbershop_db->queryExe($query);
		$barbershop_db->chiudiConnessione();
		return $resultSet;
	}
?>
