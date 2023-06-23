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
    <link rel="stylesheet" type="text/css" href="css/posdoacao.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="js/script.js"></script>
</head>

<body onload="evitar_dados_reload();">
    <a href="index.php">Doasans</a>

    <h1>Área de pós doação</h1>

    <?php 

        $count_doadores = $conn->prepare('SELECT * FROM `login` WHERE `posdoador_user` = 1');
        $count_doadores->execute();

        if($count_doadores->rowCount() == 0){
            echo "Sem informações para serem mostradas";
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
                echo "<a href='posdoacao.php?id=$_GET[id]'>Retornar</a>";

                $doacao = $conn->prepare('SELECT * FROM `doacao` WHERE `id_doacao` = :id');
                $doacao->bindValue("id", $_GET['id_doacao']);
                $doacao->execute();
                $row = $doacao->fetch();

                $doador = $conn->prepare('SELECT * FROM `login` WHERE `id_user` = :id');
                $doador->bindValue(":id", $row['user_doador']);
                $doador->execute();

                $row_user = $doador->fetch();

                echo "<br><br>";
                echo "<img src='$row[img_doacao]' style='width: 300px; height: 250px;'><img src='$row[img_validade]' style='width: 300px; height: 250px;'> Validade: $row[validade_doacao]";
                echo "<br>Informações sobre o doador: 
                    <br>Usuário: $row_user[nome_user]
                    <br>E-mail: $row_user[email_user]
                    <br>Telefone: $row_user[nmr_user]
                    <br>Cidade: ".get_city($row_user['cep_user']);

                ?>
                    <form action="posdoacao.php?id=<?php echo $_GET['id']?>&id_doacao=<?php echo $_GET['id_doacao']?>" method="post">
                        <button style="color: green;" name="aceitar">Aceitar</button>
                        <button style="color: red;" name="recusar">Recusar</button>
                    </form>
                <?php

                if(isset($_POST['recusar'])){

                    $recusar = $conn->prepare("UPDATE `doacao` SET `status_doacao` = 0, `id_validador` = :id_val WHERE `id_doacao` = :id");
                    $recusar->bindValue(":id", $_GET['id_doacao']);
                    $recusar->bindValue(":id_val", $user_id);
                    $recusar->execute();

                    goto_page("posdoacao.php?id=$_GET[id]");
                }

                if(isset($_POST['aceitar'])){

                    ?>
                        <p>Quantos pontos essa doação merece?</p>
                        <form action="" method="post">
                            <input type="number" name="val-pontos">
                            <input type="submit" name="sub-pontos">
                        </form>
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
                while($row_doacao = $count_doacoes->fetch()){
                    echo "<br> <hr> $row_doacao[id_doacao] - $row_doacao[nome_doacao] - $row_doacao[data_doacao] <br>";
                    echo "<img src='$row_doacao[img_doacao]' style='width: 200px; height: 150px'>";
                    echo "<a href='posdoacao.php?id=$_GET[id]&id_doacao=$row_doacao[id_doacao]'>Expandir</a>";
                }
            }

        }else{
            while($row_doador = $count_doadores->fetch()){
                echo "<a href='posdoacao.php?id=$row_doador[id_user]'>$row_doador[nome_user]</a> <br>";
            }
        }
    ?>
</body>