<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina de login</title>
    <link rel="stylesheet" href="css/login.css" type="text/css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    
    <?php 
        session_start();
        
        if(isset($_SESSION['id'])){

            header("location:index.php");
        }
    ?>

    <div class="login-box">
        <form action="login.php" method="post">
            <input type="text" name="user" placeholder="Usuário">
            <input type="password" name="pass" placeholder="Senha">
            <input type="submit" name="login" value="Entrar">
            <input type="submit" name="return" value="Voltar">
        </form>
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

            $check = $conn->prepare('SELECT * FROM `login` WHERE `nome_user` = :user AND `senha_user` = md5(:pass);');
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