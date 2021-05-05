	<?php
require('../utilisateurs/ma_session.php');
?>


<?php

/* Initialisation des variables qui s'instancient lorsqu'on sélectionne dans les listes déroulantes*/

if (isset($_GET['annee_scolaire']))
    $annee_scolaire = $_GET['annee_scolaire'];
else
    $annee_scolaire = 'Toutes les années confondues';

if (isset($_GET['campus']))
    $campus = $_GET['campus'];
else
    $campus = 'Tous les campus confondus';

if (isset($_GET['nom_recherche'])) {
    $nom_recherche = $_GET['nom_recherche'];
    $temp_maj = strtoupper($nom_recherche);
    $and3 = "and upper(E.nom) like '$temp_maj%'";
} else {
    $nom_recherche = '';
    $and3 = "";
}


include("../fonctions.php");
require('../connexion.php');
$pdo->exec("SET CHARACTER SET utf8");

// En fontion des variables sélectionnées, la requête qui affiche les étudiants va être modifiée, d'où les $and 
switch ($annee_scolaire) {
    case 'Toutes les années confondues':
        $and1 = "";
        break;
    case 'Première Année':
        $and1 = "and annee_scolaire='ING1'";
        break;
    case 'Deuxième Année':
        $and1 = "and annee_scolaire='ING2'";
        break;
    case 'Troisième Année':
        $and1 = "and annee_scolaire='ING3'";
        break;
    case 'Diplômé/Plus en formation':
        $and1 = "and annee_scolaire='Diplômé/Plus en formation'";
        break;
    default:
        exit("Un erreur est survenue");
}
switch ($campus) {
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

//La requête qui va servir à afficher les stagiaires en fonction des champs sélectionnés


$requete_preparee = "select id_etudiant, E.nom as nom, prenom, civilite, date_naissance, id_adresse, email,tel , 
						annee_scolaire, C.nom as nom_campus from etudiant E, campus C where C.id_campus=E.id_campus $and1 $and2 $and3";

$requete_stagiaires = $pdo->query($requete_preparee);
$tous_les_stagiaires = $requete_stagiaires->fetchAll();
$nbr_stagiaires = count($tous_les_stagiaires); // $tous_les_stagiaires est un array associatif est contient les étudiants sélectionnés 
// par les champs de recherche
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


                <!-- On affiche les critères de la recherche et le nombre d'étudiants trouvés-->

                <div class="panel-heading">Rechecher les stagiaires,
                    <?php echo "on a : " . $nbr_stagiaires . " stagiaires en " . $annee_scolaire . " sur " . $campus . " avec la recherche : " . $nom_recherche ?>
                </div>
                <div class="panel-body">

                    <!-- ******************** Début Formulaire de recherche des stagiaires ***************** -->
                    <form class="form-inline">
                        <!-- On crée un array qui stocke les valeurs possibles pour la liste déroulante : années -->
                        <?php $annees_tableau = array('Toutes les années confondues', 'Première Année', 'Deuxième Année', 'Troisième Année', 'Diplômé/Plus en formation'); ?>

                        <label> Année Scolaire : </label>
                        <!--une variable $_GET va être créer dès que l'user choisit une option de la liste déroulante-->
                        <!--C'est la variable $annee_scolaire qui récupère le choix de l'user, ensuite on parcourt le tableau des années-->
                        <!--et dès qu'il y a match entre l'année choisie et l'année du tableau, on met l'option en selected, cela permet -->
                        <!-- de conserver la saisie même si la page se recherche -->
                        <select class="form-control" name="annee_scolaire" onChange="this.form.submit();">
                            <?php foreach ($annees_tableau as $annee) {; ?>
                            <option <?php if ($annee_scolaire == $annee) echo 'selected' ?>>
                                <?php echo $annee; ?>
                            </option>
                            <?php } ?>
                        </select>
                        <!-- même principe avec les campus-->
                        <?php $campus_tableau = array('Tous les campus confondus', 'Calais', 'Saint-Omer', 'Dunkerque'); ?>
                        <!-- On met ici les champs pour le campus-->
                        <label> Campus : </label>
                        <select class="form-control" name="campus" onChange="this.form.submit();">
                            <?php foreach ($campus_tableau as $camp) { ?>
                            <option <?php if ($campus == $camp) echo 'selected' ?>>
                                <?php echo $camp; ?>
                            </option>
                            <?php } ?>
                        </select>
                        <!-- recherche par nom $nom_recherche contient ce que rentre l'user dans le champ, la recherche se conserve si l'on modifie l'année/le campus-->
                        <!-- pour remettre la recherche à 0, on fait un onclick qui met la valeur du champ à 0-->
                        <input type="text" name="nom_recherche" id="nom_recherche" value="<?php echo $nom_recherche ?>"
                            class="form-control" placeholder="Nom" onclick="getElementById('nom_recherche').value=''" />
                        <button class="btn btn-primary">
                            <span class="fa fa-search"></span>
                        </button>
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
                    <?php
                        $id_etudiant = $le_stagiaire['id_etudiant'];

                        //requêtes pour le stage 1
                        //requête qui récupère les informations du tuteur interne/externe et les infos de l'entreprise
                        $req_stage1_tuteur_interne = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_interne=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=1";
                        $req_stage1_tuteur_externe = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=1";
                        $req_stage1_entreprise = "select Ent.nom as nom, A.indicatif as indicatif, A.rue as rue, A.ville as ville, 
														A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A, entreprise Ent
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_entreprise=Ent.id_entreprise and Ent.id_adresse=A.id_adresse 
														and S.stage_niveau=1";

                        // requêtes pour le stage 2
                        $req_stage2_tuteur_interne = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_interne=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=2";
                        $req_stage2_tuteur_externe = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=2";
                        $req_stage2_entreprise = "select Ent.nom as nom, A.indicatif as indicatif, A.rue as rue, A.ville as ville, 
														A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A, entreprise Ent
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_entreprise=Ent.id_entreprise and Ent.id_adresse=A.id_adresse 
														and S.stage_niveau=2";

                        // requêtes pour le stage 3
                        $req_stage3_tuteur_interne = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_interne=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=3";
                        $req_stage3_tuteur_externe = "select T.nom as nom, T.prenom as prenom, T.email as email,
														T.tel as tel, A.indicatif as indicatif, A.rue as rue, A.ville as
														ville, A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_adresse=A.id_adresse and S.stage_niveau=3";
                        $req_stage3_entreprise = "select Ent.nom as nom, A.indicatif as indicatif, A.rue as rue, A.ville as ville, 
														A.code_postal as code_postal
														from etudiant E, stage S, tuteur T, adresse A, entreprise Ent
														where S.id_etudiant=$id_etudiant and S.id_tuteur_externe=T.id_tuteur 
														and T.id_entreprise=Ent.id_entreprise and Ent.id_adresse=A.id_adresse 
														and S.stage_niveau=3";


                        $stage1_tuteur_interne_result = $pdo->query($req_stage1_tuteur_interne);
                        $stage1_tuteur_externe_result = $pdo->query($req_stage1_tuteur_externe);
                        $stage1_entreprise_result = $pdo->query($req_stage1_entreprise);

                        $stage2_tuteur_interne_result = $pdo->query($req_stage2_tuteur_interne);
                        $stage2_tuteur_externe_result = $pdo->query($req_stage2_tuteur_externe);
                        $stage2_entreprise_result = $pdo->query($req_stage2_entreprise);

                        $stage3_tuteur_interne_result = $pdo->query($req_stage3_tuteur_interne);
                        $stage3_tuteur_externe_result = $pdo->query($req_stage3_tuteur_externe);
                        $stage3_entreprise_result = $pdo->query($req_stage3_entreprise);

                        $stage1_tuteur_interne = $stage1_tuteur_interne_result->fetch();
                        $stage1_tuteur_externe = $stage1_tuteur_externe_result->fetch();
                        $stage1_entreprise = $stage1_entreprise_result->fetch();

                        $stage2_tuteur_interne = $stage2_tuteur_interne_result->fetch();
                        $stage2_tuteur_externe = $stage2_tuteur_externe_result->fetch();
                        $stage2_entreprise = $stage2_entreprise_result->fetch();

                        $stage3_tuteur_interne = $stage3_tuteur_interne_result->fetch();
                        $stage3_tuteur_externe = $stage3_tuteur_externe_result->fetch();
                        $stage3_entreprise = $stage3_entreprise_result->fetch();
                        //On récupère les informations, cela peut être optimisé 


                        if (empty($stage1_tuteur_interne)) { // test pour savoir si l'étudiant à fait son stage de première année
                            $stage1_indicateur = 0;
                        } else {
                            $stage1_indicateur = 1;
                        }


                        if (empty($stage2_tuteur_interne)) { // idem pour le stage de deuxième année
                            $stage2_indicateur = 0;
                        } else {
                            $stage2_indicateur = 1;
                        }
                        if (empty($stage3_tuteur_interne)) {
                            $stage3_indicateur = 0;
                        } else {
                            $stage3_indicateur = 1;
                        }

                        ?>
                    <tr>
                        <td><?php echo $le_stagiaire['nom'] ?> </td>
                        <td><?php echo $le_stagiaire['prenom'] ?> </td>
                        <td><?php echo $le_stagiaire['civilite'] ?> </td>
                        <td><?php echo $le_stagiaire['date_naissance'] ?> </td>
                        <td><?php echo $le_stagiaire['annee_scolaire'] ?> </td>
                        <td><?php echo $le_stagiaire['nom_campus'] ?> </td>
                        <td><?php echo $le_stagiaire['email'] ?> </td>
                        <td><?php echo $le_stagiaire['tel'] ?> </td>
                        <td>
                            <!-- on passe à la fonction afficherStages(), les paramètres indicateurs de stage 1/2/3 ainsi que l'indice d'étudiant -->
                            <!-- rappel on est à l'intérieur d'une boucle -->
                            <button class="btn btn-primary"
                                onclick="afficherStages(<?php echo $stage1_indicateur ?>,<?php echo $stage2_indicateur ?>,<?php echo $stage3_indicateur ?>,<?php echo $id_etudiant ?>)">
                                <span class="fa fa-search"></span>
                            </button>
                            <a class="btn btn-success"
                                href="../fpdf/page_document.php?id_stagiaire=<?php echo $le_stagiaire['id_etudiant'] ?>">
                                <span class="fa fa-print"></span>
                            </a>
                        </td>
                    </tr>
                    <!-- Ici c'est la partie qui affiche les informations concernant le stage 1 -->
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <th colspan="9" style="text-align:center"> Stage de première année - Découverte du milieu du
                            travail </th>
                    </tr>
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <td colspan="3"><strong>Tuteur interne :</strong><br />
                            Nom : <?php echo $stage1_tuteur_interne['nom'] ?><br />
                            Prénom : <?php echo $stage1_tuteur_interne['prenom'] ?><br />
                            Email : <?php echo $stage1_tuteur_interne['email'] ?><br />
                            Téléphone : <?php echo $stage1_tuteur_interne['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage1_tuteur_interne['indicatif'] . ", " . $stage1_tuteur_interne['rue'] ?><br />
                            <?php echo $stage1_tuteur_interne['code_postal'] . ", " . $stage1_tuteur_interne['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Tuteur externe :</strong><br />
                            Nom : <?php echo $stage1_tuteur_externe['nom'] ?><br />
                            Prénom : <?php echo $stage1_tuteur_externe['prenom'] ?><br />
                            Email : <?php echo $stage1_tuteur_externe['email'] ?><br />
                            Téléphone : <?php echo $stage1_tuteur_externe['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage1_tuteur_externe['indicatif'] . ", " . $stage1_tuteur_externe['rue'] ?><br />
                            <?php echo $stage1_tuteur_externe['code_postal'] . ", " . $stage1_tuteur_externe['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Entreprise accueillante :</strong><br />
                            Nom : <?php echo $stage1_entreprise['nom'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage1_entreprise['indicatif'] . ", " . $stage1_entreprise['rue'] ?><br />
                            <?php echo $stage1_entreprise['code_postal'] . ", " . $stage1_entreprise['ville'] ?>

                        </td>
                    </tr>
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <th colspan="9" style="text-align:center"> Stage de deuxième année - Assistant Ingénieur </th>
                    </tr>
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <td colspan="3"><strong>Tuteur interne :</strong><br />
                            Nom : <?php echo $stage2_tuteur_interne['nom'] ?><br />
                            Prénom : <?php echo $stage2_tuteur_interne['prenom'] ?><br />
                            Email : <?php echo $stage2_tuteur_interne['email'] ?><br />
                            Téléphone : <?php echo $stage2_tuteur_interne['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage2_tuteur_interne['indicatif'] . ", " . $stage2_tuteur_interne['rue'] ?><br />
                            <?php echo $stage2_tuteur_interne['code_postal'] . ", " . $stage2_tuteur_interne['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Tuteur externe :</strong><br />
                            Nom : <?php echo $stage2_tuteur_externe['nom'] ?><br />
                            Prénom : <?php echo $stage2_tuteur_externe['prenom'] ?><br />
                            Email : <?php echo $stage2_tuteur_externe['email'] ?><br />
                            Téléphone : <?php echo $stage2_tuteur_externe['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage2_tuteur_externe['indicatif'] . ", " . $stage2_tuteur_externe['rue'] ?><br />
                            <?php echo $stage2_tuteur_externe['code_postal'] . ", " . $stage2_tuteur_externe['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Entreprise accueillante :</strong><br />
                            Nom : <?php echo $stage2_entreprise['nom'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage2_entreprise['indicatif'] . ", " . $stage2_entreprise['rue'] ?><br />
                            <?php echo $stage2_entreprise['code_postal'] . ", " . $stage2_entreprise['ville'] ?>

                        </td>
                    </tr>
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <th colspan="9" style="text-align:center"> Stage de troisième année - Projet de Fin d'Etudes
                        </th>
                    </tr>
                    <tr class="<?php echo $id_etudiant ?>" style='display:none'>
                        <td colspan="3"><strong>Tuteur interne :</strong><br />
                            Nom : <?php echo $stage3_tuteur_interne['nom'] ?><br />
                            Prénom : <?php echo $stage3_tuteur_interne['prenom'] ?><br />
                            Email : <?php echo $stage3_tuteur_interne['email'] ?><br />
                            Téléphone : <?php echo $stage3_tuteur_interne['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage3_tuteur_interne['indicatif'] . ", " . $stage3_tuteur_interne['rue'] ?><br />
                            <?php echo $stage3_tuteur_interne['code_postal'] . ", " . $stage3_tuteur_interne['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Tuteur externe :</strong><br />
                            Nom : <?php echo $stage3_tuteur_externe['nom'] ?><br />
                            Prénom : <?php echo $stage3_tuteur_externe['prenom'] ?><br />
                            Email : <?php echo $stage3_tuteur_externe['email'] ?><br />
                            Téléphone : <?php echo $stage3_tuteur_externe['tel'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage3_tuteur_externe['indicatif'] . ", " . $stage3_tuteur_externe['rue'] ?><br />
                            <?php echo $stage3_tuteur_externe['code_postal'] . ", " . $stage3_tuteur_externe['ville'] ?>
                        </td>
                        <td colspan="3"><strong>Entreprise accueillante :</strong><br />
                            Nom : <?php echo $stage3_entreprise['nom'] ?><br />
                            <strong>Adresse :</strong><br />
                            <?php echo $stage3_entreprise['indicatif'] . ", " . $stage3_entreprise['rue'] ?><br />
                            <?php echo $stage3_entreprise['code_postal'] . ", " . $stage3_entreprise['ville'] ?>

                        </td>
                    </tr>
                    <?php  } ?>
                </tbody>

            </table>

            <!--<a href="page_add_stagiaire.php" class="btn btn-primary">
	                <span class="fa fa-plus"></span> NOUVEAU STAGIAIRE
	            </a>-->
        </div>
        <script>
        function afficherStages(stage1, stage2, stage3, id_etudiant) {
            contents = document.getElementsByClassName(id_etudiant);
            console.log(contents[0].parentNode);
            if (stage3) {
                if (contents[4].style.display ==
                    'none') { //si le bouton appuie on affiche la section, on tient compte des
                    //indicateurs de stage
                    contents[4].style.display = 'table-row'; //pour ne pas afficher des sections vides
                    contents[5].style.display = 'table-row';
                } else {
                    contents[4].style.display = 'none';
                    contents[5].style.display = 'none';
                }
            }
            if (stage2) {
                if (contents[2].style.display == 'none') {
                    contents[2].style.display = 'table-row';
                    contents[3].style.display = 'table-row';
                } else {
                    contents[2].style.display = 'none';
                    contents[3].style.display = 'none';
                }
            }
            if (stage1) {
                if (contents[0].style.display == 'none') {
                    contents[0].style.display = 'table-row';
                    contents[1].style.display = 'table-row';
                } else {
                    contents[0].style.display = 'none';
                    contents[1].style.display = 'none';
                }
            }
        }
        </script>

    </body>

    </html>
