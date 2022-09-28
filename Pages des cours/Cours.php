<!DOCTYPE html>
<?php
	include "../Inscription_identification/Identification.php";
	include "../Inscription_identification/Fonctions_de_verification.php";
	$function_verifie_id_mdp=true;
	$fonctions_de_verification=true;

	/**
		On détermine le numéro du cours en fonction 
		d'un paramètre passé dans l'URL.
	**/
	$numero_du_cours=0;
	if (!empty($_GET["Cours"])) {
		if (0+$_GET["Cours"]>0 && 0+$_GET["Cours"]<4) {
			if ($identifie) {
				if (verifie_un_cours_pris($_SESSION['id'], 
				'Cours'.$_GET["Cours"])) {
					$numero_du_cours=$_GET["Cours"];
				}
			}
		}
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
	if (!empty($_GET["Cours"]) && $numero_du_cours!=0) {
		include "Menu.php";
		include "Cours".$numero_du_cours.".php";
	}

	else {
		include "footer_cours.php";
	}
	include "../Footer/footer_cours.php";
?>
</body>
</html>