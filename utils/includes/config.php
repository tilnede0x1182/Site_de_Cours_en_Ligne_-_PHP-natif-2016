<?php
/**
 *	Configuration globale du projet.
 *	Définit les constantes de chemins et les paramètres de connexion BDD.
 */

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
// Base de données
// ==============================================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'cours_1_bis');
define('DB_USER', 'tilnede0x1182');
define('DB_PASSWORD', 'tilnede0x1182');
define('DB_CHARSET', 'utf8');

// ==============================================================================
// URLs de redirection
// ==============================================================================

define('URL_ACCUEIL', SRC_PATH . '/pages/Accueil/index.php');
define('URL_CONNEXION', SRC_PATH . '/pages/Auth/Connexion.php');

?>
