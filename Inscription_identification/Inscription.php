<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<link rel="stylesheet" href="../CSS/Background.css">
</head>
<body>
<?php

	include "Fonctions_de_verification.php";

	include "../Base_de_donnees/Connection_bdd.php";
	include "../Header/logo_du_site.php";

	$affiche_questionnaire = true;


// ######## Initialisation des variables pour le formulaire (s'il a déjà été remplit) ############ //

	$nom="";
	if (!empty($_POST['nom'])) $nom = $_POST['nom'];
	$prenom="";
	if (!empty($_POST['prenom'])) $prenom = $_POST['prenom'];
	$mail="";
	if (!empty($_POST['mail'])) $mail = $_POST['mail'];
	$pays="";
	if (!empty($_POST['pays'])) $pays = $_POST['pays'];
	$adresse="";
	if (!empty($_POST['adresse'])) $adresse = $_POST['adresse'];
	$d1="";
	if (!empty($_POST['d1'])) $d1 = $_POST['d1'];
	$d2="";
	if (!empty($_POST['d2'])) $d2 = $_POST['d2'];
	$d3="";
	if (!empty($_POST['d3'])) $d3 = $_POST['d3'];
	$id="";
	if (!empty($_POST['id'])) $id = $_POST['id'];
	$mdp1="";
	if (!empty($_POST['id'])) $mdp1 = $_POST['mdp1'];
	$mdp2="";
	if (!empty($_POST['id'])) $mdp2 = $_POST['mdp2'];


// ################################## Tests de débuggage ######################################### //

// ####************ Pour le test : activation/désactivation du required en html) *************#### //

	$required="";
	$required="required";

// ####***************************************************************************************#### //
// ####******* Pour le test : activation/désactivation d type email pour la vérification *****#### //
// ####************* de la correction des adresses mails entrés par le navigateur ************#### //

	// # ************** Vérification désactivée **************** # //
	$ligne_du_mail = ' <dd><input type="text" name="mail" value="'
	.$mail.'" '.$required.'></dd>';

	// # **************** Vérification activée ***************** # //
	$ligne_du_mail = '<dd><input type="email" name="mail" value="'
	.$mail.'" '.$required.'></dd>';

// ############################################################################################### //

/**
	On vérifie si l'utilisateur a entré quelque chose.
**/

if (!(empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['mail'])
	&& empty($_POST['adresse']) && empty($_POST['id']) && empty($_POST['pays'])
	&& empty($_POST['d1']) && empty($_POST['d2']) && empty($_POST['d3']))) {

	if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail'])
		|| empty($_POST['adresse']) || empty($_POST['id'])
		|| empty($_POST['mdp1']) || empty($_POST['mdp2'])) {

		echo '<p class="warning">
			Certaines informations manquent.
		</p>';
	}
	else {
		$affiche_questionnaire = false;

		try {
			$requette_id = $bdd->query('select id from '
			.'id_mdp where id="'.$_POST['id'].'"');
		}
		catch (exception $e) {
			die("Erreur : ".$e->getMessage());
		}

		try {
			$recherche=true;
			while (($x = $requette_id->fetch()) && $recherche) {
				if (!empty($x['id'])) {
					if ($id==$x['id']) {
						$recherche=false;
						echo '<p class="warning">
							Cet identifiant est déjà pris.
							Veuillez en trouver un autre.
						</p>';
						$affiche_questionnaire = true;
					}
				}
			}
		}
		catch (exception $e) {
			die("Erreur : ".$e->getMessage());
		}
	}

	if (!empty($_POST['nom']) || !empty($_POST['prenom']) || !empty($_POST['pays'])) {
		if (!verifie_autres_champs($_POST['nom'])
		|| !verifie_autres_champs($_POST['prenom'])
		|| !verifie_autres_champs($_POST['pays'])) {
			echo '<p class="warning">
				Nom, prénom, pays incorrect.
				Charactères autorisés : lettres, chiffres, et espaces.
 			</p>';
			$affiche_questionnaire = true;
		}
	}

	if (!empty($_POST['id'])) {
		if (!verifie_id($_POST['id'])) {
			echo '<p class="warning">
				Identifiant incorrect. Charactères autorisés : lettres, chiffres, '."'_' et '-'.".'
 			</p>';
			$affiche_questionnaire = true;
		}
	}

	if (!empty($_POST['adresse'])) {
		if (!verifie_asresse($_POST['adresse'])) {
			echo '<p class="warning">
				Format d'."'".'adresse incorrect.
				Charactères autorisés : lettres, chiffres, et espaces et '."'-'".'.'
 			.'</p>';
			$affiche_questionnaire = true;
		}
	}

	if (!empty($_POST['mdp1']) && !empty($_POST['mdp2'])) {
		if ($_POST['mdp1']!=$_POST['mdp2']) {
			echo '<p class="warning">
				Attention, le mots de passe entrés ne sont pas identiques.
 			</p>';
			$mdp1="";
			$mdp2="";
			$affiche_questionnaire = true;
		}
		else {
			if (!verifie_mdp($mdp1)) {
				echo '<p class="warning">
					Il faut entrer au mois 8 charactères, avec 
					au moins :<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
					- Une lettre majuscule <br> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
					- Un chiffre. <br> <br>

					Les charactères autorisés pour les mots de 
					passes sont : <br> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
					- Les lettres <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp
					- Les chiffres <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'
					.'- '."'_'".'.
 				</p>';
				$mdp1="";
				$mdp2="";
				$affiche_questionnaire = true;
			}
		}
	}

	$affiche_erreur_date_naissance = false;
	if (!empty($_POST['d1']) || !empty($_POST['d2']) || !empty($_POST['d3'])) {
		if (empty($_POST['d1']) || empty($_POST['d2']) || empty($_POST['d3'])) {
			$affiche_erreur_date_naissance = true;
		}
		else {
			if (!verifie_date_de_naissance_valide($_POST['d1'],
					 $_POST['d2'], $_POST['d3'])) {
				$affiche_erreur_date_naissance = true;
			}
		}
		if ($affiche_erreur_date_naissance) {
			echo '<p class="warning">
				Veuillez donner une date de naissance valide 
				(si vous souhaitez la donner).
			</p>';
			$affiche_questionnaire = true;
		}
	}

	if (!empty($_POST['mail'])) {
		if (check_mail_adress($_POST['mail'])) {
		}
		else {
			echo '<p class="warning">
				Veuillez entrer une adresse email valide.
 			</p>';
			$affiche_questionnaire = true;
		}
	}
}

