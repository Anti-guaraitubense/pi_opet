<?php 
    include_once 'config.php';

    session_start();

    if(!isset($_SESSION['id'])){
        header("location:login.php");
    }

    $id_user = $_SESSION['id'];
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Doações</title>
    <link rel="stylesheet" type="text/css" href="css/doacao.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload();">
    <a href="index.php">Doasans</a>

    <form action="doacao.php" method="post" enctype="multipart/form-data">
        <div class="info-box">
            <input type="text" name="nome_prod" placeholder="Nome do produto">
            <input type="file" name="foto_prod" placeholder="Fotos do produto">
            <br>
            <input type="date" name="validade_prod" placeholder="Validade">
            <input type="submit" name="submit" value="Enviar">
        </div>
    </form>

    <?php

        if(isset($_POST['submit'])){

            $validade = $_POST['validade_prod'];
            $valarray = explode('-', $validade);
            $valarray = array_reverse($valarray);
            $valarray = join('/', $valarray);
            $validade = $valarray;

            $nome = $_POST['nome_prod'];

            $renomear = true;
            $pasta = 'img/doacoes/';

            $arq = $_FILES['foto_prod'];
            $arqnome = $_FILES['foto_prod']['name'];
            $arqnometemp = $_FILES['foto_prod']['tmp_name'];
            $tamanhoarq = $_FILES['foto_prod']['size'];
            $arqerro = $_FILES['foto_prod']['error'];
            $tipoarq = $_FILES['foto_prod']['type'];
            
            $arqext = explode('.', $arqnome);
            $arqext = end($arqext);
            $arqext = strtolower($arqext);
            $extfinal = '.'.$arqext;

            $tamanhomax = 1024*1024*2; // 2mb

            $allowext = array('png', 'jpg', 'jpeg');

            if(in_array($arqext, $allowext)){
                if($arqerro == 0){
                    if($tamanhoarq <= $tamanhomax){

                        $arq_novonome = ($renomear == true) ? time().$extfinal : $arqnome.$extfinal;
                        
                        $destino = $pasta.$arq_novonome;

                        move_uploaded_file($arqnometemp, $destino);

                        $doar = $conn->prepare('INSERT INTO `doacao` (nome_doacao, img_doacao, status_doacao, user_doador, validade_doacao) VALUES (:nome, :urlfoto, 1, :id, :val)');
                        $doar->bindValue(":nome", $nome);
                        $doar->bindValue(":urlfoto", $destino);
                        $doar->bindValue(":id", $id_user);
                        $doar->bindValue(":val", $validade);
                        $doar->execute();
                        
                        $change = $conn->prepare('UPDATE `login` SET `doador_user` = 1 WHERE `id_user` = :id');
                        $change->bindValue(":id", $id_user);
                        $change->execute();

                        header("location:index.php");
                    }
                    echo "Arquivo muito grande";
                }
                echo "Algo deu errado, tente novamente";
            }
            echo "Extensão não suportada";
        }
    ?>

</body>