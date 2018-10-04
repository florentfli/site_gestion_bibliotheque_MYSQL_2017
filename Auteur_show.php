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
$ma_commande_SQL = "SELECT oe.idAuteur, oe.nomAuteur, oe.prenomAuteur
FROM AUTEUR oe
ORDER BY oe.idAuteur;";
$reponse = $bdd->query($ma_commande_SQL);
$donnees = $reponse->fetchAll();
?>

    <div class="row">
        <a href="Auteur_add.php">Ajouter un auteur</a>
        <table border="2">
            <caption>Recapitulatifs des Auteurs</caption>
            <?php if(isset($donnees[0])): ?>
                <thead>
                <tr><th>ID auteur</th><th>Nom auteur</th><th>Prenom auteur</th><th>Action...</th></tr>
                </thead>
                <tbody>
                <?php foreach ($donnees as $value) :?>
                    <tr><td>
                            <?php echo $value['idAuteur']; ?>
                        </td>
                        <td>
                            <?php echo $value['nomAuteur']; ?>
                        </td>
                        <td>
                            <?php echo $value['prenomAuteur']; ?>
                        </td>
                        <td>
                            <a href="Auteur_edit.php?id=<?=$value['idAuteur']; ?>">modifier</a>
                            <a href="Auteur_delete.php?id=<?=$value['idAuteur']; ?>">supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            <?php else: ?>
                <tr>
                    <td>Pas d'auteur dans la base de données</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

<?php include("v_foot.php"); ?>