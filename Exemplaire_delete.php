<?php
include("connexion_bdd.php");

/*if (isset($_GET["noExemplaire"]) AND is_numeric($_GET["noExemplaire"])) {

    $noExemplaire = htmlentities($_GET['noExemplaire']);

    echo "" . $noExemplaire;
    $ma_requete_sql = "SELECT ex.noExemplaire, ex.noOeuvre
                     FROM exemplaire ex
                     WHERE noExemplaire=" . noExemplaire . ";";
    $reponse = $bdd->query($ma_requete_sql);
    $donnees = $reponse->fetch();
}

if (isset($_POST['titre']) AND isset($_POST['dateParution']) AND isset($_POST['idAuteur']) AND isset($_POST['noOeuvre'])) {
    $donnees['titre'] = $_POST['titre'];
    $donnees['dateParution'] = htmlentities($_POST['dateParution']);
    $donnees['idAuteur'] = htmlentities($_POST['idAuteur']);
    $donnees['noOeuvre'] = htmlentities($_POST['noOeuvre']);*/
//}

if(isset($_GET["cas"]) AND isset($_GET["id"])){
    $noExemplaired=htmlentities($_GET["id"]);
    $requete2SQL="SELECT noOeuvre FROM Exemplaire WHERE noExemplaire = ".$noExemplaired.";";
    $reponse = $bdd->query($requete2SQL);
    $donnees2 = $reponse->fetchAll();
    $no = $donnees2[0]["noOeuvre"];

    $requeteSQL="DELETE FROM Exemplaire WHERE noExemplaire = ".$noExemplaired.";";
    echo $requeteSQL;
    $bdd->exec($requeteSQL);
    $no = $donnees2[0]['noOeuvre'];
    $cible = "Location: Exemplaire_show.php?id=$no";
    header($cible);
}
else if(isset($_GET["id"]) AND is_numeric($_GET["id"])){
    $noExemplaired=htmlentities($_GET["id"]);
    $requete2SQL="SELECT noOeuvre FROM exemplaire WHERE noExemplaire = ".$noExemplaired.";";
    $reponse = $bdd->query($requete2SQL);
    $donnees2 = $reponse->fetchAll();
    $no = $donnees2[0]['noOeuvre'];

    $requete1SQL="SELECT idAdherent FROM emprunt WHERE noExemplaire = ".$noExemplaired.";";
    $reponse = $bdd->query($requete1SQL);
    $donnees = $reponse->fetchAll();
    echo "Numéro de l'adherent empruntant cet exemplaire: ";
    foreach ($donnees as $value){
        echo $value["idAdherent"];
        echo "/";
    }
    echo "<BR>";
    echo "Etes vous sur de vouloir supprimer cet Exemplaire?";
    ?>
    <a href="Exemplaire_delete.php?id=<?php echo $id;?>&cas=1">Supprimer</a>
    <?php
    if(empty($donnees)){
        $requeteSQL="DELETE FROM Exemplaire WHERE noExemplaire = ".$noExemplaired.";";
        $bdd->exec($requeteSQL);
        $cible = "Location: Exemplaire_show.php?id=$no";
        header($cible);
    }
}
else{
    print "pas d'id";
}?>
?>