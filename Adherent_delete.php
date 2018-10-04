<?php
include("connexion_bdd.php");
if(isset($_GET["cas"]) AND isset($_GET["id"])){
    $id=htmlentities($_GET["id"]);
    $requeteSQL="DELETE FROM ADHERENT WHERE idAdherent = ".$id.";";
    echo $requeteSQL;
    $bdd->exec($requeteSQL);
    header("Location: Adherent_show.php");
}
else if(isset($_GET["id"]) AND is_numeric($_GET["id"])){
    $id=htmlentities($_GET["id"]);
    $requete1SQL="SELECT noExemplaire FROM emprunt WHERE idAdherent = ".$id.";";
    $reponse = $bdd->query($requete1SQL);
    $donnees = $reponse->fetchAll();
    echo "Numéros des exemplaires empruntés actuellement: ";
    foreach ($donnees as $value){
        echo $value["noExemplaire"];
        echo " / ";
    }
    echo "<BR>";
    echo "Etes vous sur de vouloir supprimer cet adherent?";
    ?>
    <a href="Adherent_delete.php?id=<?php echo $id;?>&cas=1">Supprimer</a>
    <?php
    if(empty($donnees)){
        $requeteSQL="DELETE FROM ADHERENT WHERE idAdherent = ".$id.";";
        echo $requeteSQL;
        $bdd->exec($requeteSQL);
        header("Location: Adherent_show.php");
    }
}
else{
    print "pas d'id";
}?>

