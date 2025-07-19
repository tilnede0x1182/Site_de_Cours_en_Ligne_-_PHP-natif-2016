<?php

function verifie_id_connection ($id, $mdp) {
		include "../Base_de_donnees/Connection_bdd.php";

		try {
			$requette_id = $bdd->query('select id, '
			.'mot_de_passe from id_mdp where id="'.$id.'"');
		}
		catch (exception $e) {
			return false;
		}

		try {
			while (($x = $requette_id->fetch())) {
				if (!empty($x['id'])) {
					if ($id==$x['id']) {
						return $x['mot_de_passe']==$mdp;
					}
				}
			}
		}
		catch (exception $e) {
			return false;			
		}
		return false;
}

?>