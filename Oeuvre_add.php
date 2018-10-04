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
if(isset($_POST["titre"]) AND isset($_POST["dateParution"]) AND isset($_POST["idAuteur"]))
{
    $donnees['titre']=$_POST['titre'];
    $titre = $donnees['titre'];
    $donnees['dateParution']=htmlentities($_POST['dateParution']);
    $donnees['idAuteur']=htmlentities($_POST['idAuteur']);

    $erreurs=array();

    if (! preg_match("/^[A-Za-z]{2,}/", $donnees['titre'])) $erreurs['titre']='nom composé de 2 lettres minimum';
    if (! preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#", $donnees['dateParution'],$matches))
        $erreurs['dateParution']='la date doit etre au format JJ/MM/AAAA';
    else {
        if (!checkdate($matches[2], $matches[1], $matches[3]))
            $erreurs['dateParution'] = 'la date n\'est pas valide';
        else {
            $donnees['dateParution_us'] = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
            //$donnees['dateParution'] = $matches[1] . "/" . $matches[2] . "/" . $matches[3];
        }
    }

    if (! is_numeric($donnees['idAuteur'])) $erreurs['idAuteur']='saisir une valeur ID';


    if (empty($erreurs)){
        $donnees['titre']=$bdd->quote($donnees['titre']);

        $ma_requete_sql="INSERT INTO OEUVRE (noOeuvre,titre,dateParution,idAuteur) VALUES
                    (NULL,".$donnees['titre'].",'".$donnees['dateParution_us']."',".$donnees['idAuteur'].");";
       var_dump($ma_requete_sql);
        $bdd->exec($ma_requete_sql);
        header("Location: Oeuvre_show.php");
    }
    else{
        $message='il y a des erreure => réafficher la vue (formulaire avec les erreurs)';
    }
}
else{
    $donnees['dateParution']=date('d/m/y');
}

$ma_requete_sql="SELECT idAuteur,nomAuteur FROM AUTEUR ORDER BY nomAuteur;";
$reponse = $bdd->query($ma_requete_sql);
$donneesAuteur = $reponse->fetchAll();





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

<form method="post" action="Oeuvre_add.php">
    <div class="container">
        <fieldset>
            <legend> Ajouter une Oeuvre</legend>
            <label>Titre :
                <input name="titre" type="text" size="18" value="<?php if (isset($donnees['titre'])) echo $donnees['titre']; ?>">
            </label>
            <?php if (isset($erreurs['titre'])) echo '<div class="alert alert-danger">'.$erreurs['titre'].'</div>'; ?>

            <label>Date de parution :
                <input name="dateParution" type="text" size="18" value="<?php if (isset($donnees['dateParution'])) echo $donnees['dateParution']; ?>">
            </label>
            <?php if (isset($erreurs['dateParution'])) echo '<div class="alert alert-danger">'.$erreurs['dateParution'].'</div>'; ?>

            <label>Auteur :
                <select name="idAuteur">
                    <?php if (isset($donnees['idAuteur']) or $donnees['idAuteur']==""): ?>
                    <option value="">Saisir une valeur</option>
                    <?php endif; ?>
                    <?php foreach ($donneesAuteur as $auteur) : ?>
                        <option value="<?php echo $auteur['idAuteur']; ?>"
                            <?php if (isset($donnees['idAuteur']) and $donnees['idAuteur'] == $auteur['idAuteur']) echo "selected";?>
                        >
                            <?php echo $auteur['nomAuteur']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php if (isset($erreurs['idAuteur'])) echo '<div class="alert alert-danger">'.$erreurs['idAuteur'].'</div>'; ?>
            <input type="submit" name="AddOeuvre" value ="Ajouter">
        </fieldset>
    </div>
</form>

<?php include('v_foot.php') ?>
