

CREATE TABLE utilisateur(
	id_utilisateur smallint not null AUTO_INCREMENT PRIMARY KEY,
	login varchar(100) ,
	pwd varchar(100) ,
	role varchar(50) ,
	email varchar(100) 
);

CREATE TABLE etudiant (
	id_etudiant smallint not null AUTO_INCREMENT PRIMARY KEY ,
	nom varchar(50),
	prenom varchar(50),
	civilite varchar(50),
	date_naissance date,
	id_adresse smallint,
	email varchar(100),
	tel varchar(50),
	annee_scolaire varchar(50), --  valeurs possibles : Première Année,  Deuxième Année,  Troisième Année et  Diplômé/Plus en formation
	id_campus tinyint
);




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
	tel varchar(50),
	id_entreprise smallint
);
	
create table adresse (
	id_adresse smallint not null auto_increment primary key,
	indicatif decimal(5),
	rue varchar(50),
	ville varchar(50),
	code_postal char(5)
);

 


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
	
INSERT INTO `utilisateur` (`id_utilisateur`,`login`,`pwd`,`role`,`email`) VALUES 
 (12,'admin','123','Directeur','admin@gmail.com'),
 (13,'swc1','123','Secrétaire','sec1@gmail.com'),
 (14,'sec2','123','Secrétaire','user2@gmail.com'),
 (17,'sec3','123','Secrétaire','test10@gmail.com');

INSERT INTO `campus` (`id_campus`,`nom`,`date_creation`) VALUES 
 (1,'Calais','2000-05-12'),
 (2,'Saint-Omer','2000-05-12'),
 (3,'Dunkerque','2020-05-12');
	
INSERT INTO `adresse` (`id_adresse`,`indicatif`,`rue`,`ville`,`code_postal`) VALUES 
-- adresse étudiants
 (1,48,'rue des moulineaux','Paris','75415'),
 (2,54,'rue des asticotes','Paris','75415'),
 (3,758,'boulevard maastricht','Paris','75415'),
 (4,1,'avenue beau regard','Paris','75415'),
-- adresse entreprises
 (5,11,'avenue coluche','Paris','75415'),
 (6,145,'quai de la rapêe','Bordeaux','32100'),
 (7,21,'rue marcel doriot','Toulouse','00450'),
 (8,41,'rue lima','Bordeaux','32300'),
 (9,45,'avenue du lion','lyon','69400'),
 (10,20,'boulevard capucine','Paris','75415'),
 (11,200,'rue de l''école','Calais','62100'),

 -- adresse des tuteurs
(12,200,'rue de la rapêe','Calais','62100'),
(13,141,'boulevard poissonière','Paris','75415'),
(14,145,'place d''italie','Mérignac','32100'),
(15,21,'rue platier','Toulouse','00450'),
(16,41,'rue torunesol','Bordeaux','32300'),
(17,45,'avenue lieutenant','lyon','69400'),
(18,20,'rue richard','Paris','75415');


 INSERT INTO `entreprise` (`id_entreprise`,`nom`,`id_adresse`) VALUES 
 (1,'thales',5),
 (2,'nexter',6),
 (3,'matières',7),
 (4,'sekoia',8),
 (5,'suez',9),
 (6,'engie',10),
 (7,'EILCO',11);

INSERT INTO `tuteur` (`id_tuteur`,`nom`,`prenom`,`id_adresse`,`email`,`tel`,`id_entreprise`) VALUES 

 (1,'Lherbier','Régis',12,'regis.lherbier@outlook.com','1111111111',7),
 (2,'Dupont','Xavier',13,'xavierdupont@hotmail.fr','1111111111',1),
 (3,'Charles','Jean',14,'jeancharles@hotmail.fr','1111111111',2),
 (4,'Dubois','Paul',15,'pauldubois@hotmail.fr','1111111111',3),
 (5,'Lepelletier','Richard',16,'richardlepelletier@hotmail.fr','1111111111',4),
 (6,'Gump','Forest',17,'forestgump@hotmail.fr','1111111111',5),
 (7,'Douglas','Mike',18,'mikedouglas@hotmail.fr','1111111111',6);


 
 INSERT INTO `etudiant` (`id_etudiant`,`civilite`,`nom`,`prenom`,`date_naissance`,`id_adresse`,`email`,`tel`,`annee_scolaire`,`id_campus`) VALUES 
 (1,'monsieur','nguyen','martin','1997-04-25',1,'martinnguyen@outlook.com','1111111111','Deuxième Année',1),
 (2,'monsieur','dupont','jean','1996-04-25',2,'jeandupont@outlook.com','1111111111','Première Année',2),
 (3,'madame','flores','marie','1998-04-25',3,'floresmarie@outlook.com','1111111111','Troisième Année',3),
 (4,'monsieur','lofter','christian','1994-04-25',4,'christianlofter@outlook.com','1111111111','Diplômé/plus en formation',1);

 INSERT INTO `stage` (`id_stage`,`stage_niveau`,`id_etudiant`,`id_tuteur_interne`,`id_tuteur_externe`) VALUES 
 (1,1,1,1,2),-- martin en deuxième année a un stage de premier année avec le tuteur interne régis lherbier et le tuteur externe xavier dupont
 (2,1,3,1,3),
 (3,2,3,1,4),
 (4,1,4,1,5),
 (5,2,4,1,6),
 (6,3,4,1,7);

