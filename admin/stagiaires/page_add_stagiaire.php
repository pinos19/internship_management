<?php
require('../utilisateurs/ma_session.php');
include("../fonctions.php");
require('../utilisateurs/mon_role.php');
require('../connexion.php');

$requete_filieres = "SELECT * FROM filiere";
$result_requete_filieres = $pdo->query($requete_filieres);
$toutes_les_filieres = $result_requete_filieres->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title> Nouveau stagiaire </title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" href="../css/monStyle.css">

    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/jquery-ui-1.10.4.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script src="../js/school.js"></script>

    <script src="js/jquery-ui-i18n.min.js"></script>
    <script>
    $(function() {
        // définit les options par défaut du calendrier
        $.datepicker.setDefaults({
            showButtonPanel: true, // affiche des boutons sous le calendrier
            showOtherMonths: true, // affiche les autres mois
            selectOtherMonths: true // possibilités de sélectionner les jours des autres mois
        });

        //$("#calendar").datepicker(); // affiche le calendrier par défaut
        //$("#calendar").datepicker($.datepicker.regional["fr"]); // affiche le calendrier en fr
        $("#calendar").datepicker({
            dateFormat: "yy-mm-dd",

        });
        $("#calendar1").datepicker({
            dateFormat: "yy-mm-dd",

        });
    });
    </script>


</head>

<body>
    <?php include('../menu.php'); ?>
    <br><br><br>
    <div class="container">


        <div class="panel panel-primary">
            <div class="panel-heading" align="center"> Nouveau stagiaire</div>
            <div class="panel-body">
                <form method="post" action="insert_stagiaire.php" enctype="multipart/form-data">

                    <div class="row my-row">
                        <label for="prenom" class="control-label col-sm-2"> Prénom </label>
                        <div class="col-sm-4">
                            <input required type="text" name="prenom" id="prenom" class="form-control">
                        </div>


                        <label for="nom" class="control-label col-sm-2"> Nom </label>
                        <div class="col-sm-4">
                            <input required type="text" name="nom" id="nom" class="form-control">
                        </div>

                    </div>


                    <div class="row my-row">


                        <label for="niveau" class="control-label col-sm-2">Niveau </label>
                        <div class="col-sm-4">
                            <input required type="text" name="niveau" id="niveau" class="form-control">
                        </div>
                        <label for="campus" class="control-label col-sm-2">Campus </label>
                        <div class="col-sm-4">
                            <input required type="text" name="campus" id="campus" class="form-control">
                        </div>

                    </div>

                    <div class="row my-row">
                        <label for="num_etudiant" class="control-label col-sm-2"> Numéro de l'étudiant </label>
                        <div class="col-sm-4">
                            <input required type="text" name="num_etudiant" id="num_etudiant" class="form-control">
                        </div>

                        <label for="entreprise_accueil" class="control-label col-sm-2"> Entreprise d'accueil </label>
                        <div class="col-sm-4">
                            <input required type="text" name="entreprise_accueil" id="entreprise_accueil"
                                class="form-control">
                        </div>

                    </div>

                    <div class="row my-row">
                        <label for="tuteur_interne" class="control-label col-sm-2"> Tuteur de stage Interne </label>
                        <div class="col-sm-4">
                            <input required type="text" name="tuteur_interne" id="tuteur_interne" class="form-control">
                        </div>

                        <label for="tuteur_externe" class="control-label col-sm-2"> Tuteur de stage Externe </label>
                        <div class="col-sm-4">
                            <input required type="text" name="tuteur_externe" id="tuteur_externe" class="form-control">
                        </div>

                    </div>

                    <div class="row my-row">
                        <label for="adr_mail_acad" class="control-label col-sm-2"> Adresse mail académique (ULCO)
                        </label>
                        <div class="col-sm-4">
                            <input required type="text" name="adr_mail_acad" id="adr_mail_acad" class="form-control">
                        </div>

                        <label for="linkedin" class="control-label col-sm-2"> Linkedin </label>
                        <div class="col-sm-4">
                            <input required type="text" name="linkedin" id="linkedin" class="form-control">
                        </div>

                    </div>

                    <div class="row my-row">
                        <label for="type_de_stage" class="control-label col-sm-2"> Type de stage </label>
                        <div class="col-sm-4">
                            <input required type="text" name="type_de_stage" id="type_de_stage" class="form-control">
                        </div>

                        <label for="num_inscription" class="control-label col-sm-2"> N° d'inscription </label>
                        <div class="col-sm-4">
                            <input required type="text" name="num_inscription" id="num_inscription"
                                class="form-control">
                        </div>

                    </div>

                    <div class="row my-row">
                        <label for="calendar" class="control-label col-sm-2"> DATE D'INSCRIPTION </label>
                        <div class="col-sm-4">
                            <input required type="text" name="date_inscription" id="calendar" class="form-control">
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
                                <option> ING2</option>
                            </select>
                        </div>
                        <br><br>
                    </div>


                    <button type='submit' class="btn btn-success"> Enregistrer le stagiaire</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>