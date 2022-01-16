<?php
include_once('header.php');
    if (isset($_GET['id'])){
         //fonction qui supprime tout les commentaire
        $id=$_GET['id'];
        $RQ2 = $bdd->prepare('DELETE FROM `coms` WHERE com_id=?');
        $RQ2 -> execute(array($id));
        header('Location:./thread.php?thread_id='.$_GET['thread_id']);
    }
?>
