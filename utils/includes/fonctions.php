<?php
/**
 *	Fonctions de validation pour les formulaires.
 *	Vérification des champs d'inscription et de connexion.
 */

// ==============================================================================
// Validation identifiant et mot de passe
// ==============================================================================

/**
 *	Vérifie le format d'un identifiant.
 *	Caractères autorisés : lettres, chiffres, _ et -
 *
 *	@param string $identifiant Identifiant à vérifier
 *	@return bool True si le format est valide
 */
function verifie_id($identifiant) {
	return preg_match("/^[a-zA-Z_\-\d]+$/", $identifiant);
}

/**
 *	Vérifie le format d'un mot de passe.
 *	Minimum 8 caractères, au moins une majuscule et un chiffre.
 *
 *	@param string $mot_de_passe Mot de passe à vérifier
 *	@return bool True si le format est valide
 */
function verifie_mdp($mot_de_passe) {
	if (!preg_match("/^[a-zA-Z_\d]{8,}$/", $mot_de_passe)) {
		return false;
	}
	if (!preg_match("/[A-Z]/", $mot_de_passe)) {
		return false;
	}
	if (!preg_match("/\d/", $mot_de_passe)) {
		return false;
	}
	return true;
}

// ==============================================================================
// Validation champs d'inscription
// ==============================================================================

/**
 *	Vérifie le format d'une adresse postale.
 *	Caractères autorisés : lettres (avec accents), chiffres, espaces, apostrophes, tirets.
 *
 *	@param string $adresse Adresse à vérifier
 *	@return bool True si le format est valide
 */
function verifie_adresse($adresse) {
	return preg_match("/^[éèàçôîùâòa-zA-Z\d ',\-]+$/", $adresse);
}

/**
 *	Vérifie le format des champs texte génériques (nom, prénom, pays).
 *	Caractères autorisés : lettres (avec accents), chiffres, espaces.
 *
 *	@param string $champ Valeur du champ à vérifier
 *	@return bool True si le format est valide
 */
function verifie_autres_champs($champ) {
	return preg_match("/^[éèàçôîùâòa-zA-Z\d ]+$/", $champ);
}

/**
 *	Vérifie si une date de naissance est valide.
 *
 *	@param int $jour Jour (1-31)
 *	@param int $mois Mois (1-12)
 *	@param int $annee Année (1850 - année en cours)
 *	@return bool True si la date est valide
 */
function verifie_date_de_naissance_valide($jour, $mois, $annee) {
	if (!is_numeric($jour) || !is_numeric($mois) || !is_numeric($annee)) {
		return false;
	}
	if ($jour < 1 || $mois < 1 || $jour > 31 || $mois > 12 || $annee < 1850 || $annee >= date('Y')) {
		return false;
	}
	return checkdate($mois, $jour, $annee);
}

/**
 *	Vérifie le format d'une adresse email.
 *
 *	@param string $adresse_mail Adresse email à vérifier
 *	@return bool True si le format est valide
 */
function check_mail_adress($adresse_mail) {
	return filter_var($adresse_mail, FILTER_VALIDATE_EMAIL);
}

?>
