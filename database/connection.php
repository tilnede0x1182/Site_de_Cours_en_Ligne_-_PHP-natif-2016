<?php
/**
 *	Connexion à la base de données.
 *	Utilise les constantes définies dans config.php.
 */

// ==============================================================================
// Connexion PDO
// ==============================================================================

try {
	$dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
	if (defined('DB_CHARSET') && DB_CHARSET !== '') {
		$dsn .= ';charset=' . DB_CHARSET;
	}

	$bdd = new PDO(
		$dsn,
		DB_USER,
		DB_PASSWORD,
		[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
	);
}
catch (Exception $exception_pdo) {
	die("connection.php : Erreur de connexion BDD : " . $exception_pdo->getMessage());
}

?>
