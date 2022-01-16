<?php
session_start();
include_once('header.php');
if (isset($_SESSION["user_id"])) {
    header("Location: ./index.php");
}

if (isset($_POST['button'])){
    $email=htmlspecialchars($_POST['email']);
    $pseudo=htmlspecialchars($_POST['pseudo']);
    $password=htmlspecialchars($_POST['password']);
    if (!empty($email) && !empty($pseudo) && !empty($password)){
        $userRS = $bdd->prepare('SELECT * FROM forum_user WHERE user_email=?');
        $userRS -> execute(array($email));
        if ($userRS ->rowCount()==0){
            $userRS = $bdd->prepare('SELECT * FROM forum_user WHERE user_name=?');
            $userRS -> execute(array($pseudo));
            if ($userRS ->rowCount()==0) {
                $password=password_hash($password,PASSWORD_BCRYPT);
                $RQ = $bdd-> prepare("INSERT INTO `forum_user`(`user_name`, `user_email`, `user_password`, `user_creation_date`, `user_rank`) VALUES (?,?,?,NOW(),?)");
                $RQ -> execute(array($pseudo,$email,$password,"user"));
                header("Location: ./login.php");
            }
        }

    }
}

$userRS = $bdd->prepare('SELECT * FROM forum_user');
$users = $userRS->fetchAll();
?>
<br>
<br>
<div class="container">
    <h2>Inscriptions</h2>
    <form method="post">
        <label>Votre Mail</label><br>
        <input required type="email" name="email" placeholder="mail" max="100"><br>
        <label>Votre Pseudo</label><br>
        <input required type="text" name="pseudo" placeholder="pseudo" max="30"><br>
        <label>Votre Mot de passe</label><br>
        <input required type="password" name="password" placeholder="mdp" max="60"><br><br>
        <input type="submit" name="button"><br>
    </form>
</div>
