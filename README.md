# Projet « Cours en ligne »

## Description
Ce projet permet la gestion d’un site de cours en ligne avec inscription, identification et achat de modules.
Les utilisateurs s’inscrivent, se connectent et accèdent à des cours protégés au moyen d’un système de sessions PHP/PDO.
Chaque cours (1, 2 et 3) est servi dynamiquement selon les droits de l’utilisateur et la liste des cours achetés.
Un formulaire de paiement simule l’achat de cours, qui sont ensuite débloqués pour l’utilisateur.

## Technologies utilisées
- **PHP 7.x** (code orienté PDO, sessions, exceptions)
- **MySQL 5.x** (base de données, tables `membres`, `id_mdp`, `cours_pris`)
- **HTML5** (structure des pages)
- **CSS3** (styles : `Acceuil.css`, `Background.css`, `Cours.css`, `Paiement.css`)
- **Git** (gestion de version, dépôt structuré)

## Fonctionnalités
- **Inscription**
  - Formulaire d’inscription avec validation en PHP des champs (identifiant, mot de passe, e-mail, date de naissance, pays, adresse)
  - Contrôles sur format d’identifiant, robustesse du mot de passe, validité de la date et de l’adresse e-mail
  - Stockage sécurisé des mots de passe en base (hachage MD5)

- **Identification et sessions**
  - Page de connexion avec vérification des identifiants via PDO
  - Gestion des sessions PHP pour conserver l’état authentifié
  - Déconnexion et réinitialisation de la session

- **Gestion des cours**
  - Affichage des cours disponibles (Cours1, Cours2, Cours3)
  - Vérification des droits d’accès : seuls les cours achetés sont accessibles
  - Stockage en base de la liste des cours achetés (`cours_pris`)

- **Achat de cours**
  - Formulaire de paiement factice pour sélectionner et valider l’achat d’un cours
  - Insertion du cours acheté en base et redirection vers l’accueil

- **Affichage dynamique**
  - Redirection de l’index vers la page d’accueil (`PagePrincipale/Acceuil.php`)
  - Chargement conditionnel du contenu des modules (`Pages des cours/Cours1.php`, etc.)
  - Affichage d’en-tête et de pied de page réutilisables (`Header/logo_du_site.php`, `Footer/footer_cours.php`)

- **Utilitaires**
  - Fonctions de récupération du nom et prénom d’un utilisateur (`Base_de_donnees/Fonction_recuperation_dinofs.php`)
  - Fonctions de vérification des champs et des droits (`Inscription_identification/Fonctions_de_verification.php`)

- **Structure et organisation**
  - Architecture en dossiers :
    - `Base_de_donnees/` pour la connexion et les fonctions BDD
    - `Inscription_identification/` pour tout ce qui concerne inscription et login
    - `PagePrincipale/` pour l’accueil et la déconnexion
    - `Pages des cours/` pour le contenu des modules et leur menu
    - `Paiement/` pour le formulaire de paiement
    - `Header/`, `Footer/`, `CSS/`, `Images/` pour assets et styles
  - Fichier SQL (`creation_db.sql`) pour générer les tables nécessaires
  - Gestion de versions Git avec `.git/`
