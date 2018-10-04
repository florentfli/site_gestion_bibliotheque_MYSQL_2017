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
if(isset($_POST["nomAuteur"]) AND isset($_POST["prenomAuteur"]))
{

    $donnees['nomAuteur']=htmlentities($_POST['nomAuteur']);
    $donnees['prenomAuteur']=htmlentities($_POST['prenomAuteur']);

    $erreurs=array();

    if (! preg_match("/^[A-Za-z]{2,}/", $donnees['nomAuteur'])) $erreurs['nomAuteur']='nom composé de 2 lettres minimum';
    if (! preg_match("/^[A-Za-z]{2,}/", $donnees['prenomAuteur'])) $erreurs['prenomAuteur']='prenom composé de 2 lettres minimum';

    if (empty($erreurs)){
        $donnees['nomAuteur']=$bdd->quote($donnees['nomAuteur']);

        $ma_requete_sql="INSERT INTO AUTEUR (idAuteur,nomAuteur,prenomAuteur) VALUES
                    (NULL,".$donnees['nomAuteur'].",'".$donnees['prenomAuteur']."');";
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

<form method="post" action="Auteur_add.php">
    <div class="container">
        <fieldset>
            <legend> Ajouter un Auteur</legend>
            <label>Nom auteur :
                <input name="nomAuteur" type="text" size="18" value="">
            </label>
            <?php if (isset($erreurs['nomAuteur'])) echo '<div class="alert alert-danger">'.$erreurs['nomAuteur'].'</div>'; ?>

            <label>Prenom auteur :
                <input name="prenomAuteur" type="text" size="18" value="">
            </label>
            <?php if (isset($erreurs['prenomAuteur'])) echo '<div class="alert alert-danger">'.$erreurs['prenomAuteur'].'</div>'; ?>


            <input type="submit" name="AddAuteur" value ="Add">
        </fieldset>
    </div>
</form>

<?php include('v_foot.php') ?>
