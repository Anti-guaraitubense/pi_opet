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
    
    if($perm <= 0){
        goto_page("index.php");
        exit();
    }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/controledoacao.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body onload="evitar_dados_reload();">

    <a href="index.php" class="logo"><i class='bx bxs-package'></i></i>Doasans</a>

    <?php 
        $count_doadores = $conn->prepare('SELECT * FROM `login` WHERE `doador_user` = 1');
        $count_doadores->execute();
        
        if(isset($_GET['id'])){ 
            if(isset($_GET['id_doacao'])){
                echo "<a href='controledoacao.php?id=$_GET[id]' class='voltar-link'>Voltar</a>";
                $doacao = $conn->prepare('SELECT * FROM `doacao` WHERE `id_doacao` = :id');
                $doacao->bindValue("id", $_GET['id_doacao']);
                $doacao->execute();
                $row = $doacao->fetch();

                $doador = $conn->prepare('SELECT * FROM `login` WHERE `id_user` = :id');
                $doador->bindValue(":id", $row['user_doador']);
                $doador->execute();

                $row_user = $doador->fetch();

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
                <form action='controledoacao.php?id=$_GET[id]&id_doacao=$_GET[id_doacao]' method='post'>
                        <br>
                        <button style='color: green;' name='aceitar'>Aceitar</button>
                        <button style='color: red;' name='recusar'>Recusar</button>
                </form>
                </div>
                ";

                if(isset($_POST['recusar'])){

                    $recusar = $conn->prepare("UPDATE `doacao` SET `status_doacao` = 0, `id_validador` = :id_val WHERE `id_doacao` = :id");
                    $recusar->bindValue(":id", $_GET['id_doacao']);
                    $recusar->bindValue(":id_val", $user_id);
                    $recusar->execute();

                    goto_page("controledoacao.php?id=$_GET[id]");
                }

                if(isset($_POST['aceitar'])){

                    $aceitar = $conn->prepare('UPDATE `doacao` SET `status_doacao` = 2, `id_validador` = :id_val WHERE `id_doacao` = :id');
                    $aceitar->bindValue(":id", $_GET['id_doacao']);
                    $aceitar->bindValue(":id_val", $user_id);
                    $aceitar->execute();

                    $aceitar = $conn->prepare('UPDATE `login` SET `posdoador_user` = 1 WHERE `id_user` = :id');
                    $aceitar->bindValue(":id", $_GET['id']);
                    $aceitar->execute();
                    
                    goto_page("controledoacao.php?id=$_GET[id]");
                }
                exit();
            }else{
                echo "<a href='controledoacao.php' class='voltar-link'>Voltar</a>";

                $count_doacao = $conn->prepare("SELECT * FROM `doacao` WHERE `user_doador` = :id AND `status_doacao` = 1");
                $count_doacao->bindValue(":id", $_GET['id']);
                $count_doacao->execute();

                if($count_doacao->rowCount() == 0){
                    $change = $conn->prepare('UPDATE `login` SET `doador_user` = 0 WHERE `id_user` = :id');
                    $change->bindValue(":id", $_GET['id']);
                    $change->execute();

                    goto_page("controledoacao.php");
                }

                while($row = $count_doacao->fetch()){
                    ?>
                    <div class="doacoes-block">
                        <br>
                        <span><?php echo "$row[id_doacao]"; ?> - <?php echo "$row[nome_doacao]"; ?> - <?php echo "$row[data_doacao]"; ?></span>
                        <br>
                        <img src="<?php echo "$row[img_doacao]"; ?>" class="imgs">
                        <a href="controledoacao.php?id=<?php echo "$_GET[id]"; ?>&id_doacao=<?php echo "$row[id_doacao]"; ?>" class="expd-link">Expandir</a>
                    </div>
                    <?php
                }
            }
        }else{
            echo "<a href='minhaconta.php' class='voltar-link'>Sua conta</a>";
            if($count_doadores->rowCount() > 0){
                ?>
                    <h1 class="sub-name">Área de controle de doações</h1>
                <?php
                while($row = $count_doadores->fetch()){
                    echo "<br><a href='controledoacao.php?id=$row[id_user]' class='user-name'>$row[nome_user]</a>";
                }
            }else{
                echo "<h1 class='no-data'>Sem dados para exibir</h1>";
            }
        }
    ?>
</body>