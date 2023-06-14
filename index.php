<?php
    include_once 'config.php';
    $logado = false;
    session_start();
    if(isset($_SESSION['id'])){
        $logado = true;
        $id_user_atual = $_SESSION['id'];
        

        if(isset($_GET['logout'])){
            session_destroy();
            header("location:index.php");
            exit();   
        }
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    <header>
        <a href="#" class="logo"><i class='bx bxs-package'></i></i>Doasans</a>
        
        <ul class="navlist">
            <li><a href="#home" class="active ">Inicío</a></li>
            <li><a href="#about">Sobre</a></li>
            <li><a href="doacao.php">Faça Sua Doação</a></li>
            <?php
            if($logado){
                ?>
                <li><a href="minhaconta.php">Sua conta  </a></li>
                <li><a href="index.php?logout">Logout</a></li>
                <?php
            }else{
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registrar.php">Registrar</a></li>
                <?php
            }
            ?>
        </ul>

        <div class="nav-icons">
            <a href="#"><i class='bx bx-search'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <section class="home" id="home">
        <div class="home-text">
            <h1>Doe, <span>Ajude &</span> <br> Faça uma Boa <br> ação</h1>
            <a href="#" class="btn">Faça sua Doação<i class='bx bxs-right-arrow'></i></a>
            <a href="#" class="btn2">Peça uma Doação</a>
        </div>

        <div class="home-img">
            <img src="img/delivery.svg">
            
        </div>

    </section>
    
    

    <?php
        if(isset($_POST['my-acc'])){

            header("location:minhaconta.php");
            exit();
        }

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

            ?>
                <h1>Bem vindo(a) <?php echo $nome_fix?></h1>
            <?php
        }
    ?>
</body>
</html>