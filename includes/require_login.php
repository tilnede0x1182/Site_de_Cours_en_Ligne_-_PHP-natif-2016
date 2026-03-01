<?php
require_once __DIR__.'/session.php';
require_once __DIR__.'/../Inscription_identification/Verifie_identifiants_connection.php';

function require_login(string $redirect = '../PagePrincipale/Acceuil.php') {
	if (empty($_SESSION['id']) || empty($_SESSION['mdp'])) {
		redirige_vers($redirect);
	}
	if (!verifie_id_connection($_SESSION['id'], $_SESSION['mdp'], true)) {
		$_SESSION = [];
		session_regenerate_id(true);
		redirige_vers($redirect);
	}
	return $_SESSION['id'];
}

function redirige_vers(string $url) {
	header('Location: '.$url);
	exit;
}
