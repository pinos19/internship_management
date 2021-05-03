	<?php
	require('../utilisateurs/ma_session.php');
	include("../fonctions.php");
	?>

	<?php
	require('../connexion.php');

	$id_stagiaire = $_GET['id_stagiaire'];
	$annee_scolaire = $_GET['annee_scolaire'];
	$index_classe = $_GET['index_classe'];
	$index_filiere = $_GET['index_filiere'];

	$requete_filieres = "SELECT * FROM filiere";
	$result_requete_filieres = $pdo->query($requete_filieres);
	$toutes_les_filieres = $result_requete_filieres->fetchAll();


	$identite_stagiaire = $pdo->query("SELECT * FROM stagiaire WHERE id=$id_stagiaire");
	$le_stagiaire = $identite_stagiaire->fetch();


	$scolarite_stagiaire = $pdo->query("SELECT id_stagiaire,annee_scolaire,classe,nom as Nom_Filiere
											FROM scolarite,filiere
											WHERE filiere.id=scolarite.id_filiere
											AND id_stagiaire=$id_stagiaire
											AND annee_scolaire='$annee_scolaire'");
	$scolarite = $scolarite_stagiaire->fetch();



	?>
	<!DOCTYPE html>
	<html>

	<head>
	    <meta charset="utf-8" />
	    <title> Modifier la stagiaire</title>
	    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
	    <link rel="stylesheet" type="text/css" href="../css/monStyle.css">
	    <link rel="stylesheet" href="../css/jquery-ui-1.10.4.custom.css">
	    <script src="../js/jquery-1.10.2.js"></script>
	    <script src="../js/jquery-ui-1.10.4.js"></script>
	    <script src="../js/bootstrap.min.js"></script>
	    <!-- <script src="js/jquery-ui-i18n.min.js"></script>-->
	    <script>
	    $(function() {
	        // définit les options par défaut du calendrier
	        $.datepicker.setDefaults({
	            showButtonPanel: true, // affiche des boutons sous le calendrier
	            showOtherMonths: true, // affiche les autres mois
	            selectOtherMonths: true // possibilités de sélectionner les jours des autres mois
	        });

	        //$(".calendar").datepicker(); // affiche le calendrier par défaut
	        //$(".calendar").datepicker($.datepicker.regional["fr"]); // affiche le calendrier en fr 										
	        $(".calendar").datepicker({
	            dateFormat: "yy-mm-dd",
	        });

	    });
	    </script>
	</head>

	<body>
	    <?php include('../menu.php'); ?>
	    <br><br><br>
	    <div class="container">
	        <!-- ******************** Début Identité du stagiaire ************** -->
	        <div class="panel panel-primary">
	            <div class="panel-heading" align="center"> Identité du stagiaire </div>
	            <div class="panel-body">
	                <form method="post" action="update_stagiaire.php" enctype="multipart/form-data">

	                    <input type="hidden" name="id" id="id" class="form-control"
	                        value="<?php echo $le_stagiaire['id']; ?>">

	                    <div class="row my-row">
	                        <label for="nom" class="control-label col-sm-2"> Nom </label>
	                        <div class="col-sm-4">
	                            <input type="text" name="nom" id="nom" class="form-control"
	                                value="<?php echo $le_stagiaire['nom']; ?>">
	                        </div>


	                        <label for="prenom" class="control-label col-sm-2"> Prénom </label>
	                        <div class="col-sm-4">
	                            <input type="text" name="prenom" id="prenom" class="form-control"
	                                value="<?php echo $le_stagiaire['prenom']; ?>">
	                        </div>

	                    </div>

	                    <div class="row my-row">
	                        <label for="niveau" class="control-label col-sm-2">Niveau </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="niveau" id="niveau" class="form-control"
	                                value="<?php echo $le_stagiaire['niveau']; ?>">
	                        </div>
	                        <label for="campus" class="control-label col-sm-2">Campus </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="campus" id="campus" class="form-control"
	                                value="<?php echo $le_stagiaire['campus']; ?>">
	                        </div>

	                    </div>

	                    <div class="row my-row">
	                        <label for="num_etudiant" class="control-label col-sm-2"> Numéro de l'étudiant </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="num_etudiant" id="num_etudiant" class="form-control"
	                                value="<?php echo $le_stagiaire['num_etudiant']; ?>">
	                        </div>


	                        <label for="entreprise_accueil" class="control-label col-sm-2"> Entreprise d'accueil </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="entreprise_accueil" id="entreprise_accueil"
	                                class="form-control" value="<?php echo $le_stagiaire['entreprise_accueil']; ?>">
	                        </div>


	                    </div>

	                    <div class="row my-row">
	                        <label for="tuteur_interne" class="control-label col-sm-2"> Tuteur de stage Interne </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="tuteur_interne" id="tuteur_interne" class="form-control"
	                                value="<?php echo $le_stagiaire['tuteur_interne']; ?>">
	                        </div>

	                        <label for="tuteur_externe" class="control-label col-sm-2"> Tuteur de stage Externe </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="tuteur_externe" id="tuteur_externe" class="form-control"
	                                value="<?php echo $le_stagiaire['tuteur_externe']; ?>">
	                        </div>

	                    </div>

	                    <div class="row my-row">
	                        <label for="adr_mail_acad" class="control-label col-sm-2"> Adresse mail académique (ULCO)
	                        </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="adr_mail_acad" id="adr_mail_acad" class="form-control"
	                                value="<?php echo $le_stagiaire['adr_mail_acad']; ?>">
	                        </div>

	                        <label for="linkedin" class="control-label col-sm-2"> Linkedin </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="linkedin" id="linkedin" class="form-control"
	                                value="<?php echo $le_stagiaire['linkedin']; ?>">
	                        </div>

	                    </div>



	                    <div class="row my-row">
	                        <label for="type_de_stage" class="control-label col-sm-2"> Type de stage </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="type_de_stage" id="type_de_stage" class="form-control"
	                                value="<?php echo $le_stagiaire['type_de_stage']; ?>">
	                        </div>

	                        <label for="num_inscription" class="control-label col-sm-2"> N° d'inscription </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="num_inscription" id="num_inscription"
	                                class="form-control" value="<?php echo $le_stagiaire['num_inscription']; ?>">
	                        </div>

	                    </div>

	                    <div class="row my-row">
	                        <label for="calendar" class="control-label col-sm-2"> DATE D'INSCRIPTION </label>
	                        <div class="col-sm-4">
	                            <input required type="text" name="date_inscription" id="calendar" class="form-control"
	                                value="<?php echo $le_stagiaire['date_inscription']; ?>">
	                        </div>


	                        <br><br>
	                    </div>

	                    <div class="row my-row">
	                        <label for="photo" class="control-label col-sm-2"> PHOTO </label>
	                        <div class="col-sm-4">
	                            <input type="file" name="photo" id="photo" class="form-control">
	                        </div>

	                        <label class="control-label col-sm-2"> Filière: </label>
	                        <div class="col-sm-4">
	                            <select class="form-control" name="id_filiere">

	                                <?php foreach ($toutes_les_filieres as $filiere) { ?>
	                                <option value="<?php echo $filiere['id'] ?>">
	                                    <?php echo $filiere['nom'] ?>
	                                </option>
	                                <?php } ?>

	                            </select>
	                        </div>
	                        <br><br>
	                    </div>

	                    <div class="row my-row">
	                        <label class="control-label col-sm-2"> Année Universitaire: </label>
	                        <div class="col-sm-4">
	                            <?php $annee_debut = 2014; ?>
	                            <select class="form-control" name="annee_scolaire">
	                                <?php
									for ($i = 1; $i <= nombre_annee_scolaire(); $i++) {
										$annee_sc = ($annee_debut + ($i - 1)) . "/" . ($annee_debut + $i);
									?>
	                                <option selected>
	                                    <?php echo $annee_sc; ?>
	                                </option>
	                                <?php } ?>
	                            </select>
	                        </div>

	                        <label class="control-label col-sm-2"> Niveau: </label>
	                        <div class="col-sm-4">
	                            <select class="form-control" name="classe">
	                                <option> ING1</option>
	                                <option selected> ING2</option>
	                            </select>
	                        </div>
	                        <br><br>
	                    </div>

	                    <input type="hidden" name="annee_scolaire" value="<?php echo $annee_scolaire; ?>">
	                    <input type="hidden" name="index_classe" value="<?php echo $index_classe; ?>">
	                    <input type="hidden" name="index_filiere" value="<?php echo $index_filiere; ?>">

	                    <button type='submit' class="btn btn-success btn-block"> Enregistrer
	                    </button>
	                </form>
	            </div>
	        </div>
	        <!-- ******************** Fin Scolarité du stagiaire ************** -->

	        <!-- ******************** Début Scolarité du stagiaire ************** -->
	        <div class="panel panel-danger">
	            <div class="panel-heading">Scolarité du stagiaire</div>
	            <div class="panel-body">
	                <h4>Année scolaire : <?php echo $annee_scolaire; ?> </h4>
	                <h4>Date d'inscription : <?php echo $le_stagiaire['date_inscription']; ?> </h4>
	                <h4>N° d'inscription : <?php echo $le_stagiaire['num_inscription']; ?> </h4>
	                <h4>Filière : <?php echo $scolarite['Nom_Filiere']; ?> </h4>
	                <h4>Classe : <?php echo $scolarite['classe']; ?> </h4>
	            </div>
	        </div>
	        <!-- ******************** Fin Scolarité du stagiaire ************** -->
	    </div>
	</body>

	</html>