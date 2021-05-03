	<?php
	require('../utilisateurs/ma_session.php');
	?>


	<?php


	if(isset($_GET['annee_scolaire']))
		$annee_scolaire=$_GET['annee_scolaire'];
	else
		$annee_scolaire='Toutes les années confondues';

	if(isset($_GET['campus']))
		$campus=$_GET['campus'];
	else
		$campus='Tous les campus confondus';

	include("../fonctions.php");
	require('../connexion.php');
	$pdo->exec("SET CHARACTER SET utf8");

	switch($annee_scolaire){
		case 'Toutes les années confondues':
			$and1 = "";
			break;
		case 'Première Année':
			$and1 = "and annee_scolaire='Première Année'";
			break;
		case 'Deuxième Année':
			$and1 = "and annee_scolaire='Deuxième Année'";
			break;
		case 'Troisième Année':
			$and1 = "and annee_scolaire='Troisième Année'";
			break;
		case 'Diplômé/Plus en formation':
			$and1 = "and annee_scolaire='Diplômé/Plus en formation'";
			break;
		default:
			exit("Un erreur est survenue");

	}

	switch($campus){
		case 'Tous les campus confondus':
			$and2 = "";
			break;
		case 'Calais':
			$and2 = "and C.nom='Calais'";
			break;
		case 'Saint-Omer':
			$and2 = "and C.nom='Saint-Omer'";
			break;
		case 'Dunkerque':
			$and2 = "and C.nom='Dunkerque'";
			break;
		default:
			exit("Un erreur est survenue");
	}




	$requete_preparee = "select E.nom as nom, prenom, civilite, date_naissance, id_adresse, email,tel , 
						annee_scolaire, C.nom as nom_campus from etudiant E, campus C where C.id_campus=E.id_campus $and1 $and2";

	$requete_stagiaires = $pdo->query($requete_preparee);
	$tous_les_stagiaires = $requete_stagiaires->fetchAll();
	$nbr_stagiaires = count($tous_les_stagiaires);

	


	?>
	<!DOCTPE html>
	    <html>

	    <head>
	        <meta charset="utf-8" />
	        <title> Les stagiaires </title>
	        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
	        <link rel="stylesheet" type="text/css" href="../css/monStyle.css">
	        <script src="../js/jquery-1.10.2.js"></script>
	        <script src="../js/bootstrap.min.js"></script>

	    </head>

	    <body>

	        <?php include('../menu.php'); ?>
			
	        <br><br>
			
	        <div class="container">

	            <h1 class="text-center"> Liste des stagiaires </h1>
	            <div class="panel panel-primary">

	                <div class="panel-heading">Rechecher les stagiaires (<?php echo $nbr_stagiaires ?> stagiaires)</div>
	                <div class="panel-body">

	                    <!-- ******************** Début Formulaire de recherche des stagiaires ***************** -->
	                    <form class="form-inline">
							<?php $annees_tableau = array('Toutes les années confondues','Première Année','Deuxième Année','Troisième Année','Diplômé/Plus en formation');?>
	                        <!-- On met au-dessus les champs pour les années -->
							<label> Année Scolaire : </label>
	                        <select class="form-control" name="annee_scolaire" onChange="this.form.submit();">
								<?php  foreach($annees_tableau as $annee){
									;?>
								<option <?php if($annee_scolaire==$annee) echo 'selected' ?>>
									<?php echo $annee; ?>
								</option>
								<?php } ?>
	                        </select>
							
							<?php $campus_tableau = array('Tous les campus confondus','Calais','Saint-Omer','Dunkerque');?><!-- On met ici les champs pour le campus-->
	                        <label> Campus : </label>
	                        <select class="form-control" name="campus" onChange="this.form.submit();">
	                            <?php foreach ($campus_tableau as $camp) { ?>
	                            <option <?php if($campus==$camp) echo 'selected' ?>>
									<?php echo $camp; ?>
								</option>
								<?php } ?>
	                        </select>



							<!--
	                        <input type="text" name="mot_cle" value="<?php// echo $mot_cle ?>" class="form-control"
	                            placeholder="Nom ou prénom">

	                        <label class="radio-inline">
	                            <input type="radio" value="0" <?php// if ($index_classe == 0) echo 'checked' ?>
	                                onChange="this.form.submit();" name="index_classe">Toutes les classes
	                        </label>
	                        <label class="radio-inline">
	                            <input type="radio" value="1" <?php// if ($index_classe == 1) echo 'checked' ?>
	                                onChange="this.form.submit();" name="index_classe">ING1
	                        </label>
	                        <label class="radio-inline">
	                            <input type="radio" value="2" <?php// if ($index_classe == 2) echo 'checked' ?>
	                                onChange="this.form.submit();" name="index_classe">ING2
	                        </label>

	                        <button class="btn btn-primary">
	                            <span class="fa fa-search"></span>
	                        </button>-->
	                    </form>
	                    <!-- ******************** Fin Formulaire de recherche des stagiaires ***************** -->


	                </div>
	            </div>

	            <table class="table table-striped">
	                <thead>
	                    <tr>
	                        <th> Nom </th>
	                        <th> Prénom </th>
							<th> Civilité</th>
							<th> Date de naissance</th>
	                        <th> Année de formation</th>
	                        <th> Campus </th>
	                        <th> Adresse Mail Académique</th>
							<th> Numéro de téléphone</th>
	                        <th> Actions</th>
	                    </tr>
	                </thead>

	                <tbody>

	                    <?php foreach ($tous_les_stagiaires as $le_stagiaire) { ?>

	                    <tr>
	                        <td><?php echo $le_stagiaire['nom'] ?> </td>
	                        <td><?php echo $le_stagiaire['prenom'] ?> </td>
	                        <td><?php echo $le_stagiaire['civilite'] ?> </td>
	                        <td><?php echo $le_stagiaire['date_naissance'] ?> </td>
	                        <td><?php echo $le_stagiaire['annee_scolaire'] ?> </td>
	                        <td><?php echo $le_stagiaire['nom_campus'] ?> </td>
	                        <td><?php echo $le_stagiaire['email'] ?> </td>
	                        <td><?php echo $le_stagiaire['tel'] ?> </td>
							<td> Hey </td>
	                    </tr>
						<?php  } ?>
					</tbody>

	        	</table>
	            
	            <a href="page_add_stagiaire.php" class="btn btn-primary">
	                <span class="fa fa-plus"></span> NOUVEAU STAGIAIRE
	            </a>
	        </div>
	    </body>

	</html>