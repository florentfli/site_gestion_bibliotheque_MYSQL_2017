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

// affichage de la vue

if (isset($_GET["id"]) AND is_numeric($_GET["id"]))
{
    $id=htmlentities($_GET["id"]);

    $ma_requete_SQL="SELECT * FROM EXEMPLAIRE WHERE noOeuvre = ".$id.";";
    $reponse = $bdd->query($ma_requete_SQL);
    $donnees = $reponse->fetchAll();

    if (empty($donnees)){
        $ma_requete_SQL="DELETE FROM OEUVRE WHERE noOeuvre = ".$id.";";
        echo $ma_requete_SQL;
        $bdd->exec($ma_requete_SQL);

        header("Location: Oeuvre_show.php");
    }
}

?>

<?php include("v_head.php"); ?>

<?php include("v_nav.php"); ?>

<div class="container">
    il existe des enregistrements a supprimer dans la table EXEMPLAIRE avant de supprimer cet oeuvre
    <ul>
        <?php foreach ($donnees as $value): ?>
        <li>
            num :
            <?php echo ($value['noExemplaire']); ?>
            - etat :
            <?php echo ($value['etat']); ?>
            - date achat :
            <?php echo ($value['dateAchat']); ?>
            - prix :
            <?php echo ($value['prix']); ?>
            <a href="Exemplaire_delete.php?noExemplaire=<?php echo ($value['noExemplaire']); ?>&cas=">supprimer</a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include("v_foot.php"); ?>