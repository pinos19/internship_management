<?php
require('../utilisateurs/ma_session.php');
require_once('../connexion.php');
require_once('../fonctions.php');


$as = annee_scolaire_actuelle();

$n1 = getEffectif12($as);
$n2 = getEffectif1($as);
$n3 = getEffectif2($as);
$n4 = getEffectif3($as);


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
        <div class="container  tableau-stat text-center" style="margin-top:100px">
            <h1 class="text-center text-primary">Statistiques de l'année scolaire <?php echo $as ?></h1>
            <div class="row">

                <!-- ************ Total des inscrits en 1ère année et 2ème année ******************  -->

                <div class="col-md-4">
                    <div class="stat stat12">
                        <span class="fa fa-users"></span>
                        <div class="effectif">
                            Effectif total
                            <div class="nbr"><?php echo $n1 ?></div>
                        </div>

                    </div>
                </div>

                <!-- ************* Total des inscrits en 1ère année  *****************  -->

                <div class="col-md-4">
                    <div class="stat stat1">
                        <span class="fa fa-user-plus"></span>
                        <div class="effectif">
                            Effectif 1ère Année
                            <div class="nbr"><?php echo $n2 ?> </div>
                        </div>
                    </div>
                </div>

                <!-- ************* Total des inscrits en 2ème année *****************  -->


                <div class="col-md-4">
                    <div class="stat stat2">
                        <span class="fa fa-tags"></span>
                        <div class="effectif">
                            Effectif 2ème Année
                            <div class="nbr"><?php echo $n3 ?> </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" style="margin-top: 20px;">
                    <div class="stat stat3">
                        <span class="fa fa-tags"></span>
                        <div class="effectif">
                            Effectif 3ème Année
                            <div class="nbr"><?php echo $n4 ?> </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </body>

    </html>