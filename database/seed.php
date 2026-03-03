<?php
/**
	Script de seed pour la base de données cours_1_bis.
	Génère des utilisateurs, catégories et cours réalistes.

	Usage :
		php seed.php
*/

// ==============================================================================
// Données
// ==============================================================================

$PRENOMS = [
	"Jean", "Pierre", "Marie", "Sophie", "Lucas", "Emma", "Louis", "Léa", "Hugo", "Chloé",
	"Antoine", "Camille", "Maxime", "Julie", "Thomas", "Manon", "Nicolas", "Laura", "Alexandre", "Sarah",
	"Romain", "Océane", "Julien", "Mathilde", "Florian", "Pauline", "Quentin", "Marine", "Baptiste", "Anaïs",
	"Adrien", "Charlotte", "Clément", "Justine", "Guillaume", "Morgane", "Valentin", "Émilie", "Damien", "Audrey"
];

$NOMS = [
	"Martin", "Bernard", "Dubois", "Thomas", "Robert", "Richard", "Petit", "Durand", "Leroy", "Moreau",
	"Simon", "Laurent", "Lefebvre", "Michel", "Garcia", "David", "Bertrand", "Roux", "Vincent", "Fournier",
	"Morel", "Girard", "André", "Lefèvre", "Mercier", "Dupont", "Lambert", "Bonnet", "François", "Martinez",
	"Legrand", "Garnier", "Faure", "Rousseau", "Blanc", "Guérin", "Muller", "Henry", "Roussel", "Nicolas"
];

$CATEGORIES = [
	"Développement Web",
	"Développement Mobile",
	"Data Science",
	"Intelligence Artificielle",
	"Cybersécurité",
	"Cloud Computing",
	"DevOps",
	"Design UX/UI",
	"Gestion de Projet",
	"Marketing Digital",
	"Bureautique",
	"Langues"
];

