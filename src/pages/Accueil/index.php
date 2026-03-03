<?php
/**
 *	Page d'accueil - Cours en ligne.
 *	Affiche la liste des cours et le formulaire de connexion.
 */

// ==============================================================================
// Initialisation
// ==============================================================================

require_once __DIR__ . '/../../../utils/includes/init.php';

$root_path = '../../../';

// ==============================================================================
// Traitement connexion
// ==============================================================================

$identifiants_entres_incorrects = false;

if (!empty($_POST['id']) && empty($_POST['mdp'])
	|| empty($_POST['id']) && !empty($_POST['mdp'])) {
	$identifiants_entres_incorrects = true;
}

if (!empty($_POST['id']) && !empty($_POST['mdp'])) {
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$identifiants_entres_incorrects = true;
	}
	elseif (!verifie_id($_POST['id']) || !verifie_mdp($_POST['mdp'])) {
		$identifiants_entres_incorrects = true;
	}
	else {
		try {
			$requete_connexion = $bdd->prepare('SELECT mot_de_passe FROM id_mdp WHERE id = :id LIMIT 1');
			$requete_connexion->execute([':id' => $_POST['id']]);
			$credentials = $requete_connexion->fetch(PDO::FETCH_ASSOC);
			if ($credentials && (password_verify($_POST['mdp'], $credentials['mot_de_passe']) || hash_equals($credentials['mot_de_passe'], md5($_POST['mdp'])))) {
				$_SESSION['id'] = $_POST['id'];
				$_SESSION['mdp'] = $credentials['mot_de_passe'];
				$identifiants_entres_incorrects = false;
			}
			else {
				$identifiants_entres_incorrects = true;
			}
		}
		catch (Exception $exception_connexion) {
			$identifiants_entres_incorrects = true;
		}
	}
}

if ($identifiants_entres_incorrects) {
	unset($_SESSION['id'], $_SESSION['mdp']);
}

// ==============================================================================
// Vérification si identifié
// ==============================================================================

$identifie = false;
if (!empty($_SESSION['id']) && !empty($_SESSION['mdp'])) {
	if (verifie_id_connection($_SESSION['id'], $_SESSION['mdp'], true)) {
		$identifie = true;
	}
}

// ==============================================================================
// Variables du formulaire
// ==============================================================================

$id_formulaire = "";
if (!empty($_POST['id'])) {
	$id_formulaire = $_POST['id'];
}
$mdp_formulaire = "";
if (!empty($_POST['mdp'])) {
	$mdp_formulaire = $_POST['mdp'];
}

$afficher_message_inscription_requise = false;
if (!empty($_GET['inscription_requise']) && $_GET['inscription_requise'] == "true") {
	$afficher_message_inscription_requise = true;
}

// ==============================================================================
// Récupération des cours achetés
// ==============================================================================

if (empty($_SESSION['id'])) {
	$_SESSION['id'] = "";
}
$cours_pris = verifie_cours_pris($_SESSION['id']);

// ==============================================================================
// Vue HTML
// ==============================================================================

$title = 'Accueil - Cours en ligne';
$css_files = ['style.css'];
include $root_path . 'utils/templates/header.php';
include $root_path . 'utils/templates/logo.php';
?>

<nav class="nav_acceuil">
	<h4 class="titre">Cours disponibles :</h4>
	<ul>
<?php for ($index_cours = 1; $index_cours < 4; $index_cours++): ?>
		<li>
<?php if ($identifie): ?>
	<?php if (!verifie_un_cours_pris_avec_liste('Cours' . $index_cours, $cours_pris)): ?>
			Cours <?php echo $index_cours; ?>
			<form class="achat_cours" action="<?php echo $root_path; ?>src/pages/Paiement/Formulaire.php" method="POST">
				<input name="cours_achete" value="Cours<?php echo $index_cours; ?>" hidden>
				<?php echo csrf_input(); ?>
				<input type="submit" value="Acheter">
			</form>
	<?php else: ?>
			<a href="<?php echo $root_path; ?>src/pages/Cours/Liste.php?Cours=<?php echo $index_cours; ?>">Cours <?php echo $index_cours; ?></a>
	<?php endif; ?>
<?php else: ?>
	<?php if (!$afficher_message_inscription_requise): ?>
			<a href="index.php?inscription_requise=true">Cours <?php echo $index_cours; ?></a>
			<a class="achat_cours" href="index.php?inscription_requise=true">Acheter</a>
	<?php else: ?>
			<a href="">Cours <?php echo $index_cours; ?></a>
			<a class="achat_cours" href="">Acheter</a>
			<img class="img_warning" src="<?php echo $root_path; ?>assets/images/autre/50px-Panneau_Attention.png" alt="Warning !">
			<span class="warning_inscription">Cours indisponible hors <a href="../Auth/Inscription.php">inscription.</a></span>
	<?php endif; ?>
<?php endif; ?>
		</li>
<?php endfor; ?>
	</ul>

<?php if (!$identifie): ?>
	<?php if ($afficher_message_inscription_requise): ?>
	<img class="warning_insciption_bas_de_page" src="<?php echo $root_path; ?>assets/images/autre/50px-Panneau_Attention.png" alt="Attention !">
	<?php endif; ?>
	<div class="warning_insciption_bas_de_page<?php echo $afficher_message_inscription_requise ? ' alerte_inscription' : ''; ?>">
		Attention, pour consulter des cours, vous devez vous <a href="../Auth/Inscription.php">inscrire</a>.<br>
		Si c'est déjà fait, identifiez-vous.
	</div>

	<div class="cote_droit form_didentification">
		<form action="index.php" method="POST">
			<?php echo csrf_input(); ?>
			<label for="identifiant">Identifiant :</label><br>
			<input type="text" value="<?php echo htmlspecialchars($id_formulaire, ENT_QUOTES, 'UTF-8'); ?>" name="id"><br>
			<label for="mdp">Mot de passe :</label><br>
			<input type="password" value="<?php echo htmlspecialchars($mdp_formulaire, ENT_QUOTES, 'UTF-8'); ?>" name="mdp"><br>
			<input type="submit" value="Se connecter"><br>
		</form>
		<a href="../Auth/Inscription.php">S'inscrire</a>
		<?php if ($identifiants_entres_incorrects): ?>
		<p class="imossible_de_se_connecter">Mot de passe/identifiant<br>incorrects : impossible de<br>se connecter</p>
		<?php endif; ?>
	</div>
<?php else: ?>
	<div class="cote_droit actions_connecte">
		<?php
		$nom_tmp = nom_user($_SESSION['id']);
		if (empty($nom_tmp[0]) && empty($nom_tmp[1])):
		?>
		<p>Bonjour <?php echo htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8'); ?>.</p>
		<?php else: ?>
		<p>Bonjour <?php echo htmlspecialchars($nom_tmp[1], ENT_QUOTES, 'UTF-8'); ?> <?php echo htmlspecialchars($nom_tmp[0], ENT_QUOTES, 'UTF-8'); ?> (<?php echo htmlspecialchars($_SESSION['id'], ENT_QUOTES, 'UTF-8'); ?>).</p>
		<?php endif; ?>
		<p><a href="<?php echo $root_path; ?>src/pages/Auth/Deconnexion.php">Déconnexion</a></p>
	</div>
<?php endif; ?>
</nav>

<?php include $root_path . 'utils/templates/footer.php'; ?>
