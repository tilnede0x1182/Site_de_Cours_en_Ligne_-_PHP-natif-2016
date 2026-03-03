<?php

// ##################################### Cours achetés ####################################### //

function verifie_cours_pris ($id) {
	include "../Base_de_donnees/Connection_bdd.php";

	$res = array();
	if (empty($id)) {
		return $res;
	}

	try {
		$requette_id = $bdd->prepare('select cours from cours_pris where id = :id');
		$requette_id->execute([':id'=>$id]);

		while (($x = $requette_id->fetch(PDO::FETCH_ASSOC))) {
			if (!empty($x['cours'])) {
				$res[$x['cours']] = "pris";
			}
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

	if (empty($id) || empty($cours)) {
		return false;
	}

	try {
		$requette_cours_pris = $bdd->prepare('select 1 from cours_pris where id = :id and cours = :cours limit 1');
		$requette_cours_pris->execute([
			':id'=>$id,
			':cours'=>$cours
		]);
		return (bool)$requette_cours_pris->fetchColumn();
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
	return preg_match("/^[éèàçôîùâòa-zA-Z\\d ',\\-]+$/", $adresse);
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