if ($affiche_questionnaire) {
	echo '
﻿	<h2 class="titre">Inscription nouveau membre : </h2>
	<form action="" method="POST">
	<dl>
	<dt><label for "Nom">Nom :</label></dt>
	<dd><input type="text" name="nom" value="'.$nom.'" '.$required.'></dd>
	<dt><label for "Prénom">Prénom :</label></dt>
	<dd><input type="text" name="prenom" value="'.$prenom.'" '.$required.'></dd>
	<dt><label for "Identifiant">Identifiant :</label></dt>
	<dd><input type="text" name="id" value="'.$id.'" '.$required.'></dd>
	<dt><label for "Mot de passe1">Mot de passe :</label></dt>
	<dd><input type="password" name="mdp1" value="'.$mdp1.'" '.$required.'></dd>
	<dt><label for "Mot de passe2">Répétez le mot de passe :</label></dt>
	<dd><input type="password" name="mdp2" value="'.$mdp2.'" '.$required.'></dd>
	<dt><label for "e-mail">e-mail :</label></dt>';
	echo $ligne_du_mail;
	echo '	<dt><label for "Pays">Pays :</label></dt>
	<dd><input type="text" name="pays" value="'.$pays.'"> </dd>
	<dt><label for "Adresse">Adresse :</label></dt>
	<dd><input type="text" name="adresse" value="'.$adresse.'" '.$required.'></dd>
	<dt><label for "Date de naissance">Date de naissance (facultatif) :</label></dt>
	<dd><input type="text" name="d1" size="2" value="'.$d1.'">
	<input type="text" name="d2" size="2" value="'.$d2.'">
	<input type="text" name="d3" size="4" value="'.$d3.'"> (JJ/MM/AAAA) </dd>
	</dl>
	<dd><input type="submit" value="Valider"></dd>
	</form>';
	echo '<p><a href="../PagePrincipale/Acceuil.php">'
	.'Retour à la page d'."'".'accueil sans inscription</a></p>';
}

else {
	if (empty($_POST['d1']) || empty($_POST['d2']) || empty($_POST['d3'])) {
		$date_naissance="00000000";
	}
	else $date_naissance=$d1.$d2.$d3;

	echo '<p class="warning">
		Questionnaire remplit.
	</p>';

	$requette_id_mdp="insert into id_mdp (id, mot_de_passe) values ('".$id."', '".md5($mdp1)."');";
	$requette_membres="insert into membres(id_membres, nom, prenom, date_de_naissance, mail, pays, "
	."id ,admin) "
	." values ('', '"
	.$nom."', '"
	.$prenom."', '"
	.$date_naissance."', '"
	.$mail."', '"
	.$pays."', '"
	.$id."',"
	."false"
	.");";

	try {
		$inscription_id_mdp = $bdd->exec($requette_id_mdp);
		$inscription_membres = $bdd->exec($requette_membres);
	}
	catch (exception $e) {
		die("Erreur : ".$e->getMessage());

		echo '<p class="warning">
			Problèmes avec la requête SQL.
		</p>';
	}

	echo '<p><a href="../PagePrincipale/Acceuil.php">'
	.'Retour à la page d'."'".'accueil</a></p>';

	header('Location: ../PagePrincipale/Acceuil.php');
}

?>

</body>
</html>