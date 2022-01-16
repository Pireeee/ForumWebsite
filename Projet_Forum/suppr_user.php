<?php
include_once('header.php');
if (isset($_GET['user_id'])){
    //fonction qui supprime tout les commentaire, thread avant de supprimer l'utilisateur
    $id=$_GET['user_id'];
    $RQ2 = $bdd->prepare('DELETE FROM `coms` WHERE user_id=?');
    $RQ2 -> execute(array($id));
    $RQ = $bdd->prepare('DELETE FROM `threads` WHERE user_id=?');
    $RQ -> execute(array($id));
    $RQ2 = $bdd->prepare('DELETE FROM `forum_user` WHERE user_id=?');
    $RQ2 -> execute(array($id));
    header('Location:./account.php');
}
else header('Location:./account.php');
?>