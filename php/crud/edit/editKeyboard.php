
<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['serial']) && !empty($_POST['serial'])
    && isset($_POST['marque']) && !empty($_POST['marque'])
    && isset($_POST['modele']) && !empty($_POST['modele'])
    && isset($_POST['etat']) && !empty($_POST['etat'])){
        // On inclut la connexion à la base
        require_once('../../moteur/connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $date = strip_tags($_POST['date']);
        $serial = strip_tags($_POST['serial']);
        $marque = strip_tags($_POST['marque']);
        $modele = strip_tags($_POST['modele']);
        $etat = strip_tags($_POST['etat']);

        $sql = 'UPDATE `keyboard` SET `date`=:date, `serial`=:serial, `marque`=:marque, `modele`=:modele, `etat`=:etat, WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->bindValue(':serial', $serial, PDO::PARAM_STR);
        $query->bindValue(':marque', $marque, PDO::PARAM_STR);
        $query->bindValue(':modele', $modele, PDO::PARAM_STR);
        $query->bindValue(':etat', $etat, PDO::PARAM_STR);

        $query->execute();

        $_SESSION['message'] = "Entrée modifiée";
        require_once('../../moteur/close.php');

        header('Location: ../crudKeyboard.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../../moteur/connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `keyboard` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $resultat = $query->fetch();

    // On vérifie si le produit existe
    if(!$resultat){
        $_SESSION['erreur'] = "Cet écran n'existe pas";
        header('Location: ../crudKeyboard.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: ../crudKeyboard.php');
}

?>

<html>
<head>

    <title>Modifier une entrée</title>
    <link rel="icon" type="image/bmp" href="../../../img/crud.bmp"/>
    <link rel="stylesheet" type="text/css" href="../../../css/form.css">

</head>
<body>

    <aside>
    <a href="editKeyboard.php"><img src="../../../img/edit.png" alt="retour à l'ajout d'écran"></a>
    <a href="../../home.php"><img src="../../../img/home.svg" alt="Revenir à l'accueil"></a>
    <a href="../crudKeyboard.php"><img src="../../../img/crud.svg" alt="Modifier/Ajouter par lot"></a>
    <a id="print" href="javascript:window.print()"><img src="../../../img/pdf.svg" alt="Enregistrer, imprimer en pdf"></a>
    </aside>
   
    <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>

    <form method="post" action="../../moteur/receiveForm/receiveFormKeyboard.php"><hr/>
    <input type="date" id="date" name="date" class="form-control" value="<?= $resultat['date']?>"><hr/>
    <input type="text" id="serial" name="serial" class="form-control" value="<?= $resultat['serial']?>" onkeyup="this.value = this.value.toUpperCase();"/><hr/>
    <input type="text" id="marque" name="marque" class="form-control" value="<?= $resultat['marque']?>" onkeyup="this.value = this.value.toUpperCase();"/><hr/>
    <input type="text" id="modele" name="modele" class="form-control" value="<?= $resultat['modele']?>" onkeyup="this.value = this.value.toUpperCase();"/><hr/>
    <input type="text" id="etat" name="etat" class="form-control" value="<?= $resultat['etat']?>" onkeyup="this.value = this.value.toUpperCase();/"><hr/>
    <input type="hidden" name="id" value="<?= $resultat['id']?>">
    <input class="button3" type="submit" value="VALIDER"/><hr/>
    <input class="button4" type="reset" value="ANNULER"/><hr/>
    </form>

</body>
</html>