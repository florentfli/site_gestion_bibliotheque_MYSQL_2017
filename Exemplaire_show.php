<?php

include("connexion_bdd.php");

if(isset($_GET["id"]) AND is_numeric($_GET["id"])){
    $id=htmlentities($_GET['id']);
    $ma_commande_SQL1 ="SELECT titre FROM Oeuvre 
    WHERE noOeuvre = ".$id.";";
    $reponse1 = $bdd->query($ma_commande_SQL1);
    $donnees1 = $reponse1->fetchAll();

    $ma_commande_SQL ="SELECT e.noExemplaire, e.etat, e.dateAchat, e.prix 
FROM Exemplaire e 
WHERE e.noOeuvre = ".$id."
ORDER BY e.noExemplaire;";
    $reponse = $bdd->query($ma_commande_SQL);
    $donnees = $reponse->fetchAll();

}else{echo "pas d'id";}

?>

<?php include("v_head.php"); ?>
<?php include("v_nav.php"); ?>

<div class="row">
    <a href="Exemplaire_add.php?id=<?php echo $id?>">Ajouter une Exemplaire de cette oeuvre</a>
    <table border="2">
        <caption>Recapitulatifs des Exemplaires de l'oeuvre <?php echo $donnees1[0]["titre"];?> </caption>
        <?php if(isset($donnees[0])):?>
        <thead>
        <tr>
            <th>No exemplaire</th>
            <th>Etat</th>
            <th>Date d'achat</th>
            <th>Prix</th>
            <th>Opérations</th>
        </tr>
        <tbody>
        <?php foreach ($donnees as $value):?>
            <tr><td>
                    <?php echo $value['noExemplaire'];?>
                </td><td>
                    <?php echo $value['etat'];?>
                </td><td>
                    <?php echo $value['dateAchat'];?>
                </td><td>
                    <?php echo $value['prix'];?>
                </td><td>
                    <a href="Exemplaire_edit.php?id=<?php echo $value['noExemplaire'];?>">Modifier</a>
                    <a href="Exemplaire_delete.php?id=<?php echo $value['noExemplaire'];?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <tbody>
        <?php else:?>
            <tr>
                <td>Pas d'Exemplaire dans la base de données</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