$COURS_PAR_CATEGORIE = [
	"Développement Web" => [
		"HTML5 et CSS3 - Les fondamentaux", "JavaScript moderne ES6+", "React.js pour débutants",
		"Vue.js 3 - Guide complet", "Angular - Formation complète", "Node.js et Express",
		"PHP 8 - Programmation orientée objet", "Laravel - Framework PHP", "Symfony 6 - De zéro à expert",
		"WordPress - Création de thèmes", "API REST avec Node.js", "GraphQL - Introduction",
		"TypeScript - Le guide ultime", "Sass et Less - Préprocesseurs CSS", "Bootstrap 5 - Responsive design",
		"Tailwind CSS - Utility-first", "Next.js - React en production", "Nuxt.js - Vue.js universel",
		"Django - Python pour le web", "Flask - Microframework Python", "Ruby on Rails - MVC",
		"ASP.NET Core - C# pour le web", "Spring Boot - Java moderne", "Go pour le web",
		"Svelte - Le nouveau framework", "Astro - Sites statiques", "Remix - Full stack React",
		"WebSockets - Temps réel", "PWA - Applications progressives", "Web Components natifs",
		"Accessibilité web WCAG", "Performance web - Core Web Vitals", "SEO technique avancé"
	],
	"Développement Mobile" => [
		"Swift - iOS pour débutants", "SwiftUI - Interfaces modernes", "Kotlin - Android natif",
		"Jetpack Compose - UI Android", "React Native - Cross-platform", "Flutter - Dart et widgets",
		"Xamarin - C# mobile", "Ionic - Hybrid apps", "Capacitor - Web to native",
		"Firebase - Backend mobile", "Push notifications iOS/Android", "App Store optimization",
		"Tests automatisés mobile", "CI/CD pour applications mobiles", "Architecture MVVM mobile",
		"Stockage local - SQLite et Realm", "Géolocalisation et cartes", "Bluetooth et IoT",
		"Animations avancées iOS", "Material Design Android", "Authentification biométrique",
		"In-app purchases", "Analytics mobile", "Crash reporting et monitoring",
		"Accessibilité mobile", "Internationalisation apps", "Deep linking et Universal links",
		"ARKit - Réalité augmentée iOS", "ARCore - Réalité augmentée Android", "Widgets iOS et Android",
		"WatchOS - Apple Watch", "Wear OS - Montres Android", "tvOS - Apple TV"
	],
	"Data Science" => [
		"Python pour la data science", "Pandas - Manipulation de données", "NumPy - Calcul scientifique",
		"Matplotlib et Seaborn - Visualisation", "Jupyter Notebooks - Bonnes pratiques", "SQL pour analystes",
		"Statistiques descriptives", "Probabilités et distributions", "Tests d'hypothèses",
		"Régression linéaire et logistique", "Arbres de décision et forêts", "Clustering K-means",
		"Réduction de dimensionnalité PCA", "Séries temporelles - Prévision", "A/B Testing",
		"Web scraping avec Python", "APIs et collecte de données", "Nettoyage de données",
		"Feature engineering", "Validation croisée", "Métriques de performance",
		"Tableau - Visualisation BI", "Power BI - Microsoft analytics", "Looker et Google Data Studio",
		"ETL et pipelines de données", "Data warehousing", "Big Data avec Spark",
		"Hadoop écosystème", "Kafka - Streaming de données", "Airflow - Orchestration",
		"dbt - Transformation de données", "DataOps et MLOps", "Gouvernance des données"
	],
	"Intelligence Artificielle" => [
		"Machine Learning - Introduction", "Scikit-learn - ML en Python", "TensorFlow - Deep Learning",
		"PyTorch - Réseaux de neurones", "Keras - API haut niveau", "Réseaux de neurones convolutifs CNN",
		"Réseaux récurrents RNN et LSTM", "Transformers et Attention", "NLP - Traitement du langage",
		"Computer Vision - Vision par ordinateur", "Détection d'objets YOLO", "Segmentation d'images",
		"GANs - Réseaux génératifs", "Reinforcement Learning", "Q-Learning et Deep Q-Networks",
		"Transfer Learning", "Fine-tuning de modèles", "Hugging Face Transformers",
		"GPT et modèles de langage", "BERT et embeddings", "Diffusion models - Stable Diffusion",
		"MLflow - Tracking d'expériences", "Déploiement de modèles ML", "Optimisation d'hyperparamètres",
		"Interprétabilité des modèles", "Biais et équité en IA", "IA responsable et éthique",
		"Edge AI - IA embarquée", "AutoML - ML automatisé", "Federated Learning",
		"Neural Architecture Search", "Quantization et pruning", "IA générative avancée"
	],
	"Cybersécurité" => [
		"Introduction à la cybersécurité", "Réseaux et protocoles sécurisés", "Cryptographie fondamentale",
		"Linux pour la sécurité", "Kali Linux - Outils de pentest", "Metasploit Framework",
		"Analyse de vulnérabilités", "Tests d'intrusion web", "OWASP Top 10", "SQL Injection avancée",
		"XSS et CSRF - Exploitation", "Sécurité des APIs", "Authentification et autorisation",
		"OAuth 2.0 et OpenID Connect", "PKI et certificats", "Forensics numérique",
		"Analyse de malwares", "Reverse engineering", "Sécurité Windows",
		"Active Directory - Attaques et défense", "Sécurité cloud AWS", "Sécurité Azure",
		"Container security - Docker/K8s", "SIEM et log management", "Threat hunting",
		"Incident response", "SOC - Security Operations", "ISO 27001 et conformité",
		"RGPD et protection des données", "Bug bounty - Méthodologie", "Red Team operations",
		"Blue Team défense", "Purple Team collaboration", "Zero Trust Architecture"
	],
	"Cloud Computing" => [
		"AWS - Solutions Architect", "AWS - Developer Associate", "AWS - SysOps Administrator",
		"Azure - Fundamentals AZ-900", "Azure - Administrator AZ-104", "Azure - Developer AZ-204",
		"Google Cloud - Associate Engineer", "Google Cloud - Professional Architect", "Multi-cloud strategies",
		"Infrastructure as Code - Terraform", "CloudFormation - AWS IaC", "Pulumi - IaC moderne",
		"Serverless - AWS Lambda", "Azure Functions", "Google Cloud Functions",
		"Kubernetes - Administration", "Kubernetes - Developer CKAD", "Kubernetes - Security CKS",
		"Docker - Conteneurisation", "Docker Compose - Multi-container", "Container registries",
		"Service mesh - Istio", "API Gateway patterns", "Load balancing et CDN",
		"Stockage cloud - S3, Blob, GCS", "Bases de données cloud", "Caching - Redis et Memcached",
		"Message queues - SQS, RabbitMQ", "Event-driven architecture", "Microservices patterns",
		"Cloud networking - VPC", "Cloud security best practices", "Cost optimization cloud"
	],
	"DevOps" => [
		"DevOps - Culture et pratiques", "Git - Gestion de versions", "GitHub - Collaboration",
		"GitLab - CI/CD intégré", "Jenkins - Pipelines CI/CD", "GitHub Actions",
		"CircleCI - Continuous Integration", "ArgoCD - GitOps", "Flux - Kubernetes GitOps",
		"Ansible - Configuration management", "Chef et Puppet", "SaltStack",
		"Monitoring - Prometheus", "Grafana - Dashboards", "ELK Stack - Logging",
		"Datadog - Observabilité", "New Relic - APM", "PagerDuty - Incident management",
		"Chaos Engineering", "SRE - Site Reliability", "Toil reduction",
		"SLIs, SLOs et SLAs", "Error budgets", "Post-mortems blameless",
		"Feature flags - LaunchDarkly", "Canary deployments", "Blue-green deployments",
		"Infrastructure testing", "Security in DevOps - DevSecOps", "Compliance as Code",
		"FinOps - Cloud financials", "Platform engineering", "Internal Developer Platforms"
	],
	"Design UX/UI" => [
		"UX Design - Fondamentaux", "UI Design - Principes visuels", "Design Thinking",
		"User Research - Méthodes", "Personas et user journeys", "Wireframing",
		"Prototypage interactif", "Figma - Design collaboratif", "Sketch - UI Design",
		"Adobe XD - Prototypage", "InVision - Collaboration", "Framer - Prototypes avancés",
		"Design systems", "Atomic Design methodology", "Component libraries",
		"Typography pour le web", "Théorie des couleurs", "Iconographie et illustration",
		"Micro-interactions", "Motion design UI", "Lottie animations",
		"Responsive design patterns", "Mobile-first design", "Design pour accessibilité",
		"Usability testing", "A/B testing UX", "Analytics UX - Hotjar",
		"Information architecture", "Card sorting et tree testing", "Design critique",
		"Portfolio UX/UI", "Handoff design-développement", "Design ops"
	],
	"Gestion de Projet" => [
		"Gestion de projet - Fondamentaux", "Méthodologies traditionnelles", "Cycle en V",
		"Agile - Manifeste et principes", "Scrum - Framework complet", "Kanban - Flux continu",
		"Scrumban - Hybride", "SAFe - Scaled Agile", "LeSS - Large Scale Scrum",
		"Product Owner - Rôle et responsabilités", "Scrum Master - Facilitation", "User stories et épics",
		"Estimation agile - Planning poker", "Velocity et métriques agiles", "Rétrospectives efficaces",
		"Jira - Gestion de projets", "Trello - Tableaux Kanban", "Asana - Collaboration",
		"Monday.com - Work OS", "Notion - Documentation projet", "Confluence - Wiki d'équipe",
		"MS Project - Planification", "Gantt et diagrammes PERT", "Gestion des risques",
		"Gestion du changement", "Communication projet", "Stakeholder management",
		"Budget et coûts projet", "Qualité projet", "Clôture et lessons learned",
		"PMP - Certification PMI", "PRINCE2 - Méthodologie", "Lean management"
	],
	"Marketing Digital" => [
		"Marketing digital - Vue d'ensemble", "Stratégie de contenu", "Copywriting persuasif",
		"SEO - Référencement naturel", "SEO technique avancé", "SEO local",
		"Google Ads - Search", "Google Ads - Display", "Google Ads - Shopping",
		"Facebook Ads - Meta Business", "Instagram Marketing", "LinkedIn Ads B2B",
		"TikTok Marketing", "YouTube Marketing", "Publicité programmatique",
		"Email marketing - Stratégie", "Marketing automation", "HubSpot - Inbound marketing",
		"Mailchimp - Campagnes email", "Salesforce Marketing Cloud", "ActiveCampaign",
		"Google Analytics 4", "Google Tag Manager", "Attribution marketing",
		"CRO - Optimisation conversion", "Landing pages efficaces", "Funnel marketing",
		"Growth hacking", "Product-led growth", "Community management",
		"Influence marketing", "Personal branding", "Social selling"
	],
	"Bureautique" => [
		"Excel - Fondamentaux", "Excel - Formules avancées", "Excel - Tableaux croisés dynamiques",
		"Excel - VBA et macros", "Excel - Power Query", "Excel - Power Pivot",
		"Word - Mise en page professionnelle", "Word - Documents longs", "Word - Publipostage",
		"PowerPoint - Présentations impactantes", "PowerPoint - Design avancé", "PowerPoint - Animations",
		"Outlook - Productivité email", "Outlook - Calendrier et tâches", "Microsoft 365 - Collaboration",
		"Teams - Communication d'équipe", "SharePoint - Intranet", "OneDrive - Stockage cloud",
		"Google Workspace - Suite complète", "Google Sheets - Tableur cloud", "Google Docs - Collaboration",
		"Google Slides - Présentations", "Google Forms - Formulaires", "Notion - Organisation personnelle",
		"Airtable - Base de données no-code", "Slack - Communication", "Zoom - Visioconférence",
		"Miro - Collaboration visuelle", "Productivité personnelle", "GTD - Getting Things Done",
		"Automatisation avec Zapier", "Make (Integromat) - Workflows", "Microsoft Power Automate"
	],
	"Langues" => [
		"Anglais - Débutant A1", "Anglais - Élémentaire A2", "Anglais - Intermédiaire B1",
		"Anglais - Avancé B2", "Anglais - Courant C1", "Anglais des affaires",
		"Anglais technique IT", "TOEIC - Préparation", "TOEFL - Préparation",
		"Espagnol - Débutant A1", "Espagnol - Élémentaire A2", "Espagnol - Intermédiaire B1",
		"Espagnol - Avancé B2", "Espagnol des affaires", "DELE - Préparation",
		"Allemand - Débutant A1", "Allemand - Élémentaire A2", "Allemand - Intermédiaire B1",
		"Allemand - Avancé B2", "Allemand des affaires", "Goethe-Zertifikat - Préparation",
		"Italien - Débutant A1", "Italien - Élémentaire A2", "Italien - Intermédiaire B1",
		"Portugais - Débutant A1", "Portugais - Élémentaire A2", "Chinois mandarin - Introduction",
		"Japonais - Hiragana et Katakana", "Japonais - Débutant", "Coréen - Introduction",
		"Arabe - Introduction", "Russe - Alphabet et bases", "Français Langue Étrangère FLE"
	]
];

