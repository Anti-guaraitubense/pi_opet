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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    
    <header id="header"> 
        <nav class="navbar container">
            <a href="index.php" class="logo"> 
                <img src="#" alt="#" class="logo-image">
            </a>
            <button type="button" class="menu-toggle">
                <i class="ri-menu-line toggle-icon open-menu-icon"></i>
                <i class="ri-close-line toggle-icon close-menu-icon"></i>
            </button>
            <div class="collapsible-menu">
                <ul class="list">
                    <li class="list-item">
                        <a href="#" class="list-link current-link">Página Inicial</a>
                    </li>
                    <li class="list-item">
                        <a href="login.php" class="list-link">Login</a>
                    </li>
                    <li class="list-item">
                        <a href="registrar.php" class="list-link">Registrar</a>
                    </li>
                    <li class="list-item">
                        <a href="#" class="list-link">Serviços</a>
                    </li>
                </ul>
                <div class="search-box">
                    <form action="" class="search-form">
                        <span class="form-icon search-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path></svg>
                        </span>
                        <input type="text" class="search-input" placeholder="Search">
                            <button type="button" class="form-icon cart-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.0049 2C15.3186 2 18.0049 4.68629 18.0049 8V9H22.0049V11H20.8379L20.0813 20.083C20.0381 20.6013 19.6048 21 19.0847 21H4.92502C4.40493 21 3.97166 20.6013 3.92847 20.083L3.17088 11H2.00488V9H6.00488V8C6.00488 4.68629 8.69117 2 12.0049 2ZM13.0049 13H11.0049V17H13.0049V13ZM9.00488 13H7.00488V17H9.00488V13ZM17.0049 13H15.0049V17H17.0049V13ZM12.0049 4C9.86269 4 8.1138 5.68397 8.00978 7.80036L8.00488 8V9H16.0049V8C16.0049 5.8578 14.3209 4.10892 12.2045 4.0049L12.0049 4Z"></path></svg>
                            </button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- <?php 

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
    ?> -->

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