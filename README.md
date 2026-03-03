# Projet « Cours en ligne »

## Description
Ce projet permet la gestion d'un site de cours en ligne avec inscription, identification et achat de modules.
Les utilisateurs s'inscrivent, se connectent et accèdent à des cours protégés au moyen d'un système de sessions PHP/PDO.
Chaque cours (1, 2 et 3) est servi dynamiquement selon les droits de l'utilisateur et la liste des cours achetés.
Un formulaire de paiement simule l'achat de cours, qui sont ensuite débloqués pour l'utilisateur.

## Fonctionnalités

- **Inscription et connexion** : Création d'un compte membre avec validation des informations et authentification sécurisée.
- **Gestion du profil** : Modification des informations personnelles (identifiant, mot de passe, e-mail).
- **Consultation de cours** : Accès aux cours achetés (Cours 1, 2 et 3) avec contenu protégé.
- **Achat de cours** : Formulaire de paiement factice pour débloquer l'accès aux modules.
- **Gestion des sessions** : Connexion persistante et déconnexion sécurisée.

## Technologies

- PHP 7.x
- MySQL 5.x
- HTML5 / CSS3
- Apache

## Installation

### WAMP (Windows)

1. Placer le projet dans `C:\wamp64\www\cours\`
2. Démarrer WAMP et accéder à phpMyAdmin
3. Exécuter le fichier `database/creation_db.sql`
4. Lancer le seed :
   ```
   php database/seed.php
   ```
5. Accéder au site : http://localhost/cours/

### XAMPP (Windows / macOS)

1. Placer le projet dans `C:\xampp\htdocs\cours\` (Windows) ou `/Applications/XAMPP/htdocs/cours/` (macOS)
2. Démarrer Apache et MySQL depuis le panneau XAMPP
3. Exécuter le fichier `database/creation_db.sql` via phpMyAdmin
4. Lancer le seed :
   ```
   php database/seed.php
   ```
5. Accéder au site : http://localhost/cours/

### LAMP (Linux)

1. Placer le projet dans `/var/www/html/cours/`
2. Créer la base de données :
   ```
   sudo mysql < database/creation_db.sql
   ```
3. Lancer le seed :
   ```
   php database/seed.php
   ```
4. Accéder au site : http://localhost/cours/

## Identifiants de test

Les identifiants générés par le seed sont disponibles dans `database/users.txt`.
