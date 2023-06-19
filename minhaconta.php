<?php 
    include_once 'config.php';
    session_start();
    if(!isset($_SESSION['id'])){
        header("location:index.php");
        exit();
    }
    $id_user_atual = $_SESSION['id'];
    $infos = $conn->prepare('SELECT * FROM `login` WHERE id_user = :id');
    $infos->bindValue(":id", $id_user_atual);
    $infos->execute();

    $info = $infos->fetch();
    $perm = $info['user_perm'];
    $perm_nome = "";
    switch($perm){
        case 1:
            $perm_nome = "avaliador";
            break;
        case 2:
            $perm_nome = "administrador";
            break;
        case 3:
            $perm_nome = "dono";
            break;
        default:
            $perm = 0;
    }

    $infos_bio = $conn->prepare('SELECT * FROM `bio` WHERE id_bio = :id');
    $infos_bio->bindValue(":id", $id_user_atual);
    $infos_bio->execute();

    $info_bio = $infos_bio->fetch();

    $infos_foto = $conn->prepare('SELECT * FROM `fotoperfil` WHERE id_foto = :id');
    $infos_foto->bindValue(":id", $id_user_atual);
    $infos_foto->execute();

    $info_foto = $infos_foto->fetch();
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Minha conta</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/minhaconta.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body onload="evitar_dados_reload()";>
    <div class="container">
        <div id="logo">
            <h1 class="logo">Doasans</h1>
            <div class="CTA">
                <div class="img-box">
                <img class="pfp" src="<?php echo $info_foto['url_foto'] ?>">
                </div>
            </div>
        </div>
        <div class="leftbox">
            <nav>
                <a href="#" class="active"><i class='bx bxs-user'></i></a>
                <a href="#" class="active"><i class='bx bxs-credit-card'></i></a>
                <a href="#" class="active"><i class='bx bxs-cog'></i></a>
                <a href="index.php" class="active"><i class='bx bx-arrow-back'></i></a>
                
            </nav>
        </div>
        <div class="rightbox">
            <div class="profile">
                <h1>Informações Pessoais</h1>
                <h2>Usuário</h2>
                <?php 
                echo "<p>$info[nome_user]</p>"
                ?>
                <h2>Pontuação</h2>
                <?php 
                echo "<p>Você tem $info[score_user] pontos acumulados no site!</p>"
                ?>
                <h2>Senha</h2>
                <p>******<button class="btn">Alterar</button></p>
                <h2>Telefone</h2>
                <p>Insira seu Número de Telefone<button class="btn">Alterar</button></p>
                <?php 
                if($perm > 0){
                    echo "<h2>Permissão</h2>";
                    echo "<p>Sua permissão é de nível $perm_nome, acesse aqui a área do <a href='controledoacao.php' class='page-link'>painel de doações</a></p>";
                if($perm >= 2){
                    echo "<p>E acesse aqui o <a href='posdoacao.php' class='page-link'>painel de pós doação</a></p>";
            }
        }
        ?>
                <div class="bio-box">
                    <form action="minhaconta.php" method="post">
                        <?php 
                            if(isset($_POST['change-bio'])){
                        ?>
                        <input type="text" name="new-bio" placeholder="Nova biografia" autocomplete="off" value="<?php echo "$info_bio[user_bio]"; ?>" class="input-bio">
                        <button class="btn btn-bio" name="confirm-bio">Salvar alterações</button>
                    <?php
                }
                else{
                    ?>
                        <h4>
                            <?php echo "<div class='bio-text'>$info_bio[user_bio]</div>"; ?>  
                        </h4>   
                        <button class="btn" name="change-bio">Alterar biografia</button>
                    <?php
                }
                if(isset($_POST['confirm-bio'])){
                    
                    $newbio = $conn->prepare('UPDATE `bio` SET `user_bio` = :newbio WHERE id_bio = :id');
                    $newbio->bindValue(":newbio", $_POST['new-bio']);
                    $newbio->bindValue(":id", $id_user_atual);
                    $newbio->execute();
                    header("location:minhaconta.php");
                }
            ?>
                    </form>
                </div>
                <div class="pfp-box">
                    <form action="minhaconta.php" method="post" enctype="multipart/form-data">
                            <?php 
                                if(isset($_POST['change-pfp'])){
                                    ?>
                                    <label for="pfp">Arquivo</label>
                                    <input type="file" class="input-pfp" name="pfp" id="pfp">
                                    <button class="btn btn-change-pfp" type="submit" name="submit">Carregar foto</button>
                                    <?php
                                }else{
                                    ?>
                                    <button class="btn btn-pfp" type="submit" name="change-pfp">Alterar foto</button>
                                    <?php
                                }
                            ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <?php
    ?>
    <?php 
        if(isset($_POST['submit'])){
            $renomear = true;
            $pasta = 'img/pfp/';

            $arq = $_FILES['pfp'];
            $arqnome = $_FILES['pfp']['name'];
            $arqnometemp = $_FILES['pfp']['tmp_name'];
            $tamanhoarq = $_FILES['pfp']['size'];
            $arqerro = $_FILES['pfp']['error'];
            $tipoarq = $_FILES['pfp']['type'];

            $arqext = explode('.', $arqnome);
            $arqext = end($arqext);
            $arqext = strtolower($arqext);
            $extfinal = '.'.$arqext;
        

            $tamanhomax = 1024*1024*2; // 2mb

            $allowext = array('png', 'jpg', 'jpeg');
            
            if($tipoarq != "" && $arqnome != ""){
                if(in_array($arqext, $allowext)){
                    if($arqerro == 0){
                        if($tamanhoarq < $tamanhomax){
                            $arq_novonome = ($renomear == true) ? time().$extfinal : $arqnome.$extfinal;

                            $destino = $pasta.$arq_novonome;

                            move_uploaded_file($arqnometemp, $destino);

                            $alt_foto = $conn->prepare('UPDATE `fotoperfil` SET `url_foto` = :urlfoto WHERE id_foto = :id');
                            $alt_foto->bindValue(":id", $id_user_atual);
                            $alt_foto->bindValue(":urlfoto", $destino);
                            $alt_foto->execute();

                            header("location:minhaconta.php");
                        }else{
                            echo "<h5 class='error-text'>Arquivo muito grande</h5>";
                        }
                    }else{
                        echo "<h5 class='error-text'>Algo deu errado, tente novamente</h5>";
                    }
                }else{
                    echo "<h5 class='error-text'>Extensão não suportada</h5>";
                }
            }
    }

    ?>
</body>
</html>