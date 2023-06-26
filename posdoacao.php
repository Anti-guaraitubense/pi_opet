<?php 
    include_once 'config.php';
    include_once 'functions.php';

    session_start();

    if(!isset($_SESSION['id'])){
        goto_page("index.php");
        exit();
    }
    $user_id = $_SESSION['id'];

    $infosuser = $conn->prepare('SELECT * from `login` WHERE id_user = :id');
    $infosuser->bindValue(":id", $user_id);
    $infosuser->execute();

    $info = $infosuser->fetch();
    $perm = $info['user_perm'];

    if($perm <= 1){
        goto_page("index.php");
        exit();
    }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/controledoacao.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="js/script.js"></script>
</head>

<body onload="evitar_dados_reload();">
    
    <a href="index.php" class="logo"><i class='bx bxs-package'></i></i>Doasans</a>

    <?php 
        $count_doadores = $conn->prepare('SELECT * FROM `login` WHERE `posdoador_user` = 1');
        $count_doadores->execute();

        if($count_doadores->rowCount() == 0){
            echo "<h1 class='no-data'>Sem dados para exibir</h1>";
        }

        if(isset($_GET['id'])){
            $count_doacoes = $conn->prepare('SELECT * FROM `doacao` WHERE `user_doador` = :id AND `status_doacao` = 2');
            $count_doacoes->bindValue(":id", $_GET['id']);
            $count_doacoes->execute();

            if($count_doacoes->rowCount() == 0){
                $alterar = $conn->prepare('UPDATE `login` SET `posdoador_user` = 0 WHERE `id_user` = :id');
                $alterar->bindValue(":id", $_GET['id']);
                $alterar->execute();
                goto_page("minhaconta.php");
            }

            if(isset($_GET['id_doacao'])){
                echo "<a href='posdoacao.php?id=$_GET[id]' class='voltar-link'>Voltar</a>";

                $doacao = $conn->prepare('SELECT * FROM `doacao` WHERE `id_doacao` = :id');
                $doacao->bindValue("id", $_GET['id_doacao']);
                $doacao->execute();
                $row = $doacao->fetch();

                $doador = $conn->prepare('SELECT * FROM `login` WHERE `id_user` = :id');
                $doador->bindValue(":id", $row['user_doador']);
                $doador->execute();

                $row_user = $doador->fetch();

                if($row_user['cep_user'] != NULL){
                    if($row_user['nmr_user'] != NULL){
                        $cidade = get_city($row_user['cep_user']);
                        $bairro = get_district($row_user['cep_user']);
                        echo "
                        <div class='doacoes-expd-block'>
                        <br>
                        <br>
                        <img src='$row[img_doacao]' class='img-doacao-expd'>
                        <img src='$row[img_validade]' class='img-doacao-expd'>
                        <span>
                            Validade: $row[validade_doacao]
                            <br>
                            Informações sobre o doador: 
                            <br>Usuário: $row_user[nome_user]
                            <br>E-mail: $row_user[email_user]
                            <br>Telefone: $row_user[nmr_user]
                            <br>Cidade: $cidade
                            <br>Bairro: $bairro
                        </span>
                        <form action='posdoacao.php?id=$_GET[id]&id_doacao=$_GET[id_doacao]' method='post'>
                                <br>
                                <button style='color: green;' name='aceitar'>Aceitar</button>
                                <button style='color: red;' name='recusar'>Recusar</button>
                        </form>
                        </div>
                        ";

                    }else{
                        $cidade = get_city($row_user['cep_user']);
                        $bairro = get_district($row_user['cep_user']);
                        echo "
                        <div class='doacoes-expd-block'>
                        <br>
                        <br>
                        <img src='$row[img_doacao]' class='img-doacao-expd'>
                        <img src='$row[img_validade]' class='img-doacao-expd'>
                        <span>
                            Validade: $row[validade_doacao]
                            <br>
                            Informações sobre o doador: 
                            <br>Usuário: $row_user[nome_user]
                            <br>E-mail: $row_user[email_user]
                            <br>Cidade: $cidade
                            <br>Bairro: $bairro
                        </span>
                        <form action='posdoacao.php?id=$_GET[id]&id_doacao=$_GET[id_doacao]' method='post'>
                                <br>
                                <button style='color: green;' name='aceitar'>Aceitar</button>
                                <button style='color: red;' name='recusar'>Recusar</button>
                        </form>
                        </div>
                        ";
                    }
                }else{
                    echo "
                    <div class='doacoes-expd-block'>
                    <br>
                    <br>
                    <img src='$row[img_doacao]' class='img-doacao-expd'>
                    <img src='$row[img_validade]' class='img-doacao-expd'>
                    <span>
                        Validade: $row[validade_doacao]
                        <br>
                        Informações sobre o doador: 
                        <br>Usuário: $row_user[nome_user]
                        <br>E-mail: $row_user[email_user]
                    </span>
                    <form action='posdoacao.php?id=$_GET[id]&id_doacao=$_GET[id_doacao]' method='post'>
                            <br>
                            <button style='color: green;' name='aceitar'>Aceitar</button>
                            <button style='color: red;' name='recusar'>Recusar</button>
                    </form>
                    </div>
                    ";

                }

                if(isset($_POST['recusar'])){

                    $recusar = $conn->prepare("UPDATE `doacao` SET `status_doacao` = 0, `id_validador` = :id_val WHERE `id_doacao` = :id");
                    $recusar->bindValue(":id", $_GET['id_doacao']);
                    $recusar->bindValue(":id_val", $user_id);
                    $recusar->execute();

                    goto_page("posdoacao.php?id=$_GET[id]");
                }

                if(isset($_POST['aceitar'])){

                    ?>
                    <div class="box-pontos" style="position: relative; top: 15vh; left: 5vw; max-width: 1000px">
                        <span>Quantos pontos essa doação merece?</span>
                        <br>
                        <form action="" method="post">
                            <input type="number" name="val-pontos">
                            <input type="submit" name="sub-pontos">
                        </form>
                    </div>
                    <?php
                }

                if(isset($_POST['sub-pontos'])){

                    $get_ponto = $conn->prepare('SELECT `score_user` FROM `login` WHERE `id_user` = :id');
                    $get_ponto->bindValue(":id", $_GET['id']);
                    $get_ponto->execute();
                    $pt = $get_ponto->fetch();
                    
                    $pontos_add = $_POST['val-pontos'];
                    $pontos_add = intval($pontos_add);

                    $ponto_final = $pt['score_user'] + $pontos_add;

                    echo "$ponto_final - $_GET[id] - $_GET[id_doacao]";

                    $alter = $conn->prepare("UPDATE `login` SET `score_user` = :ponto WHERE `id_user` = :id;");
                    $alter->bindValue(":ponto", $ponto_final);
                    $alter->bindValue(":id", $_GET['id']);
                    $alter->execute();

                    # setando doacao e user
                    $del_doacao = $conn->prepare("UPDATE `doacao` SET `status_doacao` = 0 WHERE `id_doacao` = :idd");
                    $del_doacao->bindValue(":idd", $_GET['id_doacao']);
                    $del_doacao->execute();

                    $check_pos = $conn->prepare('SELECT * from `doacao` WHERE `user_doador` = :id AND `status_doacao` = 2');
                    $check_pos->bindValue(":id", $_GET['id']);
                    $check_pos->execute();

                    if($check_pos->rowCount() == 0){

                        $alter_user = $conn->prepare('UPDATE `login` SET `posdoador_user` = 0 WHERE `id_user` = :id');
                        $alter_user->bindValue(":id", $_GET['id']);
                        $alter_user->execute();
                        goto_page("posdoacao.php");
                        exit();
                    }
                    
                    goto_page("posdoacao.php?id=$_GET[id]");
                    exit();
                }
                exit();
            }else{
                echo "<a href='posdoacao.php' class='voltar-link'>Voltar</a>";
                while($row_doacao = $count_doacoes->fetch()){
                    ?>
                    <div class="doacoes-block">
                        <br>
                        <span><?php echo "$row_doacao[id_doacao]"; ?> - <?php echo "$row_doacao[nome_doacao]"; ?> - <?php echo "$row_doacao[data_doacao]"; ?></span>
                        <br>
                        <img src="<?php echo "$row_doacao[img_doacao]"; ?>" class="imgs">
                        <a href="posdoacao.php?id=<?php echo "$_GET[id]"; ?>&id_doacao=<?php echo "$row_doacao[id_doacao]"; ?>" class="expd-link">Expandir</a>
                    </div>
                    <?php
                }
            }

        }else{
            echo "<a href='minhaconta.php' class='voltar-link'>Sua conta</a>";
            while($row_doador = $count_doadores->fetch()){
                echo "<br><a href='posdoacao.php?id=$row_doador[id_user]' class='user-name'>$row_doador[nome_user]</a>";
            }
        }
    ?>
</body>