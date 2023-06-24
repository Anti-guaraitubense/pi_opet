<?php 
    include_once 'functions.php';
    include_once 'config.php';

    session_start();
    if(!isset($_SESSION['id'])){
        goto_page("login.php");
    }

    $id_user = $_SESSION['id'];
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link rel="stylesheet" type="text/css" href="css/doacao.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="js/script.js"></script>
</head>
<body defer onload="evitar_dados_reload();" onchange="check_files('label_foto_prod', 'foto_prod', 'label_foto_val', 'foto_val', '#B31700');">
<div class="container">
    <div class="item">
        <div class="contact">
                    <div class="first-text">Entre em contato</div>
                    <img src="img/message.svg" class="image">
                    <div class="social-links">
                        <span class="second-text">Siga nas redes sociais</span>
                        <ul class="social-media">
                            <li><a href="#"><i class='bx bxl-instagram'></i></a></li>
                            <li><a href="mailto:contato@doasansempresarial.com/"><i class='bx bxl-gmail'></i></a></li>
                            <li><a href="#"><i class='bx bxl-twitter'></i></a></li>
                            <li><a href="https://github.com/Anti-guaraitubense/pi_opet"><i class='bx bxl-github'></i></a></li>
                            <button class="btn1"><a href="index.php">Voltar</a></button>
                        </ul>
                    </div>
                </div>
                    <div class="submit-form">
                        <h4 class="third-text">Faça sua Doação!</h4>
                        <form action="doacao.php" method="post" enctype="multipart/form-data">
                            <div class="input-box">
                                <input type="text" class="input" name="nome_prod" placeholder="Nome do produto" required>
                            </div>
                            <div class="input-box">
                                    <label for="foto_prod" class="label-pfp input" id="label_foto_prod">Foto do produto</label>
                                    <input type="file" class="input-arq" name="foto_prod" id="foto_prod">
                            </div>
                            <div class="input-box">
                                <input type="date" class="input" name="validade_prod" placeholder="Validade" required>
                            </div>
                            <div class="input-box">
                                    <label for="foto_val" class="label-pfp input" id="label_foto_val">Foto da validade</label>
                                    <input type="file" class="input-arq" name="foto_val" id="foto_val">
                            </div>
                            <button class="btn" type="submit" name="submit">Enviar</button>
                        </form>
                    </div>
    </div>
</div>
    <?php

        if(isset($_POST['submit'])){

            $validade = $_POST['validade_prod'];
            $valarray = explode('-', $validade);
            $valarray = array_reverse($valarray);
            $valarray = join('/', $valarray);
            $validade = $valarray;

            $nome = $_POST['nome_prod'];

            if(!$validade == "" && !$_FILES['foto_prod']['name'] == "" && !$nome == "" && !$_FILES['foto_val']['name'] == ""){
                $renomear = true;
                $pasta = 'img/doacoes/';
                $pasta_val = 'img/validades/';
    
                #foto produto
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
                
                #foto validade
                $arq_val = $_FILES['foto_val'];
                $arqnome_val = $_FILES['foto_val']['name'];
                $arqnometemp_val = $_FILES['foto_val']['tmp_name'];
                $tamanhoarq_val = $_FILES['foto_val']['size'];
                $arqerro_val = $_FILES['foto_val']['error'];
                $tipoarq_val = $_FILES['foto_val']['type'];
                
                $arqext_val = explode('.', $arqnome_val);
                $arqext_val = end($arqext_val);
                $arqext_val = strtolower($arqext_val);
                $extfinal_val = '.'.$arqext_val;
    
                $tamanhomax = 1024*1024*2; // 2mb
    
                $allowext = array('png', 'jpg', 'jpeg');
    
                if(in_array($arqext, $allowext) && in_array($arqext_val, $allowext)){
                    if($arqerro == 0 && $arqerro_val == 0){
                        if($tamanhoarq <= $tamanhomax && $tamanhoarq_val <= $tamanhomax){
    
                            $arq_novonome = ($renomear == true) ? time().$extfinal : $arqnome.$extfinal;
                            $arq_novonome_val = $arq_novonome;

                            $destino = $pasta.$arq_novonome;
                            $destino_val = $pasta_val.$arq_novonome_val;
    
                            move_uploaded_file($arqnometemp, $destino);
                            move_uploaded_file($arqnometemp_val, $destino_val);

                            $doar = $conn->prepare('INSERT INTO `doacao` (nome_doacao, img_doacao, img_validade, status_doacao, user_doador, validade_doacao, data_doacao)
                                                    VALUES (:nome, :urlfoto, :urlvalidade, 1, :id, :val, :data_doacao)');
                            $doar->bindValue(":nome", $nome);
                            $doar->bindValue(":urlfoto", $destino);
                            $doar->bindValue(":urlvalidade", $destino_val);
                            $doar->bindValue(":id", $id_user);
                            $doar->bindValue(":val", $validade);
                            $doar->bindvalue(":data_doacao", date('d/m/Y'));
                            $doar->execute();
                            
                            $change = $conn->prepare('UPDATE `login` SET `doador_user` = 1 WHERE `id_user` = :id');
                            $change->bindValue(":id", $id_user);
                            $change->execute();
    
                            goto_page("index.php");
                        }
                        echo "Arquivo muito grande";
                    }
                    echo "Algo deu errado, tente novamente";
                }
                echo "Extensão não suportada";
            }
            echo "Informações invalidas";
        }
    ?>

</body>
