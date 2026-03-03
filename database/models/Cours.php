<?php
/**
 *	Model Cours.
 *	Fonctions liées aux cours et achats de cours.
 */

// ==============================================================================
// Vérification des cours achetés
// ==============================================================================

/**
 *	Récupère la liste des cours achetés par un utilisateur.
 *
 *	@param string $id_membre Identifiant du membre
 *	@return array Tableau associatif [nom_cours => "pris"]
 */
function verifie_cours_pris($id_membre) {
	global $bdd;

	$resultat = [];

	if (empty($id_membre)) {
		return $resultat;
	}

	try {
		$requete_cours = $bdd->prepare('SELECT cours FROM cours_pris WHERE id = :id');
		$requete_cours->execute([':id' => $id_membre]);

		while ($ligne = $requete_cours->fetch(PDO::FETCH_ASSOC)) {
			if (!empty($ligne['cours'])) {
				$resultat[$ligne['cours']] = "pris";
			}
		}
	}
	catch (Exception $exception_bdd) {
		echo "Cours.php : Erreur BDD : " . $exception_bdd->getMessage();
	}

	return $resultat;
}

/**
 *	Vérifie si un cours est dans la liste des cours achetés.
 *
 *	@param string $nom_cours Nom du cours (ex: "Cours1")
 *	@param array $cours_pris Liste retournée par verifie_cours_pris()
 *	@return bool True si le cours est acheté
 */
function verifie_un_cours_pris_avec_liste($nom_cours, $cours_pris) {
	return !empty($cours_pris[$nom_cours]);
}

/**
 *	Vérifie directement en BDD si un cours est acheté.
 *
 *	@param string $id_membre Identifiant du membre
 *	@param string $nom_cours Nom du cours (ex: "Cours1")
 *	@return bool True si le cours est acheté
 */
function verifie_un_cours_pris($id_membre, $nom_cours) {
	global $bdd;

	if (empty($id_membre) || empty($nom_cours)) {
		return false;
	}

	try {
		$requete_cours = $bdd->prepare('SELECT 1 FROM cours_pris WHERE id = :id AND cours = :cours LIMIT 1');
		$requete_cours->execute([
			':id' => $id_membre,
			':cours' => $nom_cours
		]);
		return (bool)$requete_cours->fetchColumn();
	}
	catch (Exception $exception_bdd) {
		echo "Cours.php : Erreur BDD : " . $exception_bdd->getMessage();
		return false;
	}
}

/**
 *	Vérifie le format d'un nom de cours.
 *
 *	@param string $nom_cours Nom du cours à vérifier
 *	@return bool True si le format est valide (ex: "Cours1", "Cours2", "Cours3")
 */
function verifie_format_nom_cours($nom_cours) {
	if (!preg_match("/^Cours\d$/", $nom_cours)) {
		return false;
	}
	$numero_du_cours = substr($nom_cours, 5, strlen($nom_cours));
	if ($numero_du_cours < 1 || $numero_du_cours > 3) {
		return false;
	}
	return true;
}

/**
 *	Achète un cours pour un utilisateur.
 *
 *	@param string $nom_cours Nom du cours (ex: "Cours1")
 *	@param string $id_membre Identifiant du membre
 *	@return bool True si l'achat a réussi
 */
function acheter_cours($nom_cours, $id_membre) {
	global $bdd;

	try {
		$requete_achat = $bdd->prepare('INSERT INTO cours_pris(id, cours) VALUES (:id, :cours)');
		$requete_achat->execute([
			':id' => $id_membre,
			':cours' => $nom_cours
		]);
		return true;
	}
	catch (Exception $exception_bdd) {
		echo "Cours.php : Erreur achat : " . $exception_bdd->getMessage();
		return false;
	}
}

?>
