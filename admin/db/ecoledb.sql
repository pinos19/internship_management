﻿drop database if exists ecoledb;
create database ecoledb;
use ecoledb;
ALTER DATABASE `ecoledb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE utilisateur(
	id_utilisateur smallint not null AUTO_INCREMENT PRIMARY KEY,
	login varchar(100) ,
	pwd varchar(100) ,
	role varchar(50) ,
	email varchar(100) 
);
INSERT INTO `utilisateur` (`login`,`pwd`,`role`,`email`) VALUES 
 ('admin','123','Directeur','admin@gmail.com'),
 ('swc1','123','Secrétaire','sec1@gmail.com'),
 ('sec2','123','Secrétaire','user2@gmail.com'),
 ('sec3','123','Secrétaire','test10@gmail.com');

CREATE TABLE etudiant (
	id_etudiant smallint not null AUTO_INCREMENT PRIMARY KEY ,
	nom varchar(50),
	prenom varchar(50),
	civilite varchar(50),
	date_naissance date,
	id_adresse smallint,
	email varchar(100),
	tel varchar(50),
	annee_scolaire decimal(1), -- 1 pour première année, 2 pour deuxième, 3 pour troisième et 4 pour diplômé/sortie de l'école
	id_campus tinyint
);

INSERT INTO `etudiant` (`civilite`,`nom`,`prenom`,`date_naissance`,`id_adresse`,`email`,`tel`,`annee_scolaire`,`id_campus`) VALUES 
 ('monsieur','nguyen','martin','1997-04-25',1,'martinnguyen@outlook.com','1111111111',2,1),
 ('monsieur','dupont','jean','1996-04-25',2,'jeandupont@outlook.com','1111111111',1,2),
 ('madame','flores','marie','1998-04-25',3,'floresmarie@outlook.com','1111111111',3,3),
 ('monsieur','lofter','christian','1994-04-25',4,'christianlofter@outlook.com','1111111111',4,1);




create table campus (
	id_campus tinyint not null auto_increment primary key, -- 1 pour calais, 2 pour saint-omer et 3 pour dunkerque
	nom varchar(50),
	date_creation date
);
	
create table tuteur(
	id_tuteur smallint not null auto_increment primary key,
	nom varchar(50),
	prenom varchar(50),
	id_adresse smallint,
	email varchar(100),
	id_entreprise smallint
);
	
create table adresse (
	id_adresse smallint not null auto_increment primary key,
	indicatif decimal(5),
	rue varchar(50),
	ville varchar(50),
	code_postal char(5)
);
INSERT INTO `adresse` (`id_adresse`,`indicatif`,`rue`,`ville`,`code_postal`) VALUES 
 (1,48,'rue des moulineaux','Paris','75415'),
 (2,54,'rue des asticotes','Paris','75415'),
 (3,758,'boulevard maastricht','Paris','75415'),
 (4,1,'avenue beau regard','Paris','75415');
 


create table entreprise(
	id_entreprise smallint not null auto_increment primary key,
	nom varchar(50),
	id_adresse smallint
	);
	
create table stage(
	id_stage smallint not null auto_increment primary key,
	stage_niveau tinyint, -- 1 => stage première année, 2=> deuxième année et 3=> troisième année
	id_etudiant smallint,
	id_tuteur_interne smallint,
	id_tuteur_externe smallint
	 
	);
	
	
	
		
	alter table etudiant add constraint foreign key(id_campus) 
	references campus(id_campus) ON DELETE CASCADE;
	
	alter table etudiant add constraint foreign key(id_adresse) 
	references adresse(id_adresse) ON DELETE CASCADE;
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
	


	
	
