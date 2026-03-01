# À faire

## 1. Compréhension rapide
- `PagePrincipale/Acceuil.php` centralise l’accueil, appelle l’entête (`Header/logo_du_site.php`) et redirige depuis `index.php`.
- Les formulaires `Inscription_identification/Inscription.php` et `Identification.php` utilisent `Fonctions_de_verification.php` pour contrôler ID, mot de passe, adresse et date de naissance avant d’inscrire l’utilisateur.
- `Base_de_donnees/Connection_bdd.php` (PDO) et `creation_db.sql` définissent la base (membres, identifiants/mots de passe, cours achetés).
- Les cours (`Pages des cours/Cours1.php`, etc.) vérifient l’achat dans `cours_pris` puis incluent les contenus, menu et pied de page communs.
- `Paiement/Paiement.php` simule l’achat d’un module : formulaire, validation et insertion dans `cours_pris` avant de revenir à l’accueil.
- Les CSS (`CSS/Acceuil.css`, `Cours.css`, `Background.css`, `Paiement.css`) donnent une identité visuelle cohérente.

## 2. Bugs à corriger
- Dans `Inscription.php`, les champs mots de passe sont réattribués sous condition `if (!empty($_POST['id'])) $mdp1 = $_POST['mdp1'];` (et idem pour `$mdp2`). Si l’utilisateur oublie l’ID mais saisit les deux mots de passe, ces variables restent vides et les messages d’erreur deviennent incohérents. Tester `$_POST['mdp1']`/`$_POST['mdp2']` au lieu de `id`.
- `Fonctions_de_verification::verifie_asresse` refuse toute apostrophe ou virgule. Des adresses parfaitement valides échouent. Étendre la regex pour inclure `'` et `,` évitera des rejets arbitraires.
- Après `header('Location: ...')` (ex. dans `Paiement.php`), le script continue à exécuter du HTML. Ajouter `exit;` immédiatement après chaque redirection évitera l’erreur « headers already sent ».

## 3. DRY en priorité
- Les contrôles d’accès (`session_start`, vérification de `$_SESSION['id']`, redirection) apparaissent dans chaque page de cours. Un include `require_login.php` simplifierait le maintien et éviterait les oublis.
- Chaque page inclut manuellement la connexion BDD et répète le même squelette HTML. Mettre en place un layout (header commun + footer) réduira la duplication.

## 4. Sécurité
- Les requêtes SQL concatènent les valeurs utilisateur (`"'.$id.'"`) alors même que PDO est disponible. Utiliser des requêtes préparées est essentiel pour éliminer les injections SQL.
- Les mots de passe sont stockés en MD5 sans sel. Migrer vers `password_hash()`/`password_verify()` avec un algorithme moderne (bcrypt/argon2) est impératif.
- Aucun token anti-CSRF n’est présent sur les formulaires sensibles (inscription, achat). Ajouter un jeton stocké en session protège des soumissions croisées.
