<?php
// On démarre une session
session_start();

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('../../moteur/connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `laptop` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    
    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $produit = $query->fetch();
    // On vérifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cette unité centrale n'existe pas";
        header('Location: ../crudLaptop.php');
    }

    $actif = ($produit['actif'] == 0) ? 1 : 0;

    $sql = 'UPDATE `laptop` SET `actif`=:actif WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètres
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->bindValue(':actif', $actif, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();
    
    header('Location: ../crudLaptop.php');

}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: ../crudLaptop.php');
}

