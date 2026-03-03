CREATE TABLE IF NOT EXISTS id_mdp (
	id_id_mdp int not null auto_increment, 
	id varchar(120) not null,
	mot_de_passe varchar(120) not null,
	PRIMARY KEY (id_id_mdp)
) ENGINE=InnoDB DEFAULT charset=UTF8;

CREATE TABLE IF NOT EXISTS membres (
	id_membres int not null auto_increment, 
	id varchar(120) not null,
	nom text,
	prenom text,
	date_de_naissance varchar(8) not null,
	mail text not null,
	pays text,
	admin tinyint(1) not null default 0,
	PRIMARY KEY (id_membres)
) ENGINE=InnoDB DEFAULT charset=UTF8;

CREATE TABLE IF NOT EXISTS cours_pris (
	id_cours_pris int not null auto_increment,
	id varchar(120) not null,
	cours text not null,
	PRIMARY KEY (id_cours_pris)
) ENGINE=InnoDB DEFAULT charset=UTF8;