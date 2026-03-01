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
	require_once __DIR__.'/../includes/require_login.php';
	include "../Inscription_identification/Fonctions_de_verification.php";
	include "../Base_de_donnees/Connection_bdd.php";
	$utilisateur_id = require_login('../PagePrincipale/Acceuil.php');

function acheter_cours ($nom_cours, $id_utilisateur) {
	global $bdd;
	try {
		$insertion_cours_achete = $bdd->prepare('insert into cours_pris(id, cours) values (:id, :cours)');
		$insertion_cours_achete->execute([
			':id'=>$id_utilisateur,
			':cours'=>$nom_cours
		]);
	}
	catch (exception $e) {
		die("Erreur : ".$e->getMessage());
	}
}

// ############################# Avant l'achat du cours ################################### //

$erreur_detectee = false;
$cours_en_cours_dachat = "";
if (!empty($_POST['cours_achete'])) {
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$erreur_detectee = true;
	}
	elseif (verifie_format_nom_cours($_POST['cours_achete'])) {
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
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$erreur_detectee = true;
	}
	elseif (verifie_format_nom_cours($_POST['cours_choisit'])) {
		acheter_cours($_POST['cours_choisit'], $utilisateur_id);
		$cours_achete = true;
		header('Location: ../PagePrincipale/Acceuil.php');
		exit;
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
	.'<input name="cours_choisit" value="'.$cours_en_cours_dachat.'" hidden>'
	.'<input type="hidden" name="csrf_token" value="'.htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8').'">';
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
