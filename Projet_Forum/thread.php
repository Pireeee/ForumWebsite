<!DOCTYPE HTML>
<?php
session_start();
include_once('header.php');

if (isset($_POST['update'])) { //modification du texte
    $thread_text = $_POST['thread_text'];
    if (!empty($thread_text)){//verifie si pas vide
        $RQ = $bdd-> prepare("UPDATE `threads` SET `thread_text`=? WHERE thread_id=?");
        $RQ -> execute(array($thread_text,$_GET['thread_id']));
    }
}
if (isset($_POST['suppr'])){ //Suppression du thread
    //supprime tout les commentaire associé au thread avant le thread lui même
    $RQ2 = $bdd->prepare('DELETE FROM `coms` WHERE thread_id=?');
    $RQ2 -> execute(array($_GET['thread_id']));
    $RQ = $bdd->prepare('DELETE FROM `threads` WHERE thread_id=?');
    $RQ -> execute(array($_GET['thread_id']));
    header('Location: ./');
}

//recuperation du texte depuis la base de donnée
$threadRS = $bdd->prepare('SELECT * FROM threads WHERE thread_id = :thread_id ');
$threadRS->execute(array( 'thread_id' => $_GET['thread_id']));
$thread = $threadRS -> fetch();

//recuperation de l'utilisateur depuis la base de donnée
$userRS = $bdd->prepare('SELECT user_name FROM forum_user WHERE user_id=? ');
$userRS ->execute(array($thread["user_id"]));
$user = $userRS ->fetch();

//recuperation des commentaires depuis la base de donnée
$comRS=$bdd->prepare('SELECT * FROM coms WHERE thread_id=?');
$comRS -> execute(array($_GET['thread_id']));
$coms = $comRS->fetchAll();


if (isset($_POST['commenter'])){ // création de commentaire
    $com_title = htmlspecialchars($_POST['com_title']);//les htmlspecialchars
    $com_text = htmlspecialchars($_POST['com_text']);
    if (!empty($com_text) && !empty($com_title)){ //si pas vide rentre les information dans la base de donnée
        $RQ = $bdd->prepare('INSERT INTO `coms`(`thread_id`, `user_id`, `com_title`, `com_text`, `com_date`) VALUES (?,?,?,?,NOW())');
        $RQ -> execute(array($_GET['thread_id'],$_SESSION['user_id'],$com_title,$com_text));
        header('Location:./thread.php?thread_id='.$_GET['thread_id']);
    }
}
?>
<div class="container">
    <div class="thread">                        <!-- SECTION THREAD -->
        <br><br><br>
        <h2><?php echo $thread['thread_title'];?></h2> <!-- Titre -->
        <h4>Par <?php echo $user['user_name'];?> </h4> <!-- Nom -->
        <form method="post">         <!--je fais des textarea pour pouvoir les modifier plus tard avec la fonction modifier() -->
            <textarea   
                    id="modify"
                    required
                    name="thread_text"
                    maxlength="2500"
                    class='modifiable'
                    rows='7'
                    cols="150"
                    readonly 
            ><?php echo $thread['thread_text'];?> 
            </textarea><br>
            <div class="modify2">Le texte est modifiable</div><!-- texte -->
            <input type="submit" name="update" class="modify2" > <?php
            if (isset($_SESSION['user_id'])){
                if ($thread['user_id'] == $_SESSION['user_id']){ //fais apparaitre le bouton modifier si tu as créer le thread
                    echo '<button onclick="modifier(event);">Modifier</button>';
                }
                //fais apparaitre le bouton si tu as créer le thread ou tu es admin
                if ($_SESSION['user_rank'] != "user" || $thread['user_id'] == $_SESSION['user_id']){ 
                    echo '<input type="submit" name="suppr" value="Supprimer">';
                }
            }
            ?>
        </form>
    </div>
    <div class="coms">                      <!-- SECTION COMENTAIRE -->
        <h2>Commentaires</h2>
        <div class="com">
            <?php
                foreach ($coms as $com){ //fais apparaitre tout les commentaires
                    //recupere le nom de l'utilisateur qui a commenté
                    $usercomRS = $bdd->prepare('SELECT user_name FROM forum_user WHERE user_id=? ');
                    $usercomRS ->execute(array($com["user_id"]));
                    $usercom = $usercomRS ->fetch();
                    echo '<h4>'.$com['com_title'].'</h4>';
                    echo '<textarea id="modify" required name="thread_text" maxlength="2500" class="modifiable" rows="7" cols="150" readonly>'.$com["com_text"].'</textarea><br>';
                    if (isset($_SESSION['user_id'])){ 
                        //fais apparaitre le bouton Modifier si admin ou si tu es l'user qui a créer le Thread
                        if ($_SESSION['user_rank'] != "user" || $thread['user_id'] == $_SESSION['user_id'])
                            echo '<a id="suppr" href="./suprr_com.php?id='.$com["com_id"].'&thread_id='.$_GET["thread_id"].'" >Supprimer</a></br></br>';
                    }
                }
            ?>
        </div>
        <?php
            if (isset($_SESSION["user_id"])){      //affiche la possibilité de commenter si on est connecté
                echo '<h3>Nouveau commentaire</h3>
                <form method="post">
                    <label>Titre Commentaire</label><br>
                    <input type="text" name="com_title"><br>
                    <label>Commentaire</label><br>
                    <textarea cols="140" rows="3" name="com_text" required></textarea><br>
                    <input type="submit" name="commenter">
                </form>';
            }
            else{
                echo '<div><a href="./login.php">Connectez-vous</a> pour pouvoir mettre un commentaire</div>';//si pas connecté met un message
            }
         ?>
    </div>
    <script>
        function modifier(event){
            //script qui rend le texte area du thread Modifiable en retirant l'attribut readonly (et fait apparaitre des bouttons en changant le display en bloc)
                event.preventDefault();
                document.getElementById('modify').removeAttribute('readonly');
                document.getElementsByClassName('modify2')[0].style.display= 'block';
                document.getElementsByClassName('modify2')[1].style.display= 'block';
        };
    </script>
    <?php

    ?>
</div>
<br>
<br>
