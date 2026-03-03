<?php
/**
 *	Vérification de connexion.
 *	Ce fichier est inclus par d'autres pages pour vérifier si l'utilisateur est connecté.
 *	Note : La logique de connexion est maintenant dans Accueil/index.php.
 *	Ce fichier peut être supprimé si non utilisé ailleurs.
 */

require_once __DIR__ . '/../../../utils/includes/init.php';

$identifie = false;
if (!empty($_SESSION['id']) && !empty($_SESSION['mdp'])) {
	if (verifie_id_connection($_SESSION['id'], $_SESSION['mdp'], true)) {
		$identifie = true;
	}
}

?>
