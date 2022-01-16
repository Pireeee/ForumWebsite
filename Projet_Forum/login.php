<?php
    session_start();
    include_once('header.php');
if (isset($_SESSION["user_id"])) {
        header("Location: ./index.php");
    }

if (isset($_POST['button'])){//recupertation du form
    $email=$_POST['email'];
    $userRS = $bdd -> prepare('SELECT * FROM forum_user WHERE user_email=?');
    $userRS -> execute(array($email));

    if ($userRS ->rowCount()==1){
        $user = $userRS -> fetch();
        if (password_verify($_POST["password"],$user['user_password'] )){//je met tout dans le $_SESSION
            $_SESSION['user_id']=$user['user_id'];
            $_SESSION['user_name']=$user['user_name'];
            $_SESSION['user_email']=$user['user_email'];
            $_SESSION['user_rank']=$user['user_rank'];
            $_SESSION['user_creation_date']=$user['user_creation_date'];
            header("Location: ./account.php");//redirection vers la page acount
        }
        else{
            echo 'Mot de passe incorrect'; // !!!! Probleme ici a fix !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
    }
    else{
        echo 'Email incorrect ou inexistant';
    }
}




?>
<br>
<br>
<div class="container">
    <h2>Connection</h2>
    <form method="post">
        <label>Votre Mail</label><br>
        <input required type="email" name="email" placeholder="mail"><br>
        <label>Votre Mot de passe</label><br>
        <input required type="password" name="password" placeholder="password"><br><br>
        <input type="submit" name="button">
    </form>
</div>
