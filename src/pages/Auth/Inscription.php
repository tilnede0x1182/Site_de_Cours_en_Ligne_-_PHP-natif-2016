<?php
/**
 * Page d'inscription.
 * Formulaire d'inscription avec validation et insertion en BDD.
 */
require_once __DIR__ . '/../../../utils/includes/init.php';

$root_path = '../../../';

// ==============================================================================
// Initialisation des variables
// ==============================================================================

$affiche_questionnaire = true;
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$mail = $_POST['mail'] ?? '';
$pays = $_POST['pays'] ?? '';
$adresse = $_POST['adresse'] ?? '';
$jour = $_POST['d1'] ?? '';
$mois = $_POST['d2'] ?? '';
$annee = $_POST['d3'] ?? '';
$id = $_POST['id'] ?? '';
$mdp1 = $_POST['mdp1'] ?? '';
$mdp2 = $_POST['mdp2'] ?? '';
$erreurs = [];

// ==============================================================================
// Traitement du formulaire
// ==============================================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Vérification CSRF
	if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
		$erreurs[] = "Session expirée, merci de recharger le formulaire.";
	}

	// Champs obligatoires
	if (empty($nom) || empty($prenom) || empty($mail) || empty($adresse) || empty($id) || empty($mdp1) || empty($mdp2)) {
		$erreurs[] = "Certaines informations manquent.";
	}

	// Validation nom, prénom, pays
	if (!empty($nom) && !verifie_autres_champs($nom)) {
		$erreurs[] = "Nom incorrect. Caractères autorisés : lettres, chiffres, et espaces.";
	}
	if (!empty($prenom) && !verifie_autres_champs($prenom)) {
		$erreurs[] = "Prénom incorrect. Caractères autorisés : lettres, chiffres, et espaces.";
	}
	if (!empty($pays) && !verifie_autres_champs($pays)) {
		$erreurs[] = "Pays incorrect. Caractères autorisés : lettres, chiffres, et espaces.";
	}

	// Validation identifiant
	if (!empty($id) && !verifie_id($id)) {
		$erreurs[] = "Identifiant incorrect. Caractères autorisés : lettres, chiffres, '_' et '-'.";
	}

	// Validation adresse
	if (!empty($adresse) && !verifie_adresse($adresse)) {
		$erreurs[] = "Format d'adresse incorrect. Caractères autorisés : lettres, chiffres, espaces et '-'.";
	}

	// Validation mot de passe
	if (!empty($mdp1) && !empty($mdp2)) {
		if ($mdp1 !== $mdp2) {
			$erreurs[] = "Les mots de passe ne sont pas identiques.";
			$mdp1 = '';
			$mdp2 = '';
		} elseif (!verifie_mdp($mdp1)) {
			$erreurs[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
			$mdp1 = '';
			$mdp2 = '';
		}
	}

	// Validation date de naissance (facultatif)
	if (!empty($jour) || !empty($mois) || !empty($annee)) {
		if (empty($jour) || empty($mois) || empty($annee) || !verifie_date_de_naissance_valide($jour, $mois, $annee)) {
			$erreurs[] = "Veuillez donner une date de naissance valide (ou laissez les champs vides).";
		}
	}

	// Validation email
	if (!empty($mail) && !check_mail_adress($mail)) {
		$erreurs[] = "Veuillez entrer une adresse email valide.";
	}

	// Vérification identifiant unique
	if (empty($erreurs) && !empty($id)) {
		try {
			$requette_id = $bdd->prepare('SELECT id FROM id_mdp WHERE id = :id LIMIT 1');
			$requette_id->execute([':id' => $id]);
			if ($requette_id->fetch()) {
				$erreurs[] = "Cet identifiant est déjà pris. Veuillez en trouver un autre.";
			}
		} catch (Exception $exception_bdd) {
			$erreurs[] = "Erreur lors de la vérification de l'identifiant.";
		}
	}

	// Insertion en BDD si pas d'erreurs
	if (empty($erreurs)) {
		$affiche_questionnaire = false;
		$date_naissance = (empty($jour) || empty($mois) || empty($annee)) ? "00000000" : $jour . $mois . $annee;

		try {
			$hash = password_hash($mdp1, PASSWORD_DEFAULT);
			$requette_id_mdp = $bdd->prepare('INSERT INTO id_mdp (id, mot_de_passe) VALUES (:id, :mdp)');
			$requette_id_mdp->execute([':id' => $id, ':mdp' => $hash]);

			$requette_membres = $bdd->prepare('INSERT INTO membres (nom, prenom, date_de_naissance, mail, pays, id, admin) VALUES (:nom, :prenom, :date_naissance, :mail, :pays, :id, false)');
			$requette_membres->execute([
				':nom' => $nom,
				':prenom' => $prenom,
				':date_naissance' => $date_naissance,
				':mail' => $mail,
				':pays' => $pays,
				':id' => $id
			]);

			redirect('../Accueil/index.php');
		} catch (Exception $exception_bdd) {
			$erreurs[] = "Erreur lors de l'inscription : " . $exception_bdd->getMessage();
			$affiche_questionnaire = true;
		}
	}
}

