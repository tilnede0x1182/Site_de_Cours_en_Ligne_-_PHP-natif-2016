<?php
/**
 *	Point d'entrée unique pour l'initialisation.
 *	Charge la configuration, la session, la connexion BDD et les fonctions.
 */

// ==============================================================================
// Configuration
// ==============================================================================

require_once __DIR__ . '/config.php';

// ==============================================================================
// Session
// ==============================================================================

require_once __DIR__ . '/session.php';

// ==============================================================================
// Connexion Base de données
// ==============================================================================

require_once DATABASE_PATH . '/connection.php';

// ==============================================================================
// Fonctions utilitaires
// ==============================================================================

require_once __DIR__ . '/fonctions.php';
require_once __DIR__ . '/require_login.php';
require_once __DIR__ . '/verifie_identifiants.php';

// ==============================================================================
// Models
// ==============================================================================

require_once DATABASE_PATH . '/models/Membre.php';
require_once DATABASE_PATH . '/models/Cours.php';

// ==============================================================================
// Fonctions helpers
// ==============================================================================

/**
 *	Redirige vers une URL et termine le script.
 *
 *	@param string $url URL de destination
 *	@return void
 */
function redirect($url) {
	header('Location: ' . $url);
	exit;
}

/**
 *	Génère un input hidden pour le token CSRF.
 *
 *	@return string HTML de l'input CSRF
 */
function csrf_input() {
	return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 *	Retourne le chemin relatif vers la racine depuis un fichier.
 *
 *	@param string $current_file __FILE__ du fichier appelant
 *	@return string Chemin relatif vers la racine
 */
function path_to_root($current_file) {
	$depth = substr_count(str_replace(ROOT_PATH, '', dirname($current_file)), DIRECTORY_SEPARATOR);
	return str_repeat('../', $depth);
}

?>
