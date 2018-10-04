<?php

include("connexion_bdd.php");

if (isset($_GET["id"]) AND is_numeric($_GET["id"])) {
    $id = htmlentities($_GET['id']);
    $ma_requete_sql = "SELECT *
                     FROM EXEMPLAIRE ex
                     WHERE noExemplaire=" . $id . ";";
    $reponse = $bdd->query($ma_requete_sql);
    $donnees = $reponse->fetch();

}

if (isset($_POST['etat']) AND isset($_POST['dateAchat']) AND isset($_POST['prix']) AND isset($_POST['etat'])) {
    $donnees['dateAchat'] = htmlentities($_POST['dateAchat']);
    $donnees['prix'] = htmlentities($_POST['prix']);
    $donnees['etat'] = htmlentities($_POST['etat']);


    $erreurs = array();

    if (!preg_match("/^[A-Za-z]{1,}/", $donnees['etat'])) $erreurs['etat'] = 'nom composé de 2 lettre minimum';
    if (!preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#", $donnees['dateAchat'], $matches))
        $erreurs['dateAchat'] = 'la date n\'est pas valide';

    else {
        if (!checkdate($matches[2], $matches[1], $matches[3]))
            $erreurs['dateAchat'] = 'la date n\'est pas valide';
        else {
            $donnees['dateAchat_us'] = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
            $donnees['dateAchat'] = $matches[1] . "/" . $matches[2] . "/" . $matches[3];
        }
    }

    if (!is_numeric($donnees['prix'])) $erreurs['prix'] = 'saisir un nombre';


    if (empty($erreurs)) {
        $ma_requete_sql = "UPDATE OEUVRE SET
        etat='" . $donnees['etat'] . "'
        , dateAchat='" . $donnees['dateAchat_us'] . "'
        , prix=" . $donnees['prix'] . "
        WHERE noExemplaire=" . $id . ";";
        var_dump($ma_requete_sql);
        $bdd->exec($ma_requete_sql);
        $path = "Location: Exemplaire_show.php?id=" . $id;
        header($path);
    }
}

?>

<?php include("v_head.php"); ?>

<?php include("v_nav.php"); ?>

    <form method="post" action="Exemplaire_edit.php?id=<?php echo $id?>">
        <div class="container">
            <fieldset>
                <legend>Modifier un Exemplaire</legend>
                <label>Etat :
                    <input name="etat" type="text"
                           value="<?php if (isset($donnees['etat'])) echo $donnees['etat']; ?>">
                    <?php if (isset($erreurs['etat'])) echo '<div class="alert alert-danger">' . $erreurs['etat'] . '</div>'; ?>
                </label>
                <label>Date de parution :
                    <input name="dateAchat" type="text" size="18"
                           value="<?php if (isset($donnees['dateAchat'])) echo $donnees['dateAchat']; ?>">
                </label>
                <?php if (isset($erreurs['dateAchat'])) echo '<div class="alert alert-danger">' . $erreurs['dateAchat'] . '</div>'; ?>

                <label>Prix :
                    <input name="prix" type="text" size="18"
                           value=" <?php if (isset($donnees['prix'])) echo $donnees['prix'] ?>">
                </label>
                <?php if (isset($erreurs['prix'])) echo '<div class="alert alert-danger">' . $erreurs['prix'] . '</div>'; ?>
                <input type="submit" name="ExemplaireEdit" value="Edit">
            </fieldset>
        </div>
    </form>

<?php include("v_foot.php"); ?>