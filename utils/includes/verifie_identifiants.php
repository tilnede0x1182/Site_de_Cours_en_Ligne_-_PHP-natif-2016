<?php
/**
 * Vérification des identifiants de connexion.
 */

/**
 * Vérifie si les identifiants de connexion sont valides.
 *
 * @param string $id L'identifiant de l'utilisateur
 * @param string $credential Le mot de passe ou hash
 * @param bool $credential_est_hash Si true, compare les hash directement
 * @return bool True si les identifiants sont valides
 */
function verifie_id_connection($id, $credential, $credential_est_hash = false) {
	global $bdd;

	try {
		$requette_id = $bdd->prepare('SELECT mot_de_passe FROM id_mdp WHERE id = :id LIMIT 1');
		$requette_id->execute([':id' => $id]);
		$row = $requette_id->fetch(PDO::FETCH_ASSOC);

		if (!$row) {
			return false;
		}

		$hash = $row['mot_de_passe'];

		if ($credential_est_hash) {
			return hash_equals($hash, $credential);
		}

		if (password_verify($credential, $hash)) {
			return true;
		}

		// Compatibilité avec les anciens mots de passe MD5
		return hash_equals($hash, md5($credential));
	} catch (Exception $exception_bdd) {
		return false;
	}
}
?>
