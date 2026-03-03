<!DOCTYPE html>
<?php
	require_once __DIR__.'/../includes/require_login.php';
	require_once __DIR__.'/../Inscription_identification/Fonctions_de_verification.php';
	$utilisateur_connecte = require_login('../PagePrincipale/Acceuil.php');

	/**
		On détermine le numéro du cours en fonction 
		d'un paramètre passé dans l'URL.
	**/
	$numero_du_cours=0;
	if (!empty($_GET["Cours"])) {
		$numero_candidat = (int)$_GET["Cours"];
		if ($numero_candidat>=1 && $numero_candidat<=3) {
			if (verifie_un_cours_pris($utilisateur_connecte, 'Cours'.$numero_candidat)) {
				$numero_du_cours = $numero_candidat;
			}
		}
	}
	if ($numero_du_cours===0) {
		header('Location: ../PagePrincipale/Acceuil.php');
		exit;
	}
	if (!defined('COURS_PARTIAL_AUTORISE')) {
		define('COURS_PARTIAL_AUTORISE', true);
	}
?>
<html lang="fr">
<head>	
	<meta charset="utf-8">
<?php
	echo "\t<title>Cours ".$numero_du_cours."</title>";
?>
	<meta name="description" content="courte description">
	<link href="../CSS/Cours.css" rel="stylesheet">
	<link href="../CSS/Background.css" rel="stylesheet">
</head>
<body>
<?php
	include "../Header/logo_du_site.php";
	include "Menu.php";
	include "Cours".$numero_du_cours.".php";
	include "../Footer/footer_cours.php";
?>
</body>
</html>
