<?php
require('../utilisateurs/ma_session.php');
require('../connexion.php');
require("../fonctions.php");

//$pdo = new PDO("mysql:host=localhost;dbname=ecoledb", "root", "");


if (isset($_GET['ids']))
    $ids = $_GET['ids'];
else
    $ids = 0;

if (isset($_GET['as']))
    $as = $_GET['as'];
else
    $as = annee_scolaire_actuelle();

$identite_stagiaire = $pdo->query("SELECT * FROM etudiant WHERE id_etudiant=$ids");
$stagiaire = $identite_stagiaire->fetch();
$nom_prenom = strtoupper($stagiaire['nom'] . "  " . $stagiaire['prenom']);

$civilite = strtoupper($stagiaire['civilite']);
$id_adresse = strtoupper($stagiaire['id_adresse']);
$email = $stagiaire['email'];
$tel = strtoupper($stagiaire['tel']);
$annee_scolaire = strtoupper($stagiaire['annee_scolaire']);
$id_campus = $stagiaire['id_campus'];
$date_naissance = dateEnToDateFr($stagiaire['date_naissance']);

// stage
if ($annee_scolaire == 'ING1') {
    $identite_stage = $pdo->query("SELECT * FROM stage WHERE id_etudiant = $ids and stage_niveau = 1");
} else if ($annee_scolaire == 'ING2') {
    $identite_stage = $pdo->query("SELECT * FROM stage WHERE id_etudiant = $ids and stage_niveau = 2");
} else if ($annee_scolaire == 'ING3') {
    $identite_stage = $pdo->query("SELECT * FROM stage WHERE id_etudiant = $ids and stage_niveau = 3");
}

$stage = $identite_stage->fetch();
$type_stage = $stage['libelle'];
$id_tuteur_interne = $stage['id_tuteur_interne'];
$id_tuteur_externe = $stage['id_tuteur_externe'];

// tuteur interne
$identite_tuteur_interne = $pdo->query("SELECT * FROM tuteur WHERE id_tuteur = $id_tuteur_interne");
$tuteur_interne = $identite_tuteur_interne->fetch();

//tuteur externe
$identite_tuteur_externe = $pdo->query("SELECT * FROM tuteur WHERE id_tuteur = $id_tuteur_externe");
$tuteur_externe = $identite_tuteur_externe->fetch();


$nom_tuteur_interne = $tuteur_interne['nom'] . " " . $tuteur_interne['prenom'];
$nom_tuteur_externe = $tuteur_externe['nom'] . " " . $tuteur_externe['prenom'];


$id_entreprise_tuteur_externe = $tuteur_externe['id_entreprise'];


//campus
$identite_campus = $pdo->query("SELECT * FROM campus WHERE id_campus = $id_campus");
$campus = $identite_campus->fetch();
$nom_campus = strtoupper($campus['nom']);
$filiere = $campus['filiere'];

// entreprise accueil
$identite_ent_accueil = $pdo->query("SELECT * FROM entreprise WHERE id_entreprise = $id_entreprise_tuteur_externe");
$ent_accueil = $identite_ent_accueil->fetch();

$nom_ent_accueil = strtoupper($ent_accueil['nom']);


$id_adresse_ent_accueil = $ent_accueil['id_adresse'];

//adresse ent accueil
$identite_adresse_ent_accueil = $pdo->query("SELECT * FROM adresse WHERE id_adresse = $id_adresse_ent_accueil");
$adresse_ent_accueil = $identite_adresse_ent_accueil->fetch();


$indicatif_adresse_ent_accueil = strtoupper($adresse_ent_accueil['indicatif']);
$rue_adresse_ent_accueil = strtoupper($adresse_ent_accueil['rue']);
$ville_adresse_ent_accueil = strtoupper($adresse_ent_accueil['ville']);
$code_postal_adresse_ent_accueil = strtoupper($adresse_ent_accueil['code_postal']);


require('fpdf.php');

//Création d'un nouveau doc pdf (Portrait, en mm , taille A5)
$pdf = new FPDF('P', 'mm', 'A5');

//Ajouter une nouvelle page
$pdf->AddPage();

// entete
$pdf->Image('en-tete.png', 10, 5, 130, 20);

// Saut de ligne
$pdf->Ln(18);


// Police Arial gras 16
$pdf->SetFont('Arial', 'B', 16);

// Titre
$pdf->Cell(0, 10, "Fiche d'informations", 'TB', 1, 'C');
$pdf->Cell(0, 10, 'N°:' . $ids, 0, 1, 'C');

// Saut de ligne
$pdf->Ln(5);

// Début en police Arial normale taille 10

$pdf->SetFont('Arial', '', 8.5);
$h = 7;
$retrait = "      ";

$pdf->Write($h, "Je soussigné, Directeur de l'école d'Ingénieurs du Littoral Côte d'Opale (EILCO) certifie que: \n");

$pdf->Write($h, $retrait . "L'étudiant : ");

//Ecriture en Gras-Italique-Souligné(U)
$pdf->SetFont('', 'BIU');
$pdf->Write($h, $nom_prenom . "\n");

//Ecriture normal
$pdf->SetFont('', '');


$pdf->Write($h, $retrait . "Filière :  " . $filiere . " \n");

$pdf->Write($h, $retrait . "Niveau :  " . $annee_scolaire . " \n");

$pdf->Write($h, $retrait . "Année de formation :  " . $as . "  \n");

$pdf->Write($h, "Poursuit ses étude en  " . $annee_scolaire . " à l'EILCO  et cela pour l'année scolaire en cours  " . $as . ".  \n");

$pdf->Write($h, $retrait . "Effectue son stage " . $type_stage . " à l'entreprise/établissement :");
$pdf->SetFont('', 'BIU');
$pdf->Write($h, $nom_ent_accueil);
$pdf->SetFont('', '');
$pdf->Write($h, ".\n");
$pdf->Write($h, $retrait . "Son encadrant pédagogique interne à l'EILCO est : " . $nom_tuteur_interne . ".\n");
$pdf->Write($h, $retrait . "Son tuteur à l'établissement d'accueil est : " . $nom_tuteur_externe . ".\n");


$pdf->Write($h, "La présente attestation est délivrée à l'intéressé Pour servir et valoir ce que de droit. \n\n");

$pdf->Cell(0, 5, 'Fait à Calais Le :' . date('d/m/Y'), 0, 1, 'C');

// Décalage de 20 mm à droite
$pdf->Cell(20);
$pdf->Cell(80, 8, "Le directeur de l'établissement", 1, 1, 'C');

// Décalage de 20 mm à droite
$pdf->Cell(20);
$pdf->Cell(80, 5, "Mr Mohamed BENJELLOUN", 'LR', 1, 'C');
$pdf->Cell(20);
$pdf->Cell(80, 5, ' ', 'LR', 1, 'C'); // LR Left-Right
$pdf->Cell(20);
$pdf->Cell(80, 5, ' ', 'LR', 1, 'C');
$pdf->Cell(20);
$pdf->Cell(80, 5, ' ', 'LR', 1, 'C');
$pdf->Cell(20);
$pdf->Cell(80, 5, ' ', 'LRB', 1, 'C'); // LRB : Left-Right-Bottom (Bas)

//Afficher le pdf
$pdf->Output('', '', true);
