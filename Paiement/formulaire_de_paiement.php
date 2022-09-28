<!DOCTYPE html>
<html lang="fr">
<head>	
	<meta charset="utf-8">
	<title>Achat d'un cours</title>
	<meta name="description" content="courte description">
	<link href="../CSS/Paiement.css" rel="stylesheet">
</head>
<body>
<?php
	session_start();
	include "../Inscription_identification/Fonctions_de_verification.php";

function acheter_cours ($nom_cours) {
	include "../Base_de_donnees/Connection_bdd.php";

	try {
		$insertion_cours_achete = 'insert into cours_pris(id_cours_pris, id, cours) values ("", "'.
		$_SESSION['id'].'", "'.$nom_cours.'");';

		$requette_id = $bdd->exec($insertion_cours_achete);
	}
	catch (exception $e) {
		die("Erreur : ".$e->getMessage());
	}
}

// ############################# Avant l'achat du cours ################################### //

$erreur_detectee = false;
$cours_en_cours_dachat = "";
if (!empty($_POST['cours_achete'])) {
	if (verifie_format_nom_cours($_POST['cours_achete'])) {
		$cours_en_cours_dachat = $_POST['cours_achete'];
	}
	else {
		$erreur_detectee = true;
		//header('Location: ../PagePrincipale/Acceuil.php');
	}
}

// ############################ Une fois le cours choisit ################################# //

$cours_achete = false;
if (!empty($_POST['cours_choisit'])) {
	if (verifie_format_nom_cours($_POST['cours_choisit'])) {
		acheter_cours($_POST['cours_choisit']);
		$cours_achete = true;
		header('Location: ../PagePrincipale/Acceuil.php');
	}
	else {
		$erreur_detectee = true;
	}
}

// ### Pour le test CSS ##### //
//$erreur_detectee = true;
// ########################## //

echo '<img src="../Images/Autre/formulaire_de_paiement_exemple.jpg" '
.'alt="Formulaire de paiement (image)">';
echo '<div>
	<form action="" method="POST">'
	.'<input name="cours_choisit" value="'.$cours_en_cours_dachat.'" hidden>';
	if (!$cours_achete) {
		if ($erreur_detectee) {
			echo '<p class="erreur_detectee">Une erreur a été détectée.
			Veuillez réessayer ultérieurement.
			Aucun achat n'."'".'a pu être effectué.</p>';
		}
		if (!$erreur_detectee) {
			echo '<input type="submit" value="Valider"></form>';
			echo '<a href="../PagePrincipale/Acceuil.php">Abandon et retour à l'
			."'".'acceuil</a>';
		}
		else {
			echo '<a href="../PagePrincipale/Acceuil.php">Retour à l'
			."'".'acceuil</a>';
		}
	}
	else {
		echo '<p>Achat effectué.</p>'
		.'<a href="../PagePrincipale/Acceuil.php"> Retour à l'."'".'acceuil</a>';
	}

echo '</div>';

?>
</body>
</html>
