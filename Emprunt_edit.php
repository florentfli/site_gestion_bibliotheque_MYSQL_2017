<?php
include("connexion_bdd.php");
if (isset($_GET["id"]) AND is_numeric($_GET["id"])) {
    $id = htmlentities($_GET['id']);
    $ma_requete_sql = "SELECT idAdherent, noExemplaire, dateEmprunt, dateRendu
    FROM Emprunt 
    WHERE noExemplaire = " . $id . ";";
    $reponse = $bdd->query($ma_requete_sql);
    $donnees = $reponse->fetch();
}
if (isset($_GET["id"]) AND isset($_POST['idAdherent']) AND isset($_POST['noExemplaire']) AND isset($_POST['dateEmprunt'])) {
    $donnees["idAdherent"] = $_POST["idAdherent"];
    $donnees["noExemplaire"] = htmlentities($_POST["noExemplaire"]);
    $donnees["dateEmprunt"] = htmlentities($_POST["dateEmprunt"]);
    $id = htmlentities($_GET['id']);
    $erreurs = array();

    if (!is_numeric($donnees["idAdherent"])) $erreurs['idAdherent'] = 'id doit etre un nombre';
    if (!preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#", $donnees['dateEmprunt'], $matches))
        $erreurs['dateEmprunt'] = 'la date n\'est pas valide (JJ/MM/AAAA)';
    else {
        if (!checkdate($matches[2], $matches[1], $matches[3]))
            $erreurs['dateEmprunt'] = 'la date n\'est pas valide (JJ/MM/AAAA)';
        else {
            $donnees['dateEmprunt_us'] = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
            $donnees['dateEmprunt'] = $matches[1] . "/" . $matches[2] . "/" . $matches[3];
        }
    }
    if (isset($_POST['dateRendu'])) {
        $donnees['dateRendu'] = $_POST['dateRendu'];
        if (!preg_match("#^([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#", $donnees['dateEmprunt'], $matches))
            $erreurs['dateRendu'] = 'la date n\'est pas valide (JJ/MM/AAAA)';

        else {
            if (!checkdate($matches[2], $matches[1], $matches[3]))
                $erreurs['dateRendu'] = 'la date n\'est pas valide (JJ/MM/AAAA)';
            else {
                $donnees['dateRendu_us'] = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
                $donnees['dateRendu'] = $matches[1] . "/" . $matches[2] . "/" . $matches[3];
            }
        }
    }

    if (empty($erreurs)) {
        $ma_requete_sql = "UPDATE Emprunt SET 
        noExemplaire='" . $donnees['noExemplaire'] . "',
        dateEmprunt='" . $donnees['dateEmprunt'] . "',
        dateRendu='0000-00-00'
        WHERE noExemplaire = " . $donnees['noExemplaire'] . ";";
        if (isset($_POST["dateRendu"])) {
            $ma_requete_sql = "UPDATE Emprunt SET 
            noExemplaire='" . $donnees['noExemplaire'] . "',
            dateEmprunt='" . $donnees['dateEmprunt_us'] . "',
            dateRendu = '" . $donnees['dateRendu_us'] . "'
            WHERE noExemplaire = " . $donnees['noExemplaire'] . ";";
            var_dump($ma_requete_sql);
            $bdd->exec($ma_requete_sql);
            header("Location: Emprunt_show.php");
        } else {
            var_dump($ma_requete_sql);
            $bdd->exec($ma_requete_sql);
            header("Location: Emprunt_show.php");
        }
    }
} ?>
<form method="post" action="Emprunt_edit.php?id=<?php if (isset($_GET["id"])) echo $_GET["id"] ?>">
    <div class="row">
        <fieldset>
            <legend>Modifier une Emprunt</legend>
            <label>ID de l'adhérent
                <input name="idAdherent" type="text" size="18"
                       value="<?php if (isset($donnees['idAdherent'])) echo $donnees['idAdherent']; ?>" required/>
            </label>
            <?php if (isset($erreurs['idAdherent'])) echo '<div class="alert alert-danger">' . $erreurs['idAdherent'] . '</div>'; ?>
            <label>Numéro de l'exemplaire
                <input name="noExemplaire" type="text" size="18"
                       value="<?php if (isset($donnees['noExemplaire'])) echo $donnees['noExemplaire']; ?>"/>
            </label>
            <?php if (isset($erreurs['noExemplaire'])) echo '<div class="alert alert-danger">' . $erreurs['noExemplaire'] . '</div>'; ?>
            <label>Date de rendu
                <input name="dateRendu" type="text" size="18"
                       value="<?php if (isset($donnees['dateRendu'])) echo $donnees['dateRendu']; ?>"/>
            </label>
            <?php if (isset($erreurs['dateRendu'])) echo '<div class="alert alert-danger">' . $erreurs['dateRendu'] . '</div>'; ?>
            <label>Date de l'emprunt
                <input name="dateEmprunt" type="text" size="18"
                       value="<?php if (isset($donnees['dateEmprunt'])) echo $donnees['dateEmprunt']; ?>"/>
            </label>
            <?php if (isset($erreurs['dateEmprunt'])) echo '<div class="alert alert-danger">' . $erreurs['dateEmprunt'] . '</div>'; ?>
            <input type="submit" name="EditEmprunt" value="Modifier un Emprunt"/>
        </fieldset>
    </div>
</form>
