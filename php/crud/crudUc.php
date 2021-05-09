<?php
session_start();
require_once('../moteur/connect.php');

$sql = 'SELECT * FROM uc ORDER BY id DESC LIMIT 0,9';

$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('../moteur/close.php');
?>

<html>
<head>

    <title> UC </title>
    <link rel="icon" type="image/bmp" href="../../img/crud.bmp"/>
    <link rel="stylesheet" type="text/css" href="../../css/main/crud.css">

</head>
<body>

    <aside>
    <a href="../forms/formUc.php"><img src="../../img/uc.png" alt="retour à l'ajout d'Uc"></a>
    <a href="../home.php"><img src="../../img/home.svg" alt="Revenir à l'accueil"></a>
    <a href="crudUc.php"><img src="../../img/crud.svg" alt="Modifier/Ajouter par lot"></a>
    <a href="../stat/statUc.php"><img src="../../img/stat.svg" alt="Consulter les statistiques "></a>
    </aside>

<div id="main">
  <table class="container">

        <?php if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";} ?>
        <?php if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";} ?>

    <thead id="content">
    <th class="title1">ID</th>
    <th class="title2">DATE</th>
    <th class="title3">SERIAL</th>
    <th class="title4">MARQUE</th>
    <th class="title5">MODELE</th>
    <th class="title6">ETAT</th>
    <th class="title7">ACTION</th>
    </thead>

    <tbody>

        <?php foreach($result as $resultat){ ?>

    <tr id="content">
    <td class="req1">
    <?= $resultat['id'] ?></td>
    <td class="req2">
    <?= $resultat['date'] ?></td>
    <td class="req3">
    <?= $resultat['serial'] ?></td>
    <td class="req4">
    <?= $resultat['marque'] ?></td>
    <td class="req5">
    <?= $resultat['modele'] ?></td>
    <td class="req6">
    <?= $resultat['etat'] ?></td>
    <td class="req7">

    <a href="add/addUc.php?id=<?= $resultat['id'] ?>"><button id="new"></button></a>
    <a href="edit/editUc.php?id=<?= $resultat['id'] ?>"><button id="edit"></button></a>
    <a href="delete/deleteUc.php?id=<?= $resultat['id'] ?>"><button id="del"></button></a>
    
    </td>
    </tr>

        <?php } ?>
        
    </tbody>
  <table>
</div>

</body>
</html>