<?php
/**
 *	Template logo du site.
 *	Affiche le logo dans le header.
 */

if (!isset($root_path)) {
	$root_path = path_to_root(__FILE__);
}
?>
<header>
<img class="Logo_du_site" 
src="<?php echo $root_path; ?>assets/images/logo/Logo1.png" 
alt="Logo du site">
</header>
