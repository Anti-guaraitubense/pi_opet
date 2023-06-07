<?php
    include_once 'config.php';
    $logado = false;
    session_start();
    if(isset($_SESSION['id'])){
        $logado = true;
        $id_user_atual = $_SESSION['id'];
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    <a href="#" class="logo">Doasans</a>
    
    <header id="header"> 
        <nav class="navbar container">
            <a href="#" class="logo"> 
                <img src="#" alt="#" class="logo-image">
            </a>
            <button type="button" class="menu-toggle">
                <i class="ri-menu-line toggle-icon open-menu-icon"></i>
                <i class="ri-close-line toggle-icon close-menu-icon"></i>
            </button>
            <div class="collapsible-menu">
                <ul class="list">
                    <li class="list-item">
                        <a href="#" class="list-link">Página Inicial</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="list-link">Menu</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="list-link">Serviços</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="list-link">Comprar</a>
                    </li>
                </ul>
                <div class="search-box">
                    <form action="" class="search-form">
                        <span class="form-icon search-icon">
                           <!-- <sv></svg> -->
                        </span>
                        <input type="text" class="search-input" placeholder="Search">
                        <button type="button" class="form-icon cart-icon">
                            <!-- <sv></svg> -->
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <?php 

        if($logado){
        ?>
            <div class="my-acc">
                <a href="minhaconta.php" class="sua-conta">Sua Conta</a>
            </div>
                
            <form action="index.php" method="post">
                <div class="logout-box">
                    <input type="submit" value="Logout" name="logout" class="logout">
                </div>
            </form>
        <?php 
        }else{
        ?>
            <div class="reg-acc">
                <a href="login.php">Login</a>
                <a href="registrar.php">Registrar</a>
            </div>
        <?php
        }
    ?>

    <?php 
        
        if(isset($_POST['logout'])){

            session_destroy();
            header("location:index.php");
            exit();
        }

        if($logado){
            
            $infos = $conn->prepare('SELECT * FROM `login` WHERE id_user = :id');
            $infos->bindValue(":id", $id_user_atual);
            $infos->execute();

            $info = $infos->fetch();
            $nome_fix = ucfirst($info['nome_user']);

            echo "<h1> Bem vindo(a), $nome_fix!";
        }
    ?>
</body>
</html>