<?php 
    include_once 'config.php';

    session_start();

    if(!isset($_SESSION['id'])){
        header("location:index.php");
        exit();
    }
    $user_id = $_SESSION['id'];

    $infosuser = $conn->prepare('SELECT * from `login` WHERE id_user = :id');
    $infosuser->bindValue(":id", $user_id);
    $infosuser->execute();

    $info = $infosuser->fetch();
    $perm = $info['user_perm'];
    
    if($perm <= 0){
        header("location:index.php");
        exit();
    }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/controledoacao.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload();">

    <a href="index.php">Doasans</a>

    <?php 
        $count_doadores = $conn->prepare('SELECT * FROM `login` WHERE `doador_user` = 1');
        $count_doadores->execute();
        
        if(isset($_GET['id'])){ 
            if(isset($_GET['id_doacao'])){
                echo "<a href='controledoacao.php?id=$_GET[id]'>Retornar</a>";
                $doacao = $conn->prepare('SELECT * FROM `doacao` WHERE `id_doacao` = :id');
                $doacao->bindValue("id", $_GET['id_doacao']);
                $doacao->execute();
                $row = $doacao->fetch();

                $doador = $conn->prepare('SELECT * FROM `login` WHERE `id_user` = :id');
                $doador->bindValue(":id", $row['user_doador']);
                $doador->execute();

                $row_user = $doador->fetch();

                echo "<br><br>";
                echo "<img src='$row[img_doacao]' style='width: 300px; height: 250px;'> Validade: $row[validade_doacao]";
                echo "<br>Informações sobre o doador: <br>Usuário: $row_user[nome_user]<br>E-mail: $row_user[email_user]";

                ?>
                    <form action="controledoacao.php?id=<?php echo $_GET['id']?>&id_doacao=<?php echo $_GET['id_doacao']?>" method="post">
                        <button style="color: green;" name="aceitar">Aceitar</button>
                        <button style="color: red;" name="recusar">Recusar</button>
                    </form>
                <?php

                if(isset($_POST['recusar'])){

                    $recusar = $conn->prepare("UPDATE `doacao` SET `status_doacao` = 0, `id_validador` = :id_val WHERE `id_doacao` = :id");
                    $recusar->bindValue(":id", $_GET['id_doacao']);
                    $recusar->bindValue(":id_val", $user_id);
                    $recusar->execute();

                    header("location:controledoacao.php?id=$_GET[id]");
                }

                if(isset($_POST['aceitar'])){

                    $aceitar = $conn->prepare('UPDATE `doacao` SET `status_doacao` = 2, `id_validador` = :id_val WHERE `id_doacao` = :id');
                    $aceitar->bindValue(":id", $_GET['id_doacao']);
                    $aceitar->bindValue(":id_val", $user_id);
                    $aceitar->execute();

                    $aceitar = $conn->prepare('UPDATE `login` SET `posdoador_user` = 1 WHERE `id_user` = :id');
                    $aceitar->bindValue(":id", $_GET['id']);
                    $aceitar->execute();
                    
                    header("location:controledoacao.php?id=$_GET[id]");
                }
                exit();
            }else{
                echo "<a href='controledoacao.php'>Voltar</a>";

                $count_doacao = $conn->prepare("SELECT * FROM `doacao` WHERE `user_doador` = :id AND `status_doacao` = 1");
                $count_doacao->bindValue(":id", $_GET['id']);
                $count_doacao->execute();

                if($count_doacao->rowCount() == 0){
                    $change = $conn->prepare('UPDATE `login` SET `doador_user` = 0 WHERE `id_user` = :id');
                    $change->bindValue(":id", $_GET['id']);
                    $change->execute();

                    header("location:controledoacao.php");
                }

                while($row = $count_doacao->fetch()){
                    echo "<br> <hr> $row[id_doacao] - $row[nome_doacao] - $row[data_doacao] <br>";
                    echo "<img src='$row[img_doacao]' style='width: 200px; height: 150px'>";
                    echo "<a href='controledoacao.php?id=$_GET[id]&id_doacao=$row[id_doacao]'>Expandir</a>";
                }
            }
        }else{
            if($count_doadores->rowCount() > 0){
                while($row = $count_doadores->fetch()){
                    echo "<br><a href='controledoacao.php?id=$row[id_user]'>$row[nome_user]</a>";
                }
            }else{
                echo "<br>Sem dados para ser exibido";
            }
        }
    ?>
</body>