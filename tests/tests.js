/**
 * Tests pour Site_de_Cours_en_Ligne_2016
 * Validation des fonctions d'authentification et cours
 * Execution: node tests.js
 */

const TESTS_RESULTS = { passed: 0, failed: 0 };

function assert(description, condition) {
    if (condition) {
        console.log(`[PASS] ${description}`);
        TESTS_RESULTS.passed++;
    } else {
        console.log(`[FAIL] ${description}`);
        TESTS_RESULTS.failed++;
    }
}

/**
 * Valide un mot de passe (min 6 caracteres, au moins 1 chiffre).
 * @param {string} motDePasse Mot de passe.
 * @returns {boolean} True si valide.
 */
function validerMotDePasse(motDePasse) {
    if (motDePasse.length < 6) return false;
    if (!/\d/.test(motDePasse)) return false;
    return true;
}

/**
 * Valide un email.
 * @param {string} email Email.
 * @returns {boolean} True si valide.
 */
function validerEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
 * Simule la session utilisateur.
 */
const session = {
    utilisateur: null,
    coursAchetes: []
};

/**
 * Connecte un utilisateur.
 * @param {string} identifiant Identifiant.
 * @param {string} motDePasse Mot de passe.
 * @returns {boolean} True si connexion reussie.
 */
function connecter(identifiant, motDePasse) {
    // Simulation: accepte si mot de passe valide
    if (!validerMotDePasse(motDePasse)) return false;
    session.utilisateur = identifiant;
    return true;
}

/**
 * Deconnecte l'utilisateur.
 */
function deconnecter() {
    session.utilisateur = null;
    session.coursAchetes = [];
}

/**
 * Achete un cours.
 * @param {number} numeroCours Numero du cours (1, 2 ou 3).
 * @returns {boolean} True si achat reussi.
 */
function acheterCours(numeroCours) {
    if (!session.utilisateur) return false;
    if (numeroCours < 1 || numeroCours > 3) return false;
    if (session.coursAchetes.includes(numeroCours)) return false;
    session.coursAchetes.push(numeroCours);
    return true;
}

/**
 * Verifie l'acces a un cours.
 * @param {number} numeroCours Numero du cours.
 * @returns {boolean} True si acces autorise.
 */
function accesAutorise(numeroCours) {
    if (!session.utilisateur) return false;
    return session.coursAchetes.includes(numeroCours);
}

// ==================== TESTS ====================

console.log("=== Tests Site-Cours-en-Ligne ===\n");

// Tests validation mot de passe
assert("Mot de passe valide", validerMotDePasse("test123"));
assert("Mot de passe trop court", !validerMotDePasse("abc1"));
assert("Mot de passe sans chiffre", !validerMotDePasse("abcdefgh"));

// Tests validation email
assert("Email valide", validerEmail("user@example.com"));
assert("Email invalide", !validerEmail("userexample.com"));

// Tests connexion
deconnecter(); // Reset
assert("Connexion reussie", connecter("user1", "pass123"));
assert("Connexion echouee mdp invalide", !connecter("user2", "abc"));

// Tests achat cours
deconnecter();
connecter("user1", "pass123");
assert("Achat cours 1 reussi", acheterCours(1));
assert("Achat cours deja achete echoue", !acheterCours(1));
assert("Achat cours invalide echoue", !acheterCours(5));

// Tests acces cours
assert("Acces cours achete autorise", accesAutorise(1));
assert("Acces cours non achete refuse", !accesAutorise(2));

// Tests deconnexion
deconnecter();
assert("Acces refuse apres deconnexion", !accesAutorise(1));

// ==================== RESUME ====================

console.log("\n=== Resume ===");
console.log(`Tests passes: ${TESTS_RESULTS.passed}`);
console.log(`Tests echoues: ${TESTS_RESULTS.failed}`);

if (TESTS_RESULTS.failed > 0) process.exit(1);
