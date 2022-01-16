<?php
try{ $bdd = new PDO('mysql:host=localhost;dbname=forum;charset=utf8','root','',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}catch(Exception $e){
    die('Erreur : '.$e->getMessage());
}?>
<html>
<img id="forme" src="ressources/soleil.png">
<head>
    <!-- CSS only -->
    <title>Petanque1max.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark mb-4">
        <a class="navbar-brand" href="./">Petanque1max.com</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse show" id="navbarCollapse" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])){
                    echo '
                    <li class="nav-item active">
                        <a class="nav-link" aria-current="page" href="create_thread.php">New Thread</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="account.php?user_id='.$_SESSION["user_id"].'">account</a>
                    </li>
                    
                    <li>
                        <a class="nav-link" href="logout.php">log out</a>
                    </li>
                    
                    ';
                }
                else{
                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">log in</a>
                    </li>
                    <li>
                        <a class="nav-link" href="register.php">register</a>
                    </li>';
                }
                ?>
            </ul>

        </div>
    </nav>


