<?php
	require_once __DIR__.'/../includes/session.php';

	$_SESSION = [];
	session_regenerate_id(true);
	session_destroy();

	header('Location: Acceuil.php');
	exit;
?>
