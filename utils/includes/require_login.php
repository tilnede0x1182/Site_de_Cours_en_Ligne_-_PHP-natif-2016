<?php
/**
 * Vérification de connexion utilisateur.
 * Redirige vers l'accueil si l'utilisateur n'est pas connecté.
 */

/**
 * Vérifie que l'utilisateur est connecté.
 * Redirige vers l'accueil si non connecté ou si les identifiants sont invalides.
 *
 * @return string L'identifiant de l'utilisateur connecté
 */
function require_login() {
	if (empty($_SESSION['id']) || empty($_SESSION['mdp'])) {
		redirect('../Accueil/index.php');
	}
	if (!verifie_id_connection($_SESSION['id'], $_SESSION['mdp'], true)) {
		$_SESSION = [];
		session_regenerate_id(true);
		redirect('../Accueil/index.php');
	}
	return $_SESSION['id'];
}
?>
