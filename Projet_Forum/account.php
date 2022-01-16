<?php
session_start();
include_once('header.php');
    $userRS = $bdd->prepare('SELECT * FROM forum_user WHERE user_id = :user_id ');
    $userRS->execute(array( 'user_id' => $_SESSION['user_id']));

if (isset($_POST['suppr'])){ //suppresion de l'utilisateur et de tout ce qui lui est associé;

    $RQ2 = $bdd->prepare('DELETE FROM `coms` WHERE user_id=?');//dabord les commentaires
    $RQ2 -> execute(array($_SESSION['user_id']));

    $RQ = $bdd->prepare('DELETE FROM `threads` WHERE user_id=?');//les thread
    $RQ -> execute(array($_SESSION['user_id']));

    $RQ3 = $bdd->prepare('DELETE FROM `forum_user` WHERE user_id=?');//l'utilisateur
    $RQ3 -> execute(array($_SESSION['user_id']));

    $_SESSION = array();
    session_destroy();
    header("Location: ./");
}
$userRS = $bdd->prepare('SELECT * FROM forum_user');
$userRS ->execute();
$users = $userRS ->fetchAll();



?>
<div class="container">
    <h2> Votre compte</h2>
    <div class="description">
        Pseudo: <?php echo($_SESSION["user_name"]);?><br>
        Rank actuel: <?php echo($_SESSION["user_rank"]);?><br>
        Votre compte a été cré le <?php echo $_SESSION['user_creation_date']?><br>
        <form method="post">
            <input type="submit" name="suppr" value="Supprimer">
        </form>

    </div>
    <?php if ($_SESSION['user_rank']=='admin'){
     echo '   
    <div class="admin">              <!-- Tableau des administrateurs -->
        <h2> Tous les comptes</h2>
        <table>
            <thead>
            <tr>
                <th>Pseudo</th>
                <th>Mail</th>
                <th>rang</th>
                <th>date de création</th>
                <th>nombre de threads</th>
                <th>nombre de Commentaires</th>
                <th>Passer admin</th>
                <th>Supprimer</th>
            </tr>
            </thead>
            <tbody>';
                    foreach ($users as $user){
                        $threadRS=$bdd->prepare('SELECT COUNT(*) FROM threads WHERE user_id=? GROUP BY user_id');
                        $threadRS -> execute(array($user['user_id']));
                        $thread = $threadRS->fetch();

                        $comRS=$bdd->prepare('SELECT COUNT(*) FROM coms WHERE user_id=? GROUP BY user_id');
                        $comRS -> execute(array($user['user_id']));
                        $com = $comRS->fetch();

                        echo '<tr>';
                        echo '<th>'.$user["user_name"].'</th>';
                        echo '<th>'.$user["user_email"].'</th>';
                        echo '<th>'.$user["user_rank"].'</th>';
                        echo '<th>'.$user["user_creation_date"].'</th>';
                        echo '<th>';
                        if ($thread==false){
                            echo'0';
                        }
                        else{
                            echo $thread[0];
                        }
                        echo '</th>';
                        echo '<th>';
                        if ($com==false){
                            echo'0';
                        }
                        else{
                            echo $com[0];
                        }
                        echo '</th>';
                        if ($user['user_rank']== 'user'){ // créer la requette  et tester ça 
                            echo '<th><form method="post">
                                      <input type="submit" name="changer'.$user['user_id'].'" value="changer">  
                                    </form></th>';
                             if (isset($_POST['changer'.$user['user_id']])){
                                $RQ3 = $bdd->prepare('UPDATE `forum_user` SET user_rank="admin" WHERE user_id=? ');
                                $RQ3 -> execute(array($user['user_id']));
                                header("Location: ./account.php?user_id=".$_SESSION['user_id']."");
                                    };
                        }else{
                            echo '<th></th>';
                        }
                        if ($user['user_name']!=='Pire'){
                        echo '<th><a id="suppr" href="suppr_user.php?user_id='.$user["user_id"].'">Supprimer</a></th>';
                        }
                        else echo '<th>impossible</th>';
                        };
                    echo '
            </tr>
            </tbody>
        </table>
    </div>';
    }
    ?>
</div>
