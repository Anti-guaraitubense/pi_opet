<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre-se</title>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>

    <?php 

        session_start();
        if(isset($_SESSION['id'])){
            header("location:index.php");
        }
    ?>

    <div class="reg-main">
        <div class="reg-right">
            <div class="card-reg">
                <h1>CRIE SUA CONTA</h1>
                <form action="registrar.php" method="post">
                <div class="textfield">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" placeholder="E-mail" autocomplete="off">
                </div>
                <div class="textfield">
                    <label for="user">Usuário</label>
                    <input type="text" name="user" placeholder="Usuário" autocomplete="off">
                </div>
                <div class="textfield">
                    <label for="pass">Senha</label>
                    <input type="password" name="pass" placeholder="Senha">
                </div>
                    <button class="button-reg" name="reg">Criar conta</button>
                    <button class="button-login" name="login">Faça Login</button>
                    <button class="button-back" name="return">Voltar</button>
                </form>
             </div>
        </div>
        <div class="reg-left">
            <h1>Crie uma conta!<br> E faça parte do nosso time</h1>
            <img src="img/entrega.svg" class="animation" alt="Animação comida">
        </div>
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

                        $reg = $conn->prepare('INSERT INTO `login` (nome_user, senha_user, email_user, status_user, score_user) VALUES (:nome, md5(:pass), :email, 1, 0);');
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
                        
                        $default_path = "img/pfp/";
                        $default_img = "defaultpic.jpg";
                        $final_path = $default_path.$default_img;

                        $foto = $conn->prepare("INSERT INTO `fotoperfil` (id_foto, url_foto) VALUES (:id, :finalpath);");
                        $foto->bindValue(":id", $id_login);
                        $foto->bindValue(":finalpath", $final_path);
                        $foto->execute();

                        $cria_bio = $conn->prepare('INSERT INTO `bio` (id_bio, user_bio) VALUES (:id, "Escreva sobre você");');
                        $cria_bio->bindValue(":id", $id_login);
                        $cria_bio->execute();

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