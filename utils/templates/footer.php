<?php
/**
 *	Template footer HTML.
 *	Ferme le body et html, affiche la licence.
 */

if (!isset($root_path)) {
	$root_path = path_to_root(__FILE__);
}
?>
<footer>
<p>
Licence : OpenClassRoom :
<img class="CC_image" src="<?php echo $root_path; ?>assets/images/autre/CreativeCommons.jpg" alt="Creative Commons Logo">
</p>
</footer>
</body>
</html>
