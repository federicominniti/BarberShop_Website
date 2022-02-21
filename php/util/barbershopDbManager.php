<?php  
	
	require_once __DIR__ . "/../config.php";
    require DIR_UTIL . "dbConfig.php"; 

    $barbershop_db = new Barbershop(); 

	class Barbershop {
		private $mysqli_connection = null;
	
		function Barbershop(){
			$this->connessione();
		}
    
    	//Metodo per aprire la connessione con il db
    	function connessione(){
    		if (!$this->connessioneAperta()){
    			global $dbHostname;
    			global $dbUsername;
    			global $dbPassword;
    			global $dbName;
    			
    			$this->mysqli_connection = new mysqli($dbHostname, $dbUsername, $dbPassword);
				if ($this->mysqli_connection->connect_error) 
					die('Connect Error (' . $this->mysqli_connection->connect_errno . ') ' . $this->mysqli_connection->connect_error);

				$this->mysqli_connection->select_db($dbName) or
					die ('Can\'t use database: ' . mysqli_error());
			}
    	}
    
    	//Metodo che verifica se la connessione è aperta
    	function connessioneAperta(){
       		return ($this->mysqli_connection != null);
    	}

   		//Metodo che esegue una query e ne ritorna il risultato
		function queryExe($query) {
			if (!$this->connessioneAperta())
				$this->connessione();
			
			return $this->mysqli_connection->query($query);
		}
		
		//Metodo che blocca i tentartivi di sqlInjection
		function sqlInjectionFilter($dato){
			if(!$this->connessioneAperta())
				$this->connessione();
				
			return $this->mysqli_connection->real_escape_string($dato);
		}

		//Metodo per chiudere la connessione con il db
		function chiudiConnessione(){
 	       	if($this->mysqli_connection !== null)
				$this->mysqli_connection->close();
			
			$this->mysqli_connection = null;
		}
	}

?>