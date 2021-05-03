drop database if exists ecoledb;
create database ecoledb;
use ecoledb;
ALTER DATABASE `ecoledb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE utilisateur(
	id_utilisateur int(4) AUTO_INCREMENT PRIMARY KEY,
	login VARCHAR(100) ,
	pwd VARCHAR(255) ,
	role VARCHAR(50) ,
	email VARCHAR(255) 
);
INSERT INTO `utilisateur` (`id_utilisateur`,`login`,`pwd`,`role`,`email`) VALUES 
 (12,'admin','123','Directeur','admin@gmail.com'),
 (13,'swc1','123','Secrétaire','sec1@gmail.com'),
 (14,'sec2','123','Secrétaire','user2@gmail.com'),
 (17,'sec3','123','Secrétaire','test10@gmail.com');

CREATE TABLE filiere (
	id INT  AUTO_INCREMENT PRIMARY KEY ,
	nom VARCHAR( 255 )  ,
	niveau_diplome VARCHAR( 2 )  ,
	duree_formation INT  ,
	stage1 VARCHAR( 255 )  ,
	stage2 VARCHAR( 255 )  ,
	niveau_admission VARCHAR( 50 )  ,
	frais_inscription DOUBLE  ,
	frais_mansuel DOUBLE  ,
	frais_examen DOUBLE  ,
	frais_diplome DOUBLE  ,
	date_creation DATE  ,
	num_autorisation VARCHAR( 255 )  ,
	date_qualification DATE  ,
	num_qualification VARCHAR( 255 )  ,
	date_accreditation DATE  ,
	num_accreditation VARCHAR( 255 ) 
);

create table stagiaire (
	id int not null auto_increment primary key,
	civilite varchar (1) ,
	nom varchar (50)  ,
	prenom varchar(50) ,
	date_naissance date ,
	lieu_naissance varchar (200) ,
	adresse varchar (255) ,
	ville varchar (50) ,
	cin varchar (50) ,
	tel varchar (50) ,
	niveau_scolaire varchar (50) ,
	dernier_diplome  varchar (50) ,
	dernier_etablissement varchar (50) ,
	num_inscription varchar (50) ,
	date_inscription date ,
	code_national varchar (50) ,
	photo varchar (50)
	-- photo : le nom "nom.jpg" ou "nom.png" de la photo
);
	
 create table matiere(
	id_matiere int not null auto_increment primary key,
	nom varchar (50) not null,
	nombre_heure_total int ,
	nombre_heure_tp int ,
	nombre_heure_th int ,
	coef int not null
);
	
create table programme(
	id_prog int not null auto_increment primary key,
	id_filiere int ,
	annee_scolaire varchar(50) ,
	id_matiere int ,
	classe varchar(50)  
);
	
create table attestation (
	id int not null auto_increment primary key,
	nom varchar (50) ,
	date_impression date ,
	num_attestation varchar(50),
	singature varchar(50) ,
	id_stagiaire int 
);

create table dossier_inscription(
	id int not null auto_increment primary key,
	attestation_scolarite int ,
	attestation_bac int ,
	cin int not null,
	extrait_acte_naissance int ,
	enveloppe int ,
	photo int ,
	reglement int ,
	id_filiere int
	);
	
create table scolarite(
	id int not null auto_increment primary key,
	annee_scolaire varchar(50) ,
	id_stagiaire int ,
	id_filiere int ,
	classe varchar(50) ,
	resultat varchar(50) , 
	date_resultat date 
	);
	-- resultat : inscrit, abondonne, admis, laureat, redoublant.
		
	alter table scolarite add constraint foreign key(id_stagiaire) 
	references stagiaire(id) ON DELETE CASCADE;
	-- ON DELETE CASCADE : si on supprime un stagiaire toutes ces données
	-- dans la table scolarité seront supprimées
-- 1 	
	alter table attestation add constraint foreign key (id_stagiaire) 
	references	stagiaire (id) ON DELETE CASCADE;
-- 2	
	alter table scolarite add constraint foreign key(id_filiere) 
	references filiere(id) ON DELETE CASCADE;
-- 3		
	alter table programme add constraint foreign key (id_filiere) 
	references filiere (id) ON DELETE CASCADE;
-- 4
	alter table programme add constraint foreign key (id_matiere) 
	references matiere (id_matiere) ON DELETE CASCADE;
-- 5		
	alter table dossier_inscription add constraint foreign key (id_filiere) 
	references filiere (id) ON DELETE CASCADE;
	


	
	
