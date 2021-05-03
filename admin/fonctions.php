<?php
function annee_scolaire_actuelle()

{
    $mois = date("m"); //Le mois de la date actuelle
    $annee_actuelle = date("Y"); //L'année de la date actuelle
    if ($mois >= 9 && $mois <= 12) {
        $annee1 = $annee_actuelle;
        $annee2 = $annee_actuelle + 1;
    } else {
        $annee1 = $annee_actuelle - 1;
        $annee2 = $annee_actuelle;
    }

    $annee_scolaire_actuelle = $annee1 . "/" . $annee2;
    return $annee_scolaire_actuelle;
}

function nombre_annee_scolaire()
{
    $annee_debut = 2010;
    $mois = date("m");
    $annee_actuelle = date("Y"); //2018
    if ($mois >= 9 && $mois <= 12)
        return ($annee_actuelle - $annee_debut) + 1;
    else
        return $annee_actuelle - $annee_debut;
}

function les_annee_scolaire($annee_debut = 2010)
{
    $les_annees = array();
    for ($i = 1; $i <= nombre_annee_scolaire(); $i++) {
        $annee_sc = ($annee_debut + ($i - 1)) . "/" . ($annee_debut + $i);
        $les_annees[] = $annee_sc;
    }
    return $les_annees;
}

//Recherche par login
function recherche_user_byLogin($login)
{
    global $pdo;
    $req = $pdo->prepare("select * from utilisateur where login=?");
    $valeur = array($login);
    $req->execute($valeur);
    $nbr_user = $req->rowCount();
    return $nbr_user;
}

//Recherche par login et id
function recherche_user_byLoginId($login, $id)
{
    global $pdo;
    $req = $pdo->prepare("select * from utilisateur where login=? and id_utilisateur!=?");
    $valeur = array($login, $id);
    $req->execute($valeur);
    $nbr_user = $req->rowCount();
    return $nbr_user;
}

//Recherche par login et pwd (Soit l'utilisateur soit NULL)
function recherche_user_byLoginPwd($login, $pwd)
{
    global $pdo;

    $req = $pdo->prepare("select * from utilisateur where login=? and pwd=?");
    $valeur = array($login, $pwd);
    $req->execute($valeur);
    $nbr_user = $req->rowCount();

    if ($nbr_user == 1) // si l'utilisateur existe
        return $req->fetch(); //Retourner l'utilisateur(id_utilisateur,login,pwd et role)
    else // si l'utilisateur n'existe pas
        return 0;
}

function dateEnToDateFr($dateEn)
{
    //$dateEn='2019-02-26';
    return substr($dateEn, 8, 2) . "/" . substr($dateEn, 5, 2) . "/" . substr($dateEn, 0, 4);
    // Result: '26/02/2019'
}

function dateFrToDateEn($dateFr)
{
    //$dateFR='26/02/2019';
    return substr($dateFr, 6, 4) . "-" . substr($dateFr, 3, 2) . "-" . substr($dateFr, 0, 2);
    // Result: '2019-02-26'
}

//Effectif des inscris en 1ère et 2ème et en 3 eme
function getEffectifAll()
{
    global $pdo;
    $pdo->exec("SET CHARACTER SET utf8");
    $res = $pdo->query("select count(*) as effectif from etudiant where annee_scolaire != 'Diplômé/Plus en formation'");
    $nbr = $res->fetch();
    return $nbr['effectif'];
}

//Effectif des inscris en 1ère
function getEffectif1()
{
    global $pdo;
    $pdo->exec("SET CHARACTER SET utf8");
    $res = $pdo->query("select count(*) as effectif from etudiant where annee_scolaire = 'Première Année'");
    $nbr = $res->fetch();
    return $nbr['effectif'];
}

//Effectif des inscris en 2ème
function getEffectif2()
{
    global $pdo;
    $pdo->exec("SET CHARACTER SET utf8");
    $res = $pdo->query("select count(*) as effectif from etudiant where annee_scolaire = 'Deuxième Année'");
    $nbr = $res->fetch();
    return $nbr['effectif'];
}

//Effectif des iscrits en 3 ème année

function getEffectif3()
{
    global $pdo;
    $pdo->exec("SET CHARACTER SET utf8");
    $res = $pdo->query("select count(*) as effectif from etudiant where annee_scolaire = 'Troisième Année'");
    $nbr = $res->fetch();
    return $nbr['effectif'];
}