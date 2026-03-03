<?php
/**
 *	Model Membre.
 *	Fonctions liées aux membres/utilisateurs.
 */

// ==============================================================================
// Récupération d'informations
// ==============================================================================

/**
 *	Récupère le nom et prénom d'un utilisateur.
 *
 *	@param string $id_membre Identifiant du membre
 *	@return array [nom, prenom] ou tableau vide si non trouvé
 */
function nom_user($id_membre) {
	global $bdd;

	$nom = "";
	$prenom = "";

	if (empty($id_membre)) {
		return [$nom, $prenom];
	}

	try {
		$requete_nom = $bdd->prepare('SELECT nom, prenom FROM membres WHERE id = :id LIMIT 1');
		$requete_nom->execute([':id' => $id_membre]);
		$resultat = $requete_nom->fetch(PDO::FETCH_ASSOC);

		if (!empty($resultat['nom'])) {
			$nom = $resultat['nom'];
		}
		if (!empty($resultat['prenom'])) {
			$prenom = $resultat['prenom'];
		}
	}
	catch (Exception $exception_bdd) {
		echo "Membre.php : Erreur BDD : " . $exception_bdd->getMessage();
	}

	return [$nom, $prenom];
}

?>