$PAYS = ["France", "Belgique", "Suisse", "Canada", "Luxembourg", "Monaco"];

// ==============================================================================
// Fonctions utilitaires
// ==============================================================================

/**
	Retourne un élément aléatoire d'un tableau.

	@param array $tableau Le tableau source
	@return mixed L'élément choisi
*/
function choisirAleatoire($tableau) {
	return $tableau[array_rand($tableau)];
}

/**
	Génère une date de naissance réaliste (18-65 ans) au format YYYYMMDD.

	@return string Date au format YYYYMMDD
*/
function dateNaissanceAleatoire() {
	$annee = rand(date('Y') - 65, date('Y') - 18);
	$mois = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
	$jour = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);
	return $annee . $mois . $jour;
}

/**
	Supprime les accents d'une chaîne.

	@param string $chaine Chaîne avec accents
	@return string Chaîne sans accents
*/
function supprimerAccents($chaine) {
	$recherche = ['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'ù', 'û', 'ü', 'ô', 'ö', 'î', 'ï', 'ç', 'É', 'È', 'Ê', 'Ë', 'À', 'Â', 'Ä', 'Ù', 'Û', 'Ü', 'Ô', 'Ö', 'Î', 'Ï', 'Ç'];
	$remplacement = ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'u', 'u', 'u', 'o', 'o', 'i', 'i', 'c', 'E', 'E', 'E', 'E', 'A', 'A', 'A', 'U', 'U', 'U', 'O', 'O', 'I', 'I', 'C'];
	return str_replace($recherche, $remplacement, $chaine);
}

