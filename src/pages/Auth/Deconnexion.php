<?php
/**
 *	Déconnexion de l'utilisateur.
 *	Détruit la session et redirige vers l'accueil.
 */

require_once __DIR__ . '/../../../utils/includes/init.php';

$_SESSION = [];
session_regenerate_id(true);
session_destroy();

redirect('../Accueil/index.php');
?>
