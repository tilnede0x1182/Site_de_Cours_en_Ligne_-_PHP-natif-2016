<?php
/**
 * Formulaire de paiement pour l'achat d'un cours.
 * Vérifie que l'utilisateur est connecté avant d'afficher le formulaire.
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

// ==============================================================================
// Vérification accès
// ==============================================================================

$utilisateur_id = require_login();

// ==============================================================================
// Traitement du formulaire
// ==============================================================================

$erreur_detectee = false;
$cours_en_cours_dachat = "";
$cours_achete = false;

// Avant l'achat du cours (sélection)
if (!empty($_POST['cours_achete'])) {
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$erreur_detectee = true;
	} elseif (verifie_format_nom_cours($_POST['cours_achete'])) {
		$cours_en_cours_dachat = $_POST['cours_achete'];
	} else {
		$erreur_detectee = true;
	}
}

// Une fois le cours choisi (validation)
if (!empty($_POST['cours_choisit'])) {
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$erreur_detectee = true;
	} elseif (verifie_format_nom_cours($_POST['cours_choisit'])) {
		acheter_cours($_POST['cours_choisit'], $utilisateur_id);
		$cours_achete = true;
		redirect('../Accueil/index.php');
	} else {
		$erreur_detectee = true;
	}
}

// ==============================================================================
// Affichage
// ==============================================================================

$root_path = '../../../';
$title = "Achat d'un cours";
$css_files = ['style.css'];
include ROOT_PATH . '/utils/templates/header.php';
?>

<div class="container paiement">
	<img src="<?php echo $root_path; ?>assets/images/autre/formulaire_de_paiement_exemple.jpg" alt="Formulaire de paiement (image)">

	<div>
		<form action="" method="POST">
			<input name="cours_choisit" value="<?php echo htmlspecialchars($cours_en_cours_dachat); ?>" hidden>
			<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

			<?php if (!$cours_achete): ?>
				<?php if ($erreur_detectee): ?>
					<p class="erreur_detectee">Une erreur a été détectée. Veuillez réessayer ultérieurement. Aucun achat n'a pu être effectué.</p>
					<a href="../Accueil/index.php">Retour à l'accueil</a>
				<?php else: ?>
					<input type="submit" value="Valider">
		</form>
					<a href="../Accueil/index.php">Abandon et retour à l'accueil</a>
				<?php endif; ?>
			<?php else: ?>
				<p>Achat effectué.</p>
				<a href="../Accueil/index.php">Retour à l'accueil</a>
			<?php endif; ?>
	</div>
</div>

<?php include ROOT_PATH . '/utils/templates/footer.php'; ?>
