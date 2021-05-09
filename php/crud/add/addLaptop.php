<?php
// On démarre une session
session_start();

if($_POST){
    if(isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['serial']) && !empty($_POST['serial'])
    && isset($_POST['marque']) && !empty($_POST['marque'])
    && isset($_POST['modele']) && !empty($_POST['modele'])
    && isset($_POST['etat']) && !empty($_POST['etat'])){
        // On inclut la connexion à la base
        require_once('../../moteur/connect.php');

        // On nettoie les données envoyées
        $date = strip_tags($_POST['date']);
        $serial = strip_tags($_POST['serial']);
        $marque = strip_tags($_POST['marque']);
        $modele = strip_tags($_POST['modele']);
        $etat = strip_tags($_POST['etat']);

        $sql = 'INSERT INTO `laptop` (`date`, `serial`, `marque`, `modele`, `etat`) VALUES (:produit, :prix, :nombre);';

        $query = $db->prepare($sql);

        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->bindValue(':serial', $serial, PDO::PARAM_STR);
        $query->bindValue(':marque', $marque, PDO::PARAM_INT);
        $query->bindValue(':modele', $modele, PDO::PARAM_INT);
        $query->bindValue(':etat', $etat, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Produit ajouté";
        require_once('../../moteur/close.php');

        header('Location: ../crudLaptop.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title> Ajouter Laptop </title>
    <link rel="icon" type="image/bmp" href="../../../img/laptop.bmp"/>
    <link rel="stylesheet" type="text/css" href="../../../css/form.css">
</head>
<body>
<aside>
    <a href="../formLaptop.php"><img src="../../../img/Laptop.png" alt="Ajouter une unité centrale"></a>
    <a href="../../home.php"><img src="../../../img/home.svg" alt="Revenir à l'accueil"></a>
    <a href="../../stat/statLaptop.php"><img src="../../../img/stat.svg" alt="consulter les statistiques"></a>
    </aside>

                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                 <form method="POST" action="../../moteur/receiveForm/receiveFormLaptop.php"><hr/>
    <input class="col-2" type="date" name="date" value="<?php echo date('Y-m-d'); ?>" placeholder=""/><hr/>
    <input class="col-14" type="text" name="serial" placeholder="Numéro de série de l'Laptop" required pattern="^[A-Z *|* 0-9]{8,14}$" onBlur="this.value = this.value.toUpperCase()" onblur="this.placeholder= 'Vous n\'avez pas terminé la saisie'" required/><hr/>


    <div class="formfield-select">
<label for="la_marque">Marque</label>
<div class="formfield-select--container">
<select id="la_marque" name="marque">
<optgroup label="Marque">
        <option value="HP">HP</option>
        <option value="LENOVO">LENOVO</option>
        <option value="DELL">DELL</option>
        <option value="SAMSUNG">SAMSUNG</option>
        <option value="PHILIPS">PHILIPS</option>
</optgroup>
</select>
</div>
</div>

<div class="formfield-select">
<label for="le_modele">Modèle</label>
<div class="formfield-select--container">
<select id="le_modele" name="modele">
<optgroup label="Modèle">
        <option value="LA1905WG">LA1905WG</option>
        <option value="1907FPT">1907FPT</option>
        <option value="S19A">S19A</option>
        <option value="AU6A">AU6A</option>
</optgroup>
</select>
</div>
</div>

<div class="formfield-select">
<label for="mon_select">Etat du matériel</label>
<div class="formfield-select--container">
<select id="mon_select" name="etat">
<optgroup label="ETAT">
    <option value="BON">BON</option>
    <option value="MAUVAIS">MAUVAIS</option>
</optgroup>
</select>
</div>
</div>
</br>
<hr/>


    <input class="button3" type="submit" value="VALIDER"/><hr/>
    <input class="button4" type="reset" value="ANNULER"/><hr/>
    </form>

</body>
</html>