<?php

function nom_user ($id) {
	include "../Base_de_donnees/Connection_bdd.php";
	$nom = "";
	$prenom = "";
	try {
		$requette_nom = $bdd->query('select nom, prenom from membres where id="'.$id.'"');
		if (!empty($requette_nom)) {
			while (($x = $requette_nom->fetch())) {
				if (!empty($x['nom'])) {
					$nom = $x['nom'];
				}
				if (!empty($x['prenom'])) {
					$prenom = $x['prenom'];
				}
			}
		}
		else {
			echo "Problème avec la requête.";
		}
	}
	catch (exception $e) {
		echo "Problème avec la bdd.";
	}
	return (array($nom, $prenom));
}

?>