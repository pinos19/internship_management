drop database if exists ecoledb;
create database ecoledb;
use ecoledb;
ALTER DATABASE `ecoledb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE utilisateur(
	id_utilisateur decimal(2) AUTO_INCREMENT PRIMARY KEY,
	login varchar(100) ,
	pwd varchar(100) ,
	role varchar(50) ,
	email varchar(100) 
);
INSERT INTO `utilisateur` (`id_utilisateur`,`login`,`pwd`,`role`,`email`) VALUES 
 (12,'admin','123','Directeur','admin@gmail.com'),
 (13,'swc1','123','Secrétaire','sec1@gmail.com'),
 (14,'sec2','123','Secrétaire','user2@gmail.com'),
 (17,'sec3','123','Secrétaire','test10@gmail.com');

CREATE TABLE etudiant (
	id_etudiant decimal(4)  AUTO_INCREMENT PRIMARY KEY ,
	nom varchar(50),
	prenom varchar(50),
	civilite varchar(50),
	date_naissance date,
	id_adresse decimal(5),
	email varchar(100),
	tel varchar(50),
	annee_scolaire decimal(1) -- 1 pour première année, 2 pour deuxième, 3 pour troisième et 4 pour diplômé/sortie de l'école
	id_campus decimal(1)
);

create table campus (
	id_campus decimal(1) not null auto_increment primary key,
	nom varchar(50),
	date_creation date
);
	
create table tuteur(
	id_tuteur decimal(4) not null auto_increment primary key,
	nom varchar(50),
	prenom varchar(50),
	id_adresse decimal(5),
	email varchar(100),
	id_entreprise decimal(5)
);
	
create table adresse (
	id_adresse decimal(5) not null auto_increment primary key,
	indicatif decimal(5),
	rue varchar(50),
	ville varchar(50),
	code_postal char(5)
);

create table entreprise(
	id_entreprise decimal(5) not null auto_increment primary key,
	nom varchar(50),
	id_adresse decimal(5)
	);
	
create table stage(
	id_stage decimal(5) not null auto_increment primary key,
	stage_niveau decimal(1) -- 1 => stage première année, 2=> deuxième année et 3=> troisième année
	id_etudiant decimal(4),
	id_tuteur_interne decimal(4),
	id_tuteur_externe decimal(4)
	 
	);
	-- resultat : inscrit, abondonne, admis, laureat, redoublant.
		
	alter table etudiant add constraint foreign key(id_adresse) 
	references adresse(id_adresse) ON DELETE CASCADE;
	-- ON DELETE CASCADE : si on supprime un stagiaire toutes ces données
	-- dans la table scolarité seront supprimées
-- 1 	
	alter table tuteur add constraint foreign key(id_adresse) 
	references	adresse(id_adresse) ON DELETE CASCADE;
-- 2	
	alter table tuteur add constraint foreign key(id_entreprise) 
	references entreprise(id_entreprise) ON DELETE CASCADE;
-- 3		
	alter table stage add constraint foreign key(id_etudiant) 
	references etudiant(id_etudiant) ON DELETE CASCADE;
-- 4
	alter table stage add constraint foreign key(id_tuteur_interne) 
	references tuteur(id_tuteur) ON DELETE CASCADE;
-- 5		
	alter table stage add constraint foreign key(id_tuteur_externe) 
	references tuteur(id_tuteur) ON DELETE CASCADE;
	


	
	
