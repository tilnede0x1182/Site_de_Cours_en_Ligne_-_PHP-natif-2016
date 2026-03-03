<?php
/**
 *	Template header HTML.
 *	Génère la structure HTML commune : <!DOCTYPE>, <head>, début du <body>.
 *
 *	@param string $title Titre de la page
 *	@param array $css_files Liste des fichiers CSS à inclure (chemins relatifs depuis assets/css/)
 */

if (!isset($title)) {
	$title = 'Cours en ligne';
}
if (!isset($css_files)) {
	$css_files = ['style.css'];
}
if (!isset($root_path)) {
	$root_path = path_to_root(__FILE__);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
	<meta name="description" content="Site de cours en ligne">
	<link rel="icon" href="<?php echo $root_path; ?>assets/favicon.ico" type="image/x-icon">
<?php foreach ($css_files as $css_file): ?>
	<link href="<?php echo $root_path; ?>assets/css/<?php echo $css_file; ?>" rel="stylesheet">
<?php endforeach; ?>
</head>
<body>
