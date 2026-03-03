<?php

function nom_user ($id) {
	include "../Base_de_donnees/Connection_bdd.php";
	$nom = "";
	$prenom = "";
	if (empty($id)) {
		return array($nom, $prenom);
	}
	try {
		$requette_nom = $bdd->prepare('select nom, prenom from membres where id = :id limit 1');
		$requette_nom->execute([':id'=>$id]);
		$x = $requette_nom->fetch(PDO::FETCH_ASSOC);
		if (!empty($x['nom'])) {
			$nom = $x['nom'];
		}
		if (!empty($x['prenom'])) {
			$prenom = $x['prenom'];
		}
	}
	catch (exception $e) {
		echo "Problème avec la bdd.";
	}
	return (array($nom, $prenom));
}

?>
