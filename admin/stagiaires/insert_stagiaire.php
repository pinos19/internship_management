	<?php
	require('../utilisateurs/ma_session.php');
	?>

	<?php

	require('../connexion.php');

	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$niveau = $_POST['niveau'];
	$campus = $_POST['campus'];
	$num_etudiant = $_POST['num_etudiant'];
	$entreprise_accueil = $_POST['entreprise_accueil'];
	$tuteur_interne = $_POST['tuteur_interne'];
	$tuteur_externe = $_POST['tuteur_externe'];
	$adr_mail_acad = $_POST['adr_mail_acad'];
	$linkedin = $_POST['linkedin'];
	$type_de_stage = $_POST['type_de_stage'];
	$filiere = $_POST['filiere'];
	$date_inscription = $_POST['date_inscription'];
	$num_inscription = $_POST['num_inscription'];

	$nom_photo = $_FILES['photo']['name'];
	// Récuperer le nom de la photo "image1.jpg" ou "image2.png"

	$image_tmp = $_FILES['photo']['tmp_name'];
	// Recupérer le nom du fichier image temporaire dans serveru

	move_uploaded_file($image_tmp, '../images/' . $nom_photo);
	//Déplacer le fichier image temporaire vers le dossier 
	//images du serveur avec le nom réel

	$requete_insert_stag = "INSERT INTO stagiaire VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$valeurs_insert_stag = array(
		NULL, $nom, $prenom, $niveau, $campus, $num_etudiant, $entreprise_accueil,
		$tuteur_interne, $tuteur_externe, $adr_mail_acad, $linkedin, $type_de_stage, $date_inscription, $num_inscription, $nom_photo
	);

	$resultat_insert_stag = $pdo->prepare($requete_insert_stag);
	$resultat_insert_stag->execute($valeurs_insert_stag);

	// l'id de dernier stagiaire	
	$requete_dernier_stagiaire = "SELECT * FROM stagiaire ORDER BY id desc limit 1 ";
	$resultat_dernier_stagiaire = $pdo->query($requete_dernier_stagiaire);
	$dernier_stagiaire = $resultat_dernier_stagiaire->fetch();
	$id_stagiaire = $dernier_stagiaire['id'];
	$annee_scolaire = $_POST['annee_scolaire'];
	$id_filiere = $_POST['id_filiere'];
	$classe = $_POST['classe'];
	$resultat_stag = "inscrit";
	$date_resultat = $_POST['date_inscription'];

	$requete_scolarite = "INSERT INTO scolarite VALUES(?,?,?,?,?,?,?)";

	$valeur_scolarite = array(
		NULL,
		$annee_scolaire,
		$id_stagiaire,
		$id_filiere,
		$classe,
		$resultat_stag,
		$date_resultat
	);
	$resultat_scolarite = $pdo->prepare($requete_scolarite);
	$resultat_scolarite->execute($valeur_scolarite);


	$msg = "Stagiaire ajouté avec succès";
	$url = "stagiaires/page_les_stagiaires.php";
	header("location:../message.php?msg=$msg&color=v&url=$url");


	?>