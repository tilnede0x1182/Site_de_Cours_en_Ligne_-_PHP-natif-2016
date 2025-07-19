<?php

	session_start();
	$_SESSION['id']="";
	$_SESSION['mdp']="";

	header('Location: Acceuil.php');
?>