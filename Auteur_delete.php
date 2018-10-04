<?php
// connexion à la base de données :
// création d'une instance d'un objet PDO de nom $bdd
include("connexion_bdd.php");
// traitement :
// test si on soumet un formulaire ou pas
// test si il y a des paramètres dans L’URL
// en fonction des tests, exécution de requête(s) SQL
// en fonction des tests et des résultats des requêtes SQL, création de variables, tableaux associatifs ...
// éventuellement redirection

if (isset($_GET["id"]) AND is_numeric($_GET["id"]))
{
    $id=htmlentities($_GET["id"]);

    $ma_requete_SQL="SELECT * FROM AUTEUR WHERE idAuteur = ".$id.";";
    $reponse = $bdd->query($ma_requete_SQL);
    $donneesAuteur = $reponse->fetchAll();

    $ma_requete_SQL="SELECT noOeuvre FROM OEUVRE WHERE idAuteur = ".$id.";";
    $reponse = $bdd->query($ma_requete_SQL);
    $donnees = $reponse->fetchAll();

    if (empty($donnees)){
        $ma_requete_SQL="DELETE FROM AUTEUR WHERE idAuteur = ".$id.";";
        echo $ma_requete_SQL;
        $bdd->exec($ma_requete_SQL);

        header("Location: Auteur_show.php");
    }
}

?>

<?php include("v_head.php"); ?>

<?php include("v_nav.php"); ?>

<?php include("v_foot.php"); ?>