<?php
	require_once __DIR__ . "/config.php";
	require_once DIR_UTIL . "barberManagerDb.php";
	require_once DIR_UTIL . "sessionUtil.php";

	//Gestione dell'upload dell'immagine del profilo durante la fase di registrazione

	session_start();
	$_SESSION['nome_reg'] = $_POST['nome_reg'];
	$_SESSION['cognome_reg'] = $_POST['cognome_reg'];
	$_SESSION['nome_utente_reg'] = $_POST['nome_utente_reg'];
	$_SESSION['data_nascita_reg'] = $_POST['data_nascita_reg'];
	$_SESSION['email_reg'] = $_POST['email_reg'];

	mkdir('uploads/' . $_POST["nome_utente_reg"]);
	$target_dir = "uploads/" . $_POST["nome_utente_reg"] . '/';
	$target_file = $target_dir . basename($_FILES["file_da_caricare"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
	// Conntollo che il file sia effettivamente un'immagine
	$check = getimagesize($_FILES["file_da_caricare"]["tmp_name"]);
	if($check !== false){
	    $uploadOk = 1;
	}else{
	    $messaggio = "Il file non è un'immagine";
	    $uploadOk = 0;
	}

	//Controllo che la dimensione del file non superi 100KB
	if($_FILES["file_da_caricare"]["size"] > 100000){
	  	$messaggio = "La dimensione del file e' troppo grande.";
	  	$uploadOk = 0;
	}

	// Controllo la dimensione del file
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
	  	$messaggio = "Sono ammessi solo file JPG, JPEG e PNG.";
	  	$uploadOk = 0;
	}

	if($uploadOk == 0){
	  	$messaggio += " Non è stato possibile caricare il file";
	}else{
	  	if(!move_uploaded_file($_FILES["file_da_caricare"]["tmp_name"], $target_file)){
	    	$messaggio += " C'e' stato un errore nel caricamento del file";
	  	}
	  	else{
	  		$uploadOk = 1;
	  	}
	}

	if($uploadOk == 1){
		echo md5($_POST["password_reg"]);
		$risultato = creaUtente($_POST["nome_reg"], $_POST["cognome_reg"], $_POST["data_nascita_reg"],
									$_POST["nome_utente_reg"], $_POST["email_reg"], md5($_POST["password_reg"]), 
									$_FILES["file_da_caricare"]["name"]);
	}

	if($uploadOk == 0){
		$_SESSION['messaggioErrore'] = $messaggio;
		header('location: ./registrazione1.php');
	} else{
		session_destroy();
		session_start();
    	setSession($_POST["nome_utente_reg"], 'utente');
		header('location: ./login.php');
	}

?>