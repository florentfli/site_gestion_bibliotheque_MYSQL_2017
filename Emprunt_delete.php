<?php

include("connexion_bdd.php");

echo $_GET["idAdherent"];

if(isset($_GET["idAdherent"])AND (isset($_GET["noExemplaire"]))AND (isset($_GET["dateEmprunt"]))){
    $idAdherent=htmlentities($_GET["idAdherent"]);
    $noExemplaire=htmlentities($_GET["noExemplaire"]);
    $dateEmprunt=htmlentities($_GET["dateEmprunt"]);
    $requeteSQL="DELETE FROM Emprunt
 WHERE (idAdherent= ".$idAdherent." AND noExemplaire = ".$noExemplaire." AND dateEmprunt = '".$dateEmprunt."');";
    echo $requeteSQL;
    $bdd->exec($requeteSQL);
    header("Location: Emprunt_show.php");
}
else{
    print "pas d'id";
}?>

