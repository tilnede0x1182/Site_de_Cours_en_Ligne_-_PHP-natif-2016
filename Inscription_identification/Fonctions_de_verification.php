<?php

// ##################################### Cours achetés ####################################### //

function verifie_cours_pris ($id) {
	include "../Base_de_donnees/Connection_bdd.php";

	$res = array();

	try {
		$requette_id = $bdd->query('select cours from cours_pris where id="'.$id.'"');

		if (!empty($requette_id)) {
			while (($x = $requette_id->fetch())) {
				if (!empty($x['cours'])) {
					$res[$x['cours']] = "pris";
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

	return $res;
}

function verifie_un_cours_pris_avec_liste ($cours, $cours_pris) {
	return (!empty($cours_pris[$cours]));
	
}

function verifie_un_cours_pris ($id, $cours) {
	include "../Base_de_donnees/Connection_bdd.php";

	try {
		$requette_cours_pris = $bdd->query('select cours from cours_pris where id="'
		.$id.'" && cours="'.$cours.'";');

		if (!empty($requette_cours_pris)) {
			while (($x = $requette_cours_pris->fetch())) {
				if (!empty($x['cours']) && !empty($x['id'])) {
					die ("id : ".$x['id']." cours : ".$x['cours']);
				}
				if (!empty($x['cours'])) {
					if ($x['cours'] = $cours)
						return true;
				}
			}
		}
		else {
			echo "Problème avec la requête.";
			return false;
		}
	}
	catch (exception $e) {
		echo "Problème avec la bdd.";
		return false;
	}
}

// ################################# Formulaires d'inscription ################################## //

function verifie_id ($id) {
	return preg_match("/^[a-zA-Z_\-\d]+$/", $id);
}

/**
	Il faut avoir au moins charactères, avec au moins 
	une lettre capitale et un chiffre.
**/
function verifie_mdp ($mdp) {
	if (!preg_match("/^[a-zA-Z_\d]{8,}$/", $mdp)) return false;
	if (!preg_match("/[A-Z]/", $mdp)) return false;
	if (!preg_match("/\d/", $mdp)) return false;
	return true;
}

function verifie_asresse ($adresse) {
	return preg_match("/^[éèàçôîùâòa-zA-Z\d \-]+$/", $adresse);
}
function verifie_autres_champs ($champ) {
	return preg_match("/^[éèàçôîùâòa-zA-Z\d ]+$/", $champ);
}

function verifie_date_de_naissance_valide ($j, $m, $annee) {
	if (!is_numeric($j) || !is_numeric($m) || !is_numeric($annee))
		return false;
	if ($j<1 || $m<1 || $j>31 || $m>12 || $annee<1850 || $annee>=date('Y')) {
		return false;
	}
	return checkdate($m, $j, $annee);
}

function check_mail_adress ($mail_adress) {
	return filter_var($mail_adress, FILTER_VALIDATE_EMAIL);
}

// ################################### Affichage des cours  #################################### //

function verifie_format_nom_cours ($nom_cours) {
	if (!preg_match("/^Cours\d$/", $nom_cours)) return false;
	$numero_du_cours = substr($nom_cours, 5, strlen($nom_cours));
	if ($numero_du_cours<1 || $numero_du_cours>3) return false;
	return true;
}

?>
