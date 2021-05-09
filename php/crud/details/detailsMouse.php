<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../../moteur/connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `mouse` WHERE `id` = :id;';

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
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: ../crudMouse.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: ../crudMouse.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du matériel</title>
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Détails du matériel : <?= $resultat['produit'] ?></h1>
                <p>ID : <?= $resultat['id'] ?></p>
                <p>Date : <?= $resultat['date'] ?></p>
                <p>Marque : <?= $resultat['marque'] ?></p>
                <p>Modele : <?= $resultat['modele'] ?></p>
                <p>Etat : <?= $resultat['etat'] ?></p>
                <p><a href="../crudMouse.php">Retour</a> <a href="../edit/editMouse.php?id=<?= $resultat['id'] ?>">Modifier</a></p>
            </section>
        </div>
    </main>
</body>
</html>