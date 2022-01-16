<?php
    session_start();
    include_once('header.php');
    $threadRS = $bdd -> prepare('SELECT * FROM threads');
    $threads = $threadRS -> fetchAll();
?>
<html>
    <body>
        <div class="container">
            <h1>Forum de fan de Pétanque</h1>
            <br class="Menu principal">
                <h2>Général</h2>
                    <ul>
                <?php
                $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Général"');
                $threadRS -> execute();
                $threads = $threadRS -> fetchAll();
                foreach ($threads as $thread) {

                    echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                }
                ?>
                    </ul>
                <h2>Les Boules</h2>
                    <ul>
                        <?php
                        $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Les Boules"');
                        $threadRS -> execute();
                        $threads = $threadRS -> fetchAll();
                        foreach ($threads as $thread) {

                            echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                        }
                        ?>
                    </ul>
                <h2>Les Pointeurs</h2>
                    <ul>
                        <?php
                        $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Les Pointeurs"');
                        $threadRS -> execute();
                        $threads = $threadRS -> fetchAll();
                        foreach ($threads as $thread) {

                            echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                        }
                        ?>
                    </ul>
                <h2>Les Tireurs</h2>
                    <ul>
                <?php
                $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Les Tireurs"');
                $threadRS -> execute();
                $threads = $threadRS -> fetchAll();
                foreach ($threads as $thread) {

                    echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                }
                ?>
                    </ul>
                <h2>Les Terrains</h2>
                    <ul>
                <?php
                $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Les Terrains"');
                $threadRS -> execute();
                $threads = $threadRS -> fetchAll();
                foreach ($threads as $thread) {

                    echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                }
                ?>
                    </ul>
                <h2>Appéro</h2>
                    <ul>
                <?php
                $threadRS = $bdd -> prepare('SELECT * FROM threads WHERE thread_category="Appéro"');
                $threadRS -> execute();
                $threads = $threadRS -> fetchAll();
                foreach ($threads as $thread) {

                    echo '<li><a href="thread.php?thread_id='.$thread['thread_id'].'">'.$thread['thread_title'].'</a></li>';
                }
                ?>
                    </ul>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="../../assets/js/vendor/popper.min.js"></script>
        <script src="../../dist/js/bootstrap.min.js"></script>

    </body>
    <?php
    ?>
</html>

