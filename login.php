<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    
    <?php 
        session_start();
        
        if(isset($_SESSION['id'])){

            header("location:index.php");
        }
    ?>

    <div class="login-main">
        <div class="login-left">
            <h1>Faça login<br> E faça parte de nosso time!</h1>
            <img src="imgs/comida.svg" class="animation" alt="Animação comida">
        </div>
        <div class="login-right">
            <div class="card-login">
                <h1>LOGIN</h1>
                <div class="textfield">
                    <label for="user">Usuário</label>
                    <input type="text" name="user" placeholder="Usuário">
                </div>
                <div class="textfield">
                    <label for="pass">Senha</label>
                    <input type="password" name="pass" placeholder="Senha">
                </div>
                <button class="button-login">Login</button>
                <button class="button-register">Registre-se</button>
                <button class="button-back">Voltar</button>

             </div>
        </div>
    </div>

    <?php 
        include_once 'config.php';

        if(isset($_POST['return'])){

            header("location:index.php");
            exit();
        }

        if(isset($_POST['login'])){

            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $check = $conn->prepare('SELECT * FROM `login` WHERE `nome_user` = :user AND `senha_user` = md5(:pass) AND `status_user` = 1');
            $check->bindValue(":user", $user);
            $check->bindValue(":pass", $pass);
            $check->execute();

            if($check->rowCount() == 0){
                echo "Usuário ou senha incorreto.";
                echo "<br><br> $user ".md5($pass);
            }else{
                
                $get_id = $check->fetch();
                $id = $get_id['id_user'];
                
                $_SESSION['id'] = $id;
                header("location:index.php");
            }
        }
    ?>

</body>
</html>