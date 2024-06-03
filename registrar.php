<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/registro.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">  
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>

    <?php 

        include_once 'functions.php';
        include_once 'config.php';
        session_start();
        if(isset($_SESSION['id'])){
            goto_page("index.php");
        }
    ?>

    <div class="reg-main">
        <div class="reg-right">
            <div class="card-reg">
                <h1>CRIE SUA CONTA</h1>
                <form action="registrar.php" method="post">
                <div class="textfield">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" placeholder="E-mail" autocomplete="off">
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

            if(isset($_POST['return'])){

                goto_page("index.php");
                exit();
            }

            if(isset($_POST['login'])){

                goto_page("login.php");
                exit();
            }
            
            if(isset($_POST['reg'])){

                $email = $_POST['email'];
                $email_valido = false;
                $user = $_POST['user'];
                $user_valido = false;
                $pass = $_POST['pass'];
                $pass_valida = false;

                #check de informações do email
                $email_aceitos = ['gmail.com', 'outlook.com', 'yahoo.com'];
                $email_check = explode('@', $email);
                if(count($email_check) == 2){
                    $email_check = end($email_check);
                    if(in_array($email_check, $email_aceitos)){

                        $email_valido = true;
                    }
                }
                
                #check do usuario
                $user = trim($user);

                if(strlen($user) >= 0 && strlen($user) <= 15){ #limite de 15 caracteres
                    if(ctype_alnum($user)){
                        $user_valido = true;
                    }
                } 

                #check da senha
                if(strlen($pass) >= 0){
                    $pass_valida = true;

                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                }
                
                if($email_valido && $user_valido && $pass_valida){

                    $verif_nome = $conn->prepare('SELECT `nome_user` FROM `login` WHERE `nome_user` = :user;');
                    $verif_nome->bindValue(":user", $user);
                    $verif_nome->execute();

                    $verif_email = $conn->prepare('SELECT `email_user` FROM `login` WHERE `email_user` = :email');
                    $verif_email->bindValue(":email", $email);
                    $verif_email->execute();
                
                    if($verif_email->rowCount() == 0){
                        if($verif_nome->rowCount() == 0){

                            $reg = $conn->prepare('INSERT INTO `login` (nome_user, senha_user, email_user, status_user, score_user, user_perm, doador_user, posdoador_user, cpf_user, cep_user, nmr_user) 
                                                        VALUES (:nome, :pass, :email, 1, 0, 0, 0, 0, "", "", "");');
                            $reg->bindValue(":nome", $user);
                            $reg->bindValue(":pass", $hash);
                            $reg->bindValue(":email", $email);
                            $reg->execute();

                            $get_id = $conn->prepare('SELECT `id_user` FROM `login` WHERE `nome_user` = :user AND `email_user` = :email;');
                            $get_id->bindValue(":user", $user);
                            $get_id->bindValue(":email", $email);
                            $get_id->execute();

                            $row = $get_id->fetch();
                            $id_login = $row['id_user'];
                            $_SESSION['id'] = $id_login;
                            
                            $pfpurl = "data:image/jpeg;base64,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";

                            $foto = $conn->prepare("INSERT INTO `fotoperfil` (id_foto, url_foto) VALUES (:id, :finalpath);");
                            $foto->bindValue(":id", $id_login);
                            $foto->bindValue(":finalpath", $pfpurl);
                            $foto->execute();

                            $cria_bio = $conn->prepare('INSERT INTO `bio` (id_bio, user_bio) VALUES (:id, "Escreva sobre você");');
                            $cria_bio->bindValue(":id", $id_login);
                            $cria_bio->execute();

                            $cfg_default = $conn->prepare('INSERT INTO `configuracao` (id_user_cfg, site_theme) VALUES (:id, "dark_theme");');
                            $cfg_default->bindValue(":id", $id_login);
                            $cfg_default->execute();

                            goto_page("index.php");
                        }
                        else{
                            ?>
                            <h6 class="error">Nome já utilizado.</h6>
                        <?php
                        }
                    }
                    else{
                        ?>
                            <h6 class="error">E-mail já utilizado.</h6>
                        <?php
                    }
                }else{
                    ?>
                        <h6 class="error">Informações inválidas, tente novamente.</h6>
                    <?php
                }
            }
        ?>
</body>
</html>