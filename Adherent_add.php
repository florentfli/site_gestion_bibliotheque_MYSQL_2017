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
if(isset($_POST["nomAdherent"]) AND isset($_POST["adresse"]) AND isset($_POST["datePaiement"]))
{

    $donnees['nomAdherent']=htmlentities($_POST['nomAdherent']);
    $donnees['adresse']=htmlentities($_POST['adresse']);
    $donnees['datePaiement']=htmlentities($_POST['datePaiement']);

    $erreurs=array();

    if (! preg_match("/^[A-Za-z]{2,}/", $donnees['nomAdherent'])) $erreurs['nomAdherent']='nom composé de 2 lettres minimum';
    if (! preg_match("/^[A-Za-z]{2,}/", $donnees['adresse'])) $erreurs['adresse']='adresse de 2 lettres minimum';
    if (! preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#", $donnees['datePaiement'],$matches))
        $erreurs['datePaiement']='la date doit etre au format JJ/MM/AAAA';
    else {
        if (!checkdate($matches[2], $matches[1], $matches[3]))
            $erreurs['datePaiement'] = 'la date doit etre au format JJ/MM/AAAA';
        else {
            $donnees['datePaiement_us'] = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
            $donnees['datePaiement'] = $matches[1] . "/" . $matches[2] . "/" . $matches[3];
        }
    }
    if (empty($erreurs)){
        $donnees['nomAdherent']=$bdd->quote($donnees['nomAdherent']);

        $ma_requete_sql="INSERT INTO ADHERENT (idAdherent,nomAdherent,adresse,datePaiement) VALUES
                    (NULL,".$donnees['nomAdherent'].",'".$donnees['adresse']."','".$donnees['datePaiement_us']."');";
        var_dump($ma_requete_sql);
        $bdd->exec($ma_requete_sql);
        header("Location: Adherent_show.php");
    }
}


function isNotValidDateFR($maDate)
{
    if (preg_match("/^([0-9]{1,2})[-/]([0-9]{1,2})[-/]([0-9]{4})$/", $maDate, $matches))                                              {
        if (checkdate($matches[2], $matches[1], $matches[3])) {
            return false;
        }
        else
        {
            return "Date non correcte, qui n'existe pas : ".$matches[1]."-".$matches[2]."-".$matches[3];
        }
    }
    else
    {
        return "Format de date non correcte : JJ/MM/AAAA";
    }
}

function convert_date_fr_us($maDate)
{
    if (preg_match("/^([0-9]{1,2})[-/]([0-9]{1,2})[-/]([0-9]{4})$/", $maDate, $matches))
        return $matches[3] . "-" . $matches[2] . "-" . $matches[1];
    else
        return false;

}

function convert_date_us_fr($maDate)
{
    if (preg_match("/^([0-9]{4})[-/]([0-9]{1,2})[-/]([0-9]{1,2})$/", $maDate, $matches))
        return $matches[3] . "/" . $matches[2] . "/" . $matches[1];
    else
        return false;

}
?>

<?php include("v_head.php"); ?>

<?php include("v_nav.php"); ?>

<form method="post" action="Adherent_add.php">
    <div class="container">
        <fieldset>
            <legend> Ajouter un Adherent</legend>
            <label>Nom adherent :
                <input name="nomAdherent" type="text" size="18" value="<?php if (isset($donnees["nomAdherent"]))echo $donnees["nomAdherent"] ?>">
            </label>
            <?php if (isset($erreurs['nomAdherent'])) echo '<div class="alert alert-danger">'.$erreurs['nomAuteur'].'</div>'; ?>

            <label>Adresse adherent :
                <input name="adresse" type="text" size="18" value="<?php if (isset($donnees["adresse"]))echo $donnees["adresse"] ?>">
            </label>
            <?php if (isset($erreurs['adresse'])) echo '<div class="alert alert-danger">'.$erreurs['adresse'].'</div>'; ?>

            <label>Date de paiement :
                <input name="datePaiement" type="text" size="18" value="<?php if (isset($donnees['datePaiement'])) echo $donnees['datePaiement']; ?>">
            </label>
            <?php if (isset($erreurs['datePaiement'])) echo '<div class="alert alert-danger">'.$erreurs['datePaiement'].'</div>'; ?>


            <input type="submit" name="AddAdherent" value ="Add">
        </fieldset>
    </div>
</form>

<?php include('v_foot.php') ?>