/**
	Génère un mot de passe hashé.

	@param string $base Base du mot de passe
	@return string Hash bcrypt
*/
function hashMotDePasse($base) {
	return password_hash($base, PASSWORD_DEFAULT);
}

// ==============================================================================
// Fonctions principales
// ==============================================================================

/**
	Connexion à la base de données.

	@return PDO Connexion PDO
*/
function connecterBDD() {
	try {
		$connexion = new PDO(
			'mysql:host=localhost;dbname=cours_1_bis;charset=utf8',
			'tilnede0x1182',
			'tilnede0x1182',
			[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		);
		echo "Connexion à la base de données réussie.\n";
		return $connexion;
	} catch (PDOException $exception) {
		die("Erreur de connexion : " . $exception->getMessage());
	}
}

/**
	Vide les tables existantes.

	@param PDO $connexion Connexion PDO
*/
function viderTables($connexion) {
	$connexion->exec("DELETE FROM cours_pris");
	$connexion->exec("DELETE FROM membres");
	$connexion->exec("DELETE FROM id_mdp");
	$connexion->exec("ALTER TABLE cours_pris AUTO_INCREMENT = 1");
	$connexion->exec("ALTER TABLE membres AUTO_INCREMENT = 1");
	$connexion->exec("ALTER TABLE id_mdp AUTO_INCREMENT = 1");
	echo "Tables vidées.\n";
}

// ------------------------------------------------------------------------------
// Création des utilisateurs
// ------------------------------------------------------------------------------

/**
	Crée les utilisateurs admins et non-admins.

	@param PDO $connexion Connexion PDO
	@return array Liste des identifiants créés
*/
function creerUtilisateurs($connexion) {
	global $PRENOMS, $NOMS, $PAYS;
	$identifiants = [];
	$usersFile = __DIR__ . '/users.txt';
	file_put_contents($usersFile, "=== ADMINS ===\n");

	echo "Création des administrateurs...\n";
	for ($idx = 1; $idx <= 3; $idx++) {
		$identifiant = "admin0" . $idx;
		$motdepasseClair = 'Admin' . $idx . '23';
		$motdepasse = hashMotDePasse($motdepasseClair);
		$prenom = choisirAleatoire($PRENOMS);
		$nom = choisirAleatoire($NOMS);
		$datenaissance = dateNaissanceAleatoire();
		$pays = choisirAleatoire($PAYS);

		$requeteIdMdp = $connexion->prepare("INSERT INTO id_mdp (id, mot_de_passe) VALUES (?, ?)");
		$requeteIdMdp->execute([$identifiant, $motdepasse]);

		$requeteMembre = $connexion->prepare("INSERT INTO membres (id, nom, prenom, date_de_naissance, mail, pays, admin) VALUES (?, ?, ?, ?, ?, ?, 1)");
		$requeteMembre->execute([$identifiant, $nom, $prenom, $datenaissance, $identifiant, $pays]);

		$identifiants[] = $identifiant;
		file_put_contents($usersFile, "$identifiant $motdepasseClair\n", FILE_APPEND);
	}

	file_put_contents($usersFile, "\n=== USERS ===\n", FILE_APPEND);
	echo "Création des utilisateurs...\n";
	for ($idx = 1; $idx <= 20; $idx++) {
		$prenom = choisirAleatoire($PRENOMS);
		$nom = choisirAleatoire($NOMS);
		$identifiant = "user_" . strtolower(supprimerAccents($prenom)) . "_" . strtolower(supprimerAccents($nom)) . $idx;
		$motdepasseClair = 'Password' . $idx;
		$motdepasse = hashMotDePasse($motdepasseClair);
		$datenaissance = dateNaissanceAleatoire();
		$pays = choisirAleatoire($PAYS);

		$requeteIdMdp = $connexion->prepare("INSERT INTO id_mdp (id, mot_de_passe) VALUES (?, ?)");
		$requeteIdMdp->execute([$identifiant, $motdepasse]);

		$requeteMembre = $connexion->prepare("INSERT INTO membres (id, nom, prenom, date_de_naissance, mail, pays, admin) VALUES (?, ?, ?, ?, ?, ?, 0)");
		$requeteMembre->execute([$identifiant, $nom, $prenom, $datenaissance, $identifiant, $pays]);

		$identifiants[] = $identifiant;
		file_put_contents($usersFile, "$identifiant $motdepasseClair\n", FILE_APPEND);
	}

	echo "23 utilisateurs créés.\n";
	echo "Fichier users.txt créé.\n";
	return $identifiants;
}

// ------------------------------------------------------------------------------
// Attribution des cours
// ------------------------------------------------------------------------------

/**
	Attribue des cours aléatoires à chaque utilisateur.

	@param PDO $connexion Connexion PDO
	@param array $identifiants Liste des identifiants
*/
function attribuerCours($connexion, $identifiants) {
	global $COURS_PAR_CATEGORIE;
	$totalCours = 0;

	$tousLesCours = [];
	foreach ($COURS_PAR_CATEGORIE as $categorie => $cours) {
		foreach ($cours as $nomCours) {
			$tousLesCours[] = $categorie . " - " . $nomCours;
		}
	}

	echo "Attribution des cours aux utilisateurs...\n";
	foreach ($identifiants as $identifiant) {
		$nbCours = rand(5, 15);
		$coursChoisis = array_rand(array_flip($tousLesCours), $nbCours);
		if (!is_array($coursChoisis)) {
			$coursChoisis = [$coursChoisis];
		}

		foreach ($coursChoisis as $cours) {
			$requete = $connexion->prepare("INSERT INTO cours_pris (id, cours) VALUES (?, ?)");
			$requete->execute([$identifiant, $cours]);
			$totalCours++;
		}
	}

	echo "$totalCours inscriptions aux cours créées.\n";
}

// ==============================================================================
// Main
// ==============================================================================

/**
	Point d'entrée du script.
*/
function main() {
	global $COURS_PAR_CATEGORIE;

	echo "=== Seed Cours en Ligne ===\n\n";

	$connexion = connecterBDD();
	viderTables($connexion);
	$identifiants = creerUtilisateurs($connexion);
	attribuerCours($connexion, $identifiants);

	$totalCoursDisponibles = 0;
	foreach ($COURS_PAR_CATEGORIE as $cours) {
		$totalCoursDisponibles += count($cours);
	}
	echo "\nCatalogue : " . count($COURS_PAR_CATEGORIE) . " catégories, $totalCoursDisponibles cours disponibles.\n";

	echo "\n=== Seed terminé ===\n";
}

// ==============================================================================
// Lancement du programme
// ==============================================================================

main();
?>
