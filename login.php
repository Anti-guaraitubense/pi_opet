<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    
    <?php 
        session_start();
        include_once 'functions.php';
        include_once 'config.php';
        
        if(isset($_SESSION['id'])){

            goto_page("index.php");
        }
    ?>

    <div class="login-main">
        <div class="login-left">
            <h1>Faça login<br> E faça parte de nosso time!</h1>
            <img src="img/comida.svg" class="animation" alt="Animação comida">
        </div>
        <div class="login-right">
            <div class="card-login">
                <h1>LOGIN</h1>
                <form action="login.php" method="post">
                <div class="textfield">
                    <label for="user">Usuário</label>
                    <input type="text" name="user" placeholder="Usuário" autocomplete="off">
                </div>
                <div class="textfield">
                    <label for="pass">Senha</label>
                    <input type="password" name="pass" placeholder="Senha">
                </div>
                    <button class="button-login" name="login">Login</button>
                    <button class="button-register" name="register">Registre-se</button>
                    <button class="button-back" name="return">Voltar</button>
                </form>
             </div>
        </div>
    </div>

    <?php 

        if(isset($_POST['return'])){

            goto_page("index.php");
            exit();
        }

        if(isset($_POST['register'])){

            goto_page("registrar.php");
            exit();
        }

        if(isset($_POST['login'])){

            $user = $_POST['user'];
            $pass = $_POST['pass'];

            if($user == NULL || $pass == NULL){

                $user = "";
                $pass = "";
            }


            $check = $conn->prepare('SELECT * FROM `login` WHERE `nome_user` = :user AND `status_user` = 1');
            $check->bindValue(":user", $user);
            $check->execute();
            $usuario = $check->fetch();

            if($check->rowCount() == 0){
                ?>
                        <h6 class="error">Usuário ou senha não encontrada!</h6>
                <?php
            }else{
                $pass = password_verify($pass, $usuario['senha_user']);
                
                if($pass){
                    $id = $usuario['id_user'];
                    
                    $_SESSION['id'] = $id;
                    goto_page("index.php");
                }else{
                    ?>
                        <h6 class="error">Usuário ou senha não encontrada!</h6>
                    <?php
                }
            }
        }
    ?>

</body>
</html>