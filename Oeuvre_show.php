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
?>

<?php include("v_head.php"); ?>
<?php include("v_nav.php"); ?>

<?php
$ma_commande_LOL = "SELECT oe.titre, oe.noOeuvre, oe.idAuteur, oe.dateParution
FROM OEUVRE oe
ORDER BY oe.titre;";
$ma_commande_SQL = "
SELECT AUTEUR.nomAuteur, OEUVRE.titre, OEUVRE.noOeuvre, OEUVRE.dateParution, AUTEUR.idAuteur
, COUNT(E1.noExemplaire) AS nbExemplaire
, COUNT(E2.noExemplaire) AS nombreDispo
FROM OEUVRE
JOIN AUTEUR ON AUTEUR.idAuteur = OEUVRE.idAuteur
LEFT JOIN EXEMPLAIRE E1 ON E1.noOeuvre = OEUVRE.noOeuvre
LEFT JOIN EXEMPLAIRE E2 ON E2.noExemplaire = E1.noExemplaire
  AND E2.noExemplaire NOT IN (SELECT EMPRUNT.noExemplaire FROM EMPRUNT WHERE EMPRUNT.dateRendu IS NULL)
GROUP BY OEUVRE.noOeuvre
ORDER BY AUTEUR.nomAuteur ASC, OEUVRE.titre ASC;
";
$reponse = $bdd->query($ma_commande_SQL);
$donnees = $reponse->fetchAll();

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

<div class="row">
    <a href="Oeuvre_add.php">Ajouter une oeuvre</a>
    <table border="2">
        <caption>Recapitulatifs des oeuvres</caption>
        <?php if(isset($donnees[0])): ?>
            <thead>
            <tr><th>titre de l'oeuvre</th><th>Nom auteur</th><th>date de parution</th><th>opération</th> </tr>
            </thead>
            <tbody>
            <?php foreach ($donnees as $value) :?>
                <tr><td>
                        <?php echo $value['titre']; ?>
                    </td>
                    <td>
                        <?php echo $value['nomAuteur']; ?>
                    </td>
                    <td>
                        <?php echo $value['dateParution']; ?>
                    </td>
                    <td>
                        <a href="Oeuvre_edit.php?id=<?=$value['noOeuvre']; ?>">modifier</a>
                        <a href="Oeuvre_delete.php?id=<?=$value['noOeuvre']; ?>">supprimer</a>
                        <a href="Exemplaire_show.php?id=<?=$value['noOeuvre']; ?>">Exemplaire</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        <?php else: ?>
            <tr>
                <td>Pas de'oeuvre dans la base de données</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<?php include("v_foot.php"); ?>