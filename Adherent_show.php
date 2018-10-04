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
$ma_commande_SQL = "SELECT oe.nomAdherent, oe.idAdherent, oe.adresse, oe.datePaiement
FROM ADHERENT oe
ORDER BY oe.nomAdherent;";
$reponse = $bdd->query($ma_commande_SQL);
$donnees = $reponse->fetchAll();
?>

    <div class="row">
        <a href="Adherent_add.php">Ajouter un adhérent</a>
        <table border="2">
            <caption>Recapitulatifs des adhérents</caption>
            <?php if(isset($donnees[0])): ?>
                <thead>
                <tr><th>ID adhérent</th><th>Nom adhérent</th><th>Adresse adhérent</th><th>Date de paiement</th><th>Opération..</th> </tr>
                </thead>
                <tbody>
                <?php foreach ($donnees as $value) :?>
                    <tr><td>
                            <?php echo $value['idAdherent']; ?>
                        </td>
                        <td>
                            <?php echo $value['nomAdherent']; ?>
                        </td>
                        <td>
                            <?php echo $value['adresse']; ?>
                        </td>
                        <td>
                            <?php echo $value['datePaiement']; ?>
                        </td>
                        <td>
                            <a href="Adherent_edit.php?id=<?=$value['idAdherent']; ?>">modifier</a>
                            <a href="Adherent_delete.php?id=<?=$value['idAdherent']; ?>">supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            <?php else: ?>
                <tr>
                    <td>Pas d'adherent dans la base de données</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

<?php include("v_foot.php"); ?>