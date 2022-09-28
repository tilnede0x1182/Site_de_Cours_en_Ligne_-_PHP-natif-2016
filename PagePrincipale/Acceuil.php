<!DOCTYPE html>
<html lang="fr">
<head>	
	<meta charset="utf-8">
	<title>Accueil - Cours en ligne</title>
	<meta name="description" content="courte description">
	<link href="../CSS/Acceuil.css" rel="stylesheet">
	<link href="../CSS/Background.css" rel="stylesheet">
</head>
<body>
<?php
	session_start();

	include "../Inscription_identification/Verifie_identifiants_connection.php";
	$identifiants_entres_incorrects = false;
	$function_verifie_id_mdp=true;

	include "../Inscription_identification/Fonctions_de_verification.php";

	if (!empty($_POST['id']) && empty($_POST['mdp'])
	|| empty($_POST['id']) && !empty($_POST['mdp'])) {
		$identifiants_entres_incorrects = true;
	}

	if (!empty($_POST['id']) && !empty($_POST['mdp'])) {
		if (!verifie_id($_POST['id']) || !verifie_mdp($_POST['mdp'])) {
			$identifiants_entres_incorrects = true;
		}
		if (verifie_id($_POST['id']) && verifie_mdp($_POST['mdp'])) {
			if (verifie_id_connection($_POST['id'], 
			md5($_POST['mdp']))) {
				$_SESSION['id']=$_POST['id'];
				$_SESSION['mdp']=md5($_POST['mdp']);
			}
			else {
				$identifiants_entres_incorrects = true;
			}
		}
	}


// ################ Initialisation des variables du formulaire d'ientification ################### //

	$id="";
	if (!empty($_POST['id'])) $id=$_POST['id'];
	$mdp="";
	if (!empty($_POST['mdp'])) $mdp=$_POST['mdp'];

// ############################################################################################### //

	include "../Header/logo_du_site.php";
	include "../Inscription_identification/Identification.php";

	$mode_enerve = false;
	if (!empty($_GET['mode_enerve'])) {
		if ($_GET['mode_enerve']=="true") {
			$mode_enerve = true;
		}
	}

echo '<nav class="nav_acceuil">
	<h4 class="titre">Cours disponibles :</h4>
	<ul>';
		if (empty($_SESSION['id']))
			$_SESSION['id'] = "";
		$cours_pris = verifie_cours_pris($_SESSION['id']);
		for ($i=1; $i<4; $i=$i+1) {
			echo '<li>';
			if ($identifie) {
				if (!verifie_un_cours_pris_avec_liste(
				'Cours'.$i, $cours_pris)) {
					echo 'Cours '.$i;
					echo '<form  class="achat_cours" '
					.'action="../Paiement/formulaire_de_paiement.php"'
					.' method="POST">'
					.'<input name="cours_achete" value="Cours'.$i
					.'" hidden></input>'
					.'<input type="submit" value="Acheter"'
					.'" value="Acheter">'
					.'</input>'
					.'</form>';
				}
				else {
					echo '<a href="../Pages des cours/Cours.php?'
					.'Cours='.$i.'"'
					.'>Cours '.$i.'</a>';
				}
			}
			else {
				if (!$mode_enerve) {
					echo '<a href="./Acceuil.php?mode_enerve=true">'
					.'Cours '.$i.'</a>';
					echo '<a class="achat_cours" '
					.'href="./Acceuil.php?mode_enerve=true">Acheter</a>';
				}
				else {
					echo '<a href="">Cours '.$i.'</a>';
					echo '<a class="achat_cours" href="">Acheter</a>';
					echo '<img class="img_warning"'
					.'src="../Images/Autre/50px-Panneau_Attention.png"'
					.' alt="Warning !">';
					echo '<span class="warning_inscription">Cours '
					.'indisponible hors <a href="../Inscription_identification/'
					.'Inscription.php'
					.'">inscription.</a>'
					.'</span>';
				}
			}
			echo '
			</li>';
		}

	echo '</ul>';

	if (!$identifie) {
		$class_mode_enervee="";
		if ($mode_enerve) {
			echo '<img class="warning_insciption_bas_de_page"'
			.' src="../Images/Autre/50px-Panneau_Attention.png"'
			.' alt="Attention !">';
			$class_mode_enervee = " mode_enerve";
		}
		echo '<div class="warning_insciption_bas_de_page'.$class_mode_enervee.'"'
		.'>Attention, pour consulter des cours, '
		.'vous devez vous '
		.'<a href="../Inscription_identification/Inscription.php">inscrire</a>.<br>'
		.'Si c'."'".'est déjà fait, identifez-vous.'
		.'</div>';

		echo '<div class="cote_droit form_didentification">'
		.'<form action="./Acceuil.php" method="POST">'
		.'<label for "identifiant">Identifiant :</label> <br>'
		.'<input type="text" value="'.$id.'" name="id"></input> <br>'
		.'<label for "mdp">Mot de passe :</label> <br>'
		.'<input type="password" value="'.$mdp.'" name ="mdp"></input> <br>'
		.'<input type="submit" value="Se connecter" method="post"></input> <br>'
		.'</form>'
		.'<a href="../Inscription_identification/Inscription.php">S'."'".'inscrire</a>';
		if ($identifiants_entres_incorrects) {
			echo '<p class="imossible_de_se_connecter">Mot de passe/identifiant <br>'
			.'incorrects'
			.': impossible de <br> se connecter</p>';
		}
	}
	else {
		echo '<div class="cote_droit actions_connecte">';
		//echo '<p><a href="">Modifier les informations de mon compte</a>
		//</p>';
		include "../Base_de_donnees/Fonction_recuperation_dinofs.php";
		$nom_user="";
		$prenom_user="";
		$nom_tmp = nom_user($_SESSION['id']);
		if (empty($nom_tmp)) {
			echo '<p>Bonjour '.$_SESSION['id'].'.</p>';
		}
		else {
			$nom_user = $nom_tmp[0];
			$prenom_user = $nom_tmp[1];
			echo '<p>Bonjour '.$prenom_user.' '.$nom_user.' ('.$_SESSION['id'].').</p>';
		}
		echo '<p><a href="Deconnection.php">Deconnection</a>
		</p>';
		echo '</div>';
	}
?>

</nav>
</body>
</html>