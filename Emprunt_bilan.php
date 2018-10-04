<?php

include("connexion_bdd.php");
$ma_commande_SQL ="SELECT a.nomAdherent,a.idAdherent, o.titre, em.noExemplaire, em.dateEmprunt, em.dateRendu FROM Emprunt em 
INNER JOIN adherent a on em.idAdherent = a.idAdherent
inner join exemplaire e on em.noExemplaire = e.noExemplaire
inner join oeuvre o on e.noOeuvre = O.noOeuvre
WHERE DATEDIFF(dateRendu, DATE(now()) < 0
ORDER BY em.idAdherent ;";
$reponse = $bdd->query($ma_commande_SQL);
$donnees = $reponse->fetchAll();
function getDatetimeNow() {
    $tz_object = new DateTimeZone('Europe/Paris');
    //date_default_timezone_set('Brazil/East');

    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y-m-d');
}
?>

<div class="row">
    <a href="Emprunt_add.php">Ajouter un Emprunt</a>
    <table border="2">
        <caption>Recapitulatifs des Emprunts</caption>
        <?php if(isset($donnees[0])):?>
        <thead>
        <tr>
            <th>Nom adherent</th>
            <th>Titre Exemplaire</th>
            <th>Date emprunt</th>
            <th>Date Rendu</th>
            <th>ID exemplaire</th>
            <th>Retard</th>
            <th>Opérations possibles</th>
        </tr>
        <tbody>
        <?php foreach ($donnees as $value):?>
            <tr><td>
                    <?php echo $value['nomAdherent'];?>
                </td><td>
                    <?php echo $value['titre'];?>
                </td><td>
                    <?php echo $value['dateEmprunt'];?>
                </td><td>
                    <?php if (!($value['dateRendu']== 0000-00-00)){
                        echo $value['dateRendu'];}?>
                </td><td>
                    <?php echo $value['noExemplaire'];?>
                </td><td>
                    <?php
                    $dateButoire = date("Y-m-d", strtotime("+4 months", strtotime($value['dateEmprunt'])));
                    $date1=date_create(getDatetimeNow());
                    $date2=date_create($dateButoire);
                    $interval = date_diff($date1, $date2);
                    echo $interval->format('%R%a');
                    ?>
                </td><td>
                    <a href="Emprunt_edit.php?id=<?php echo $value['noExemplaire'];?>">Modifier</a>
                    <a href="Emprunt_delete.php?idAdherent=<?php echo $value['idAdherent'];?>&amp;noExemplaire=<?php echo $value['noExemplaire'];?>&amp;dateEmprunt=<?php echo $value['dateEmprunt'];?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tbody>
        <?php else:?>
            <tr>
                <td>Pas d'Emprunt dans la base de données</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
