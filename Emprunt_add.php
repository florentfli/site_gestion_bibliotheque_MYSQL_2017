<?php
include("connexion_bdd.php");
$ma_commande2_SQL ="SELECT a.idAdherent, a.nomAdherent FROM adherent a
            GROUP BY a.idAdherent;";
$reponse2 = $bdd->query($ma_commande2_SQL);
$donnees2 = $reponse2->fetchAll();

?>
<?php include("v_head.php"); ?>
<?php include("v_nav.php"); ?>
<form method="post" action="Emprunt_add.php">
    <div class="row">
        <fieldset>
            <legend>Ajouter une Emprunt</legend>
            <label>Nom de l'adhérent
                <select name="nomAdherent">
                    <?php if (!(isset($_POST['nomAdherent']))){
                        echo "selected";}?>></option>
                    <?php foreach ($donnees2 as $value): ?>
                        <option <?php if (isset($_POST['nomAdherent'])){
                            if ($_POST['nomAdherent'] == $value["nomAdherent"]){
                                echo "selected ";}
                        }?>value="<?php echo $value["nomAdherent"]; ?>" ><?php echo $value["nomAdherent"]; ?></option>
                    <?php endforeach; ?>

                </select>
            </label>

            <input type="submit" name="ValiderAdherent" value="OK"/>
        </fieldset>
        <?php if(isset($_POST["nomAdherent"])){
        $ma_commande3_SQL ="SELECT e.noExemplaire, o.titre FROM exemplaire e
            INNER JOIN oeuvre o on e.noOeuvre = o.noOeuvre
            INNER JOIN emprunt e2 on e.noExemplaire = e2.noExemplaire
            WHERE e2.dateRendu != 0000-00-00
            GROUP BY noExemplaire;";
        $reponse3 = $bdd->query($ma_commande3_SQL);
        $donnees3 = $reponse2->fetchAll();?>
        <fieldset>
            <label>Exemplaire d'une oeuvre
                <select name="noExemplaire">
                    <?php if (!(isset($_POST['noExemplaire']))){
                        echo "selected";}?>></option>
                    <?php foreach ($donnees3 as $value):?>
                        <option <?php if (isset($_POST['noExemplaire'])){
                            if ($_POST['noExemplaire'] == $value["noExemplaire"]){
                                echo "selected ";}
                        }?>value="<?php echo $value["noExemplaire"]; ?>" ><?php echo $value["titre"]; ?></option>
                    <?php endforeach; ?>

                </select>
            </label>

            <input type="submit" name="AjouterOeuvre" value="Ajouter"/>
        </fieldset><?php
        $nomAdherent = $_POST["nomAdherent"];
        $ma_commande_SQL ="SELECT a.nomAdherent,a.idAdherent, o.titre, em.noExemplaire, em.dateEmprunt, em.dateRendu FROM Emprunt em 
                            INNER JOIN adherent a on em.idAdherent = a.idAdherent
                            inner join exemplaire e on em.noExemplaire = e.noExemplaire
                            inner join oeuvre o on e.noOeuvre = O.noOeuvre
                            WHERE a.nomAdherent = '".$nomAdherent."';";
        $reponse = $bdd->query($ma_commande_SQL);
        $donnees = $reponse->fetchAll();
        ?>
        <table border="2">
            <caption>Recapitulatifs des Emprunts de <?php echo $_POST["nomAdherent"]?></caption>

            <thead>
            <tr>
                <th>Titre Exemplaire</th>
                <th>Date emprunt</th>
                <th>Date Rendu</th>
                <th>ID exemplaire</th>

            </tr>
            <tbody>
            <?php foreach ($donnees as $value):?>
                <tr><td>
                        <?php echo $value['titre'];?>
                    </td><td>
                        <?php echo $value['dateEmprunt'];?>
                    </td><td>
                        <?php if (!($value['dateRendu']== 0000-00-00)){
                            echo $value['dateRendu'];}?>
                    </td><td>
                        <?php echo $value['noExemplaire'];?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <?php
            }?>
    </div>
</form>

