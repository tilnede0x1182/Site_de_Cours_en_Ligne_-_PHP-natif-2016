<?php
/**
 * Page d'affichage d'un cours.
 * Vérifie que l'utilisateur est connecté et a acheté le cours demandé.
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

// ==============================================================================
// Vérification accès
// ==============================================================================

$utilisateur_connecte = require_login();

// Détermination du numéro du cours
$numero_du_cours = 0;
if (!empty($_GET["Cours"])) {
	$numero_candidat = (int)$_GET["Cours"];
	if ($numero_candidat >= 1 && $numero_candidat <= 3) {
		if (verifie_un_cours_pris($utilisateur_connecte, 'Cours' . $numero_candidat)) {
			$numero_du_cours = $numero_candidat;
		}
	}
}

if ($numero_du_cours === 0) {
	redirect('../Accueil/index.php');
}

// Autoriser l'inclusion des partials
if (!defined('COURS_PARTIAL_AUTORISE')) {
	define('COURS_PARTIAL_AUTORISE', true);
}

// ==============================================================================
// Affichage
// ==============================================================================

$root_path = '../../../';
$title = "Cours " . $numero_du_cours;
$css_files = ['style.css'];
include ROOT_PATH . '/utils/templates/header.php';
include ROOT_PATH . '/utils/templates/logo.php';
include __DIR__ . '/Menu.php';

// Inclusion du contenu du cours (fichiers HTML)
$fichier_cours = __DIR__ . '/Contenu/Cours' . $numero_du_cours . '.html';
if (file_exists($fichier_cours)) {
	include $fichier_cours;
} else {
	echo '<p class="warning">Contenu du cours non disponible.</p>';
}

include ROOT_PATH . '/utils/templates/footer.php';
?>
