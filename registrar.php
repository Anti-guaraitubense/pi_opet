<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagina de registro</title>
    <link rel="stylesheet" href="css/registro.css" type="text/css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>

    <?php 

        session_start();
        if(isset($_SESSION['id'])){
            header("location:index.php");
        }
    ?>
    
    <div class="reg-box">
        <form action="registrar.php" method="post">
            <input type="email" name="email" placeholder="E-mail">
            <input type="text" name="user" placeholder="Usuário" autocomplete="off">
            <input type="password" name="pass" placeholder="Senha" autocomplete="off">
            <input type="submit" name="reg" value="Registrar">

            <input type="submit" name="return" value="Voltar">
        </form>
    </div>

        <?php 

            include_once 'config.php';

            if(isset($_POST['return'])){

                header("location:index.php");
                exit();
            }

            if(isset($_POST['reg'])){

                $email = $_POST['email'];
                $user = $_POST['user'];
                $pass = $_POST['pass'];

                $verif_nome = $conn->prepare('SELECT `nome_user` FROM `login` WHERE `nome_user` = :user;');
                $verif_nome->bindValue(":user", $user);
                $verif_nome->execute();

                $verif_email = $conn->prepare('SELECT `email_user` FROM `login` WHERE `email_user` = :email');
                $verif_email->bindValue(":email", $email);
                $verif_email->execute();

                if($verif_nome->rowCount() == 0){
                    if($verif_email->rowCount() == 0){

                        $reg = $conn->prepare('INSERT INTO `login` (nome_user, senha_user, email_user) VALUES (:nome, :pass, :email);');
                        $reg->bindValue(":nome", $user);
                        $reg->bindValue(":pass", $pass);
                        $reg->bindValue(":email", $email);
                        $reg->execute();

                        $get_id = $conn->prepare('SELECT `id_user` FROM `login` WHERE `nome_user` = :user AND `email_user` = :email;');
                        $get_id->bindValue(":user", $user);
                        $get_id->bindValue(":email", $email);
                        $get_id->execute();

                        $row = $get_id->fetch();
                        $id_login = $row['id_user'];
                        $_SESSION['id'] = $id_login;

                        echo "<script>alert('Registrado com sucesso!');</script>";
                        header('location:index.php');
                    }
                    else{
                        echo "E-mail já utilizado.";
                    }
                }
                else{
                    echo "Nome de usuário já utilizado.";
                }

            }
        ?>
</body>
</html>