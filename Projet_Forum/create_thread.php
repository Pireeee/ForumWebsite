<!DOCTYPE html>
<?php
    session_start();//plûtot pratique quand tu l'oublies pas 
    include_once('header.php');
    if (!isset($_SESSION['user_id'])){ // si personne est connecté on renvoit a la page d'avant
        header('Location: ./');
    }
//création du thread et envoi dans la base de donnée

    if (isset($_POST['create'])) {
        $thread_title = htmlspecialchars($_POST['thread_title']); //on oublie pas les htmlspecialcards
        $thread_text = htmlspecialchars($_POST['thread_text']);
        $thread_category = htmlspecialchars($_POST['thread_category']);

        if (!empty($thread_title) && !empty($thread_text) && !empty($thread_category)){ //on verifie si les cases sont pas vide
            $threadRS = $bdd->prepare('SELECT * FROM threads WHERE thread_title=?');
            $threadRS -> execute(array($thread_title));
            if ($threadRS ->rowCount()==0) { //on vérifie si il n'y a pas déjà de thread avec ce titre
                $RQ = $bdd-> prepare("INSERT INTO `threads`(`user_id`, `thread_title`, `thread_text`, `thread_category`) VALUES (?,?,?,?)");
                $RQ -> execute(array($_SESSION['user_id'],$thread_title,$thread_text,$thread_category));
                $thread_id = $bdd ->  prepare('SELECT thread_id FROM threads ORDER BY thread_id DESC LIMIT 1');
                $thread_id -> execute();
                header("Location: ./thread.php?thread_id=".$thread_id-> fetch()[0]);//redirection
            }
            else echo "ce titre est deja utilisé";
        }
    }

?>
<br>
<br>

<div class="container">
    <form method="post">
        <label>Titre du Thread</label><br>
        <input required type="text" name="thread_title" placeholder="Title" maxlength="100"><br>
        <label>Categorie du Thread</label><br>
        <select required name="thread_category">
            <option value="Général">Général</option>
            <option value="Les Boules">Les Boules</option>
            <option value="Les Pointeurs">Les Pointeurs</option>
            <option value="Les Tireurs">Les Tireurs</option>
            <option value="Les Terrains">Les Terrains</option>
            <option value="Appéro">Appéro</option>
        </select><br>
        <label>Contenu du Thread</label><br>
        <textarea required name="thread_text" placeholder="type here" maxlength="2500" cols="100" rows="5"></textarea><br>
        <input type="submit" name="create">
    </form>
</div>