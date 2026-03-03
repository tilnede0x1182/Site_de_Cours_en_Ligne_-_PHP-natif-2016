<?php
/**
 *	Template navigation.
 *	Affiche le lien retour vers l'accueil.
 */

if (!isset($root_path)) {
	$root_path = path_to_root(__FILE__);
}
?>
<nav>
	<a href="<?php echo $root_path; ?>src/pages/Accueil/index.php">Accueil</a>
</nav>
