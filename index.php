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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    
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
                <form method="post" action="index.php">
                    <ul class="list">
                        <li class="list-item">
                            <a href="#" class="list-link current-link">Página Inicial</a>
                        </li>
                        <?php 
                            if($logado){
                                ?>
                                    <li class="list-item">
                                    <button class="list-link" name="my-acc">Sua conta</button>
                                    </li>
                                    <li class="list-item">
                                    <button class="list-link" name="logout">Logout</button>
                                    </li> 
                                <?php
                            }else{
                                ?>
                                    <li class="list-item">
                                    <a href="login.php" class="list-link">Login</a>
                                    </li>
                                    <li class="list-item">
                                    <a href="registrar.php" class="list-link">Registrar</a>
                                    </li>
                                <?php
                            }
                        ?>
                        <li class="list-item">
                            <a href="doacao.php" class="list-link">Faça uma doação</a>
                        </li>
                    </ul>
                    <div class="search-box">
                        <form action="" class="search-form">
                            <span class="form-icon search-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewbox="0 0 16 16">
                                <path fill="#8B8B8B"
                                    d="M15.212 14.573l-3.808-3.96A6.44 6.44 0 0012.92 6.46 6.467 6.467 0 006.46 0 6.467 6.467 0 000 6.46a6.467 6.467 0 006.46 6.46 6.39 6.39    0 003.701-1.169l3.837 3.99a.838.838 0 001.191.023.844.844 0 00.023-1.19zM6.46 1.685a4.78 4.78 0 014.775 4.775 4.78 4.78 0 01-4.775 4.  775A4.78 4.78 0 011.685 6.46 4.78 4.78 0 016.46 1.685z" />
                                </svg>  
                            </span>
                            <input type="text" class="search-input" placeholder="Search">
                                <button type="button" class="form-icon cart-icon">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewbox="0 0 24 24">
                                     <path class="path" fill="#3C3737" fill-rule="evenodd"
                                            d="M1.014 10.084a.464.464 0 01.45-.576h21.072c.302 0 .523.283.45.576L20.059 21.79a.927.927 0 01-.9.703H4.84a.927.927 0 01-.9-.703L1.015 10.084zm11.736 3.541a.75.75 0 00-1.5 0v4.75a.75.75 0 001.5 0v-4.75zm4.319-.561a.75.75 0 01.448.961l-1.624 4.464a.75.75 0 11-1.41-.513l1.625-4.464a.75.75 0 01.96-.448zm-9.177.448a.75.75 0 10-1.41.513l1.625 4.464a.75.75 0 101.41-.513l-1.625-4.464z"
                                            clip-rule="evenodd" />
                                         <path class="path no-fill" stroke="#3C3737" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.5 10.5l-4.911-6.422a2 2 0 00-3.178 0L5.5 10.5" />
                                    </svg> 
                                </button>
                        </form>
                    </div>
                </form>
            </div>
        </nav>
    </header>

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

            echo "<h1> Bem vindo(a), $nome_fix!";
        }
    ?>
</body>
</html>