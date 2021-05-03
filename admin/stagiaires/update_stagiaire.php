<?php
require('../utilisateurs/ma_session.php');
?>

<meta charset="utf-8" />
<?php


require('../connexion.php');

$id_stagiaire = $_POST['id'];
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
$date_inscription = $_POST['date_inscription'];
$num_inscription = $_POST['num_inscription'];

//$num_inscription=$_POST['num_inscription'];
//$date_inscription=$_POST['date_inscription'];


$nom_photo = $_FILES['photo']['name'];
$image_tmp = $_FILES['photo']['tmp_name'];
move_uploaded_file($image_tmp, '../images/' . $nom_photo);

if (!empty($nom_photo)) {
	// empty : vide
	// si le $nom_photo n'est pas vide alors la photo sera modifiée
	$requete = "UPDATE stagiaire SET 
					nom=?,prenom=?,niveau=?,
					campus=?,num_etudiant=?,entreprise_accueil=?,
					tuteur_interne=?,tuteur_externe=?,adr_mail_acad=?,linkedin=?,
					type_de_stage=?,date_inscription=?, num_inscription,photo=?
					where id=?";

	$valeur = array(
		$nom, $prenom, $niveau, $campus, $num_etudiant, $entreprise_accueil,
		$tuteur_interne, $tuteur_externe, $adr_mail_acad, $linkedin, $type_de_stage, $date_inscription, $num_inscription, $nom_photo
	);
} else {
	// si le $nom_photo est vide alors la photo ne sera pas modifiée
	$requete = "UPDATE stagiaire SET 
					nom=?,prenom=?,niveau=?,
					campus=?,num_etudiant=?,entreprise_accueil=?,
					tuteur_interne=?,tuteur_externe=?,adr_mail_acad=?,linkedin=?,
					type_de_stage=?,date_inscription=?, num_inscription
					where id=?";

	$valeur = array(
		$nom, $prenom, $niveau, $campus, $num_etudiant, $entreprise_accueil,
		$tuteur_interne, $tuteur_externe, $adr_mail_acad, $linkedin, $type_de_stage, $date_inscription, $num_inscription
	);
}

$resultat = $pdo->prepare($requete);
$resultat->execute($valeur);


$annee_scolaire = $_POST['annee_scolaire'];
$index_classe   = $_POST['index_classe'];
$index_filiere  = $_POST['index_filiere'];


$msg = "Stagiaire modifié avec succes";
$url = "stagiaires/page_les_stagiaires.php?annee_scolaire =$annee_scolaire&index_filiere=$index_filiere&index_classe=$index_classe";
header("location:../message.php?msg=$msg&color=v&url=$url");
?>