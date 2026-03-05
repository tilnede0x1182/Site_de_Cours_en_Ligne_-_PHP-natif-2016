<?php
/**
 *	Configuration globale du projet.
 *	Définit les constantes de chemins et les paramètres de connexion BDD.
 */

// ==============================================================================
// Chargement du .env
// ==============================================================================

/**
 *	Charge les variables d'environnement depuis un fichier .env
 *
 *	@param string $path Chemin vers le fichier .env
 */
function load_env_file($path) {
	if (!file_exists($path)) {
		return;
	}
	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		$line = trim($line);
		if ($line === '' || $line[0] === '#') {
			continue;
		}
		$pos = strpos($line, '=');
		if ($pos === false) {
			continue;
		}
		$key = trim(substr($line, 0, $pos));
		$value = trim(substr($line, $pos + 1));
		$_ENV[$key] = $value;
		putenv("$key=$value");
	}
}

// Charger le .env depuis la racine du projet
load_env_file(dirname(dirname(__DIR__)) . '/.env');

// ==============================================================================
// Chemins
// ==============================================================================

define('ROOT_PATH', dirname(dirname(__DIR__)));
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('DATABASE_PATH', ROOT_PATH . '/database');
define('UTILS_PATH', ROOT_PATH . '/utils');
define('SRC_PATH', ROOT_PATH . '/src');

// Chemins relatifs pour les URLs (depuis la racine web)
define('ASSETS_URL', '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('IMAGES_URL', ASSETS_URL . '/images');

// ==============================================================================
// Base de données (depuis .env)
// ==============================================================================

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? '');
define('DB_USER', $_ENV['DB_USER'] ?? '');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_CHARSET', 'utf8');

// ==============================================================================
// URLs de redirection
// ==============================================================================

define('URL_ACCUEIL', SRC_PATH . '/pages/Accueil/index.php');
define('URL_CONNEXION', SRC_PATH . '/pages/Auth/Connexion.php');

?>