// ==============================================================================
// Affichage
// ==============================================================================

$title = "Inscription";
$css_files = ['style.css'];
include $root_path . 'utils/templates/header.php';
?>

<div class="container">
	<h2 class="titre">Inscription nouveau membre :</h2>

	<?php if (!empty($erreurs)): ?>
		<?php foreach ($erreurs as $erreur): ?>
			<p class="warning"><?php echo htmlspecialchars($erreur); ?></p>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ($affiche_questionnaire): ?>
		<form action="" method="POST">
			<input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">

			<dl>
				<dt><label for="nom">Nom :</label></dt>
				<dd><input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($nom); ?>" required></dd>

				<dt><label for="prenom">Prénom :</label></dt>
				<dd><input type="text" name="prenom" id="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required></dd>

				<dt><label for="id">Identifiant :</label></dt>
				<dd><input type="text" name="id" id="id" value="<?php echo htmlspecialchars($id); ?>" required></dd>

				<dt><label for="mdp1">Mot de passe :</label></dt>
				<dd><input type="password" name="mdp1" id="mdp1" value="<?php echo htmlspecialchars($mdp1); ?>" required></dd>

				<dt><label for="mdp2">Répétez le mot de passe :</label></dt>
				<dd><input type="password" name="mdp2" id="mdp2" value="<?php echo htmlspecialchars($mdp2); ?>" required></dd>

				<dt><label for="mail">E-mail :</label></dt>
				<dd><input type="email" name="mail" id="mail" value="<?php echo htmlspecialchars($mail); ?>" required></dd>

				<dt><label for="pays">Pays :</label></dt>
				<dd><input type="text" name="pays" id="pays" value="<?php echo htmlspecialchars($pays); ?>"></dd>

				<dt><label for="adresse">Adresse :</label></dt>
				<dd><input type="text" name="adresse" id="adresse" value="<?php echo htmlspecialchars($adresse); ?>" required></dd>

				<dt><label>Date de naissance (facultatif) :</label></dt>
				<dd>
					<input type="text" name="d1" size="2" value="<?php echo htmlspecialchars($jour); ?>" placeholder="JJ">
					<input type="text" name="d2" size="2" value="<?php echo htmlspecialchars($mois); ?>" placeholder="MM">
					<input type="text" name="d3" size="4" value="<?php echo htmlspecialchars($annee); ?>" placeholder="AAAA">
				</dd>
			</dl>

			<dd><input type="submit" value="Valider"></dd>
		</form>

		<p><a href="<?php echo $root_path; ?>src/pages/Accueil/index.php">Retour à la page d'accueil sans inscription</a></p>
	<?php else: ?>
		<p class="warning">Inscription réussie !</p>
		<p><a href="<?php echo $root_path; ?>src/pages/Accueil/index.php">Retour à la page d'accueil</a></p>
	<?php endif; ?>
</div>

<?php include $root_path . 'utils/templates/footer.php'; ?>
