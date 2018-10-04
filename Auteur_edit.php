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


if (isset($_GET["id"]) AND is_numeric($_GET["id"])){
    $id=htmlentities($_GET['id']);
    $ma_requete_sql="SELECT *
                     FROM AUTEUR
                     WHERE idAuteur=".$id.";";
    $reponse = $bdd->query($ma_requete_sql);
    $donnees = $reponse->fetch();
}

if (isset($_POST['prenomAuteur']) AND isset($_POST['nomAuteur']) AND isset($_POST['idAuteur'])){
    $donnees['idAuteur']=$_POST['idAuteur'];
    $donnees['nomAuteur']=htmlentities($_POST['nomAuteur']);
    $donnees['prenomAuteur']=htmlentities($_POST['prenomAuteur']);


    $erreurs=array();

    if (! preg_match("/^[A-Za-z]{1,}/", $donnees['nomAuteur'])) $erreurs['nomAuteur']='nom composé de 2 lettre minimum';
    if (! preg_match("/^[A-Za-z]{1,}/", $donnees['prenomAuteur'])) $erreurs['prenomAuteur']='Prenom composé de 2 lettre minimum';


    if (! is_numeric($donnees['idAuteur'])) $erreurs['idAuteur']='saisir une valeur ID';


    if (empty($erreurs)){
        //$donnees['nomAuteur']=$bdd->quote($donnees['nomAuteur']);

        $ma_requete_sql="UPDATE AUTEUR SET
        nomAuteur='".$donnees['nomAuteur']."'
        , prenomAuteur='".$donnees['prenomAuteur']."'
        WHERE idAuteur = ".$donnees['idAuteur'].";";
        var_dump($ma_requete_sql);
        $bdd->exec($ma_requete_sql);
        header("Location: Auteur_show.php");
    }
    else{
        $message='il y a des erreure => réafficher la vue (formulaire avec les erreurs)';
    }
}

?>

<?php include("v_head.php"); ?>

<?php include("v_nav.php"); ?>

    <form method="post" action="Auteur_edit.php">
        <div class="container">
            <fieldset>
                <legend>Modifier un Auteur</legend>
                <input name="idAuteur" type="hidden" value="<?php if (isset($donnees['idAuteur'])) echo $donnees['idAuteur']; ?>">

                <label>Nom :
                    <input name="nomAuteur" type="text" size="18" value="<?php if (isset($donnees['nomAuteur'])) echo $donnees['nomAuteur']; ?>">
                </label>
                <?php if (isset($erreurs['nomAuteur'])) echo '<div class="alert alert-danger">'.$erreurs['nomAuteur'].'</div>'; ?>

                <label>Prenom :
                    <input name="prenomAuteur" type="text" size="18" value="<?php if (isset($donnees['prenomAuteur'])) echo $donnees['prenomAuteur']; ?>">
                </label>
                <?php if (isset($erreurs['prenomAuteur'])) echo '<div class="alert alert-danger">'.$erreurs['prenomAuteur'].'</div>'; ?>

                <input type="submit" name="EditAuteur" value ="Edit">
            </fieldset>
        </div>
    </form>

<?php include("v_foot.php"); ?>