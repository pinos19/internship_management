﻿	<?php
	require('../utilisateurs/ma_session.php');
	?>


	<?php

	require('../connexion.php');

	if (isset($_GET['nom']))
		$nom = $_GET['nom'];
	else
		$nom = "";

	if (isset($_GET['niveau_diplome']))
		$niveau = $_GET['niveau_diplome'];
	else
		$niveau = "ALL";

	if ($niveau != "ALL") { //si le $niveau =Q ou T ou TS
		$requete = " SELECT * 
								FROM FILIERE		  
								WHERE nom like '%$nom%'
								AND niveau_diplome = '$niveau' ";

		$requete_count = "	SELECT count(*) as nbr_filieres 
											FROM filiere
											WHERE nom like '%$nom%'
											AND niveau_diplome = '$niveau' ";
	} else {
		$requete = " SELECT * 
								FROM FILIERE		  
								WHERE nom like '%$nom%' ";

		$requete_count = "	SELECT count(*) as nbr_filieres 
											FROM filiere
											WHERE nom like '%$nom%' ";
	}

	$les_filieres = $pdo->query($requete);
	// $les_filieres contients le résultat de la requete :SELECT * FROM FILIERE	

	$toute_les_filieres = $les_filieres->fetchAll();
	// la methode fetchAll retourne toutes les lignes de la table filière



	$req_nbr_filieres = $pdo->query($requete_count);
	$resultat_req_nbr_filieres = $req_nbr_filieres->fetch();
	$nbr_filiere = $resultat_req_nbr_filieres['nbr_filieres'];

	if ($nbr_filiere <= 1)
		$msg = "$nbr_filiere filière trouvée";
	else
		$msg = "$nbr_filiere filières trouvées";

	?>

	<!DOCTYPE html>
	<html>

	<head>
	    <meta charset="utf-8" />
	    <title> les Filières </title>

	    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	    <link rel="stylesheet" type="text/css" href="../css/monStyle.css">
	    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">

	    <script src="../js/jquery-1.10.2.js"></script>
	    <script src="../js/bootstrap.min.js"></script>

	</head>

	<body>
	    <!-- debut *************************************** -->
	    <?php include('../menu.php'); ?>
	    <!--  fin **************************************** -->
	    <br><br>
	    <div class="container">
	        <h1 class="text-center"> Liste des filières <?php echo (date("Y") - 1) . " - " . date("Y"); ?> </h1>

	        <div class="panel panel-primary">
	            <div class="panel-heading">Rechecher des filères (<?php echo  $msg ?> )</div>
	            <div class="panel-body">
	                <form class="form-inline">
	                    <label> Niveau: </label>
	                    <select name="niveau_diplome" class="form-control" onChange="this.form.submit();">
	                        <option value="ALL" <?php if ($niveau == "ALL")  echo "selected" ?>>Tous les niveaux</option>
	                        <option value="B5i" <?php if ($niveau == "B5i")  echo "selected" ?>>Bac+5: Diplôme
	                            d'Ingénieur</option>
	                        <option value="B5m" <?php if ($niveau == "B5m")  echo "selected" ?>>Bac+5:
	                            Master</option>
	                    </select>

	                    <input type="text" name="nom" value="<?php echo $nom ?>" class="form-control"
	                        placeholder="Recherche par nom">

	                    <input type="submit" value="Rechercher" class="btn btn-primary">
	                </form>
	            </div>
	        </div>


	        <table class="table table-striped">
	            <thead>
	                <tr>
	                    <th>Id</th>
	                    <th>Nom</th>
	                    <th>Campus</th>
	                    <th>Durée de Formation </th>
	                    <th>Date de création </th>
	                    <th>Date d'accréditation</th>
	                    <th>Nº accréditation</th>
	                    <th>Niveau de diplôme</th>
	                    <?php if ($_SESSION['user']['role'] == 'Directeur') {  ?>
	                    <th> Actions </th>
	                    <?php } ?>
	                </tr>
	            </thead>

	            <tbody>
	                <?php foreach ($toute_les_filieres as $la_filiere) {  ?>
	                <!-- Pour chaque filiere de l'ensemble  toute_les_filieres -->

	                <tr>
	                    <td> <?php echo $la_filiere['id'] ?> </td>
	                    <td> <?php echo $la_filiere['nom'] 	?> </td>
	                    <td> <?php echo $la_filiere['campus'] ?> </td>
	                    <td> <?php echo $la_filiere['duree_formation'] ?> </td>
	                    <td> <?php echo $la_filiere['date_creation'] ?> </td>
	                    <td> <?php echo $la_filiere['date_accreditation'] ?> </td>
	                    <td> <?php echo $la_filiere['num_accreditation'] ?> </td>
	                    <td> <?php echo $la_filiere['niveau_diplome'] ?> </td>
	                    <?php if ($_SESSION['user']['role'] == 'Directeur') {  ?>
	                    <td>

	                        <a href="page_edit_filiere.php?id=<?php echo $la_filiere['id'] ?>"
	                            class="btn btn-success btn-edit-delete">Modifier
	                        </a>

	                        <a onclick="return confirm('Etes-vous sûr de vouloir supprimer cette filière')"
	                            href="delete_filiere.php?id=<?php echo $la_filiere['id'] ?>"
	                            class="btn btn-danger btn-edit-delete">Supprimer
	                        </a>

	                    </td>
	                    <?php } ?>
	                </tr>

	                <?php } ?>
	            </tbody>
	        </table>
	        <?php if ($_SESSION['user']['role'] == 'Directeur') {  ?>
	        <a href="page_add_filiere.php" class="btn btn-primary">Nouvelle filière </a>
	        <?php } ?>
	    </div>
	</body>

	</html>