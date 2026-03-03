<?php

function verifie_id_connection ($id, $credential, $credential_est_hash = false) {
	include "../Base_de_donnees/Connection_bdd.php";
	try {
		$requette_id = $bdd->prepare('SELECT mot_de_passe FROM id_mdp WHERE id = :id LIMIT 1');
		$requette_id->execute([':id'=>$id]);
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
		return hash_equals($hash, md5($credential));
	}
	catch (exception $e) {
		return false;
	}
}

?>
