<?php
	require_once __DIR__.'/../includes/session.php';
	if (empty($function_verifie_id_mdp)) {
		include "Verifie_identifiants_connection.php";
	}

	$identifie = false;
	if (!empty($_SESSION['id']) && !empty($_SESSION['mdp'])) {
		if (verifie_id_connection($_SESSION['id'], $_SESSION['mdp'], true)) {
			$identifie = true;
		}
	}

?>
