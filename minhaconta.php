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
            $perm_nome = "admin";
            break;
        case 2:
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minha conta</title>
    <link rel="stylesheet" href="css/minhaconta.css" type="text/css">
</head>
<body onload="evitar_dados_reload()";>
    <a href="index.php">Doasans</a>
    <?php 
        echo "<div class='texto'>Você tem $info[score_user] pontos acumulados no site!</div>";
        if($perm != 0){
            echo "<div class='texto'>Sua permissão é de nível $perm_nome, acesse aqui o site de <a href='controledoacao.php'>controle de doações</a></div>";
        }
        ?>
            <img class="pfp" src="<?php echo $info_foto['url_foto'] ?>">
        <?php
    ?>
    <div class="bio-box">
        <form action="minhaconta.php" method="post">
            <?php 
                if(isset($_POST['change-bio'])){

                    ?>
                        <input type="text" name="new-bio" placeholder="Nova biografia" autocomplete="off" value="<?php echo "$info_bio[user_bio]"; ?>">
                        <button class="confirm-bio" name="confirm-bio">Salvar alterações</button>
                    <?php
                }
                else{
                    ?>
                        <h4>
                            <?php echo "<div class='texto'>$info_bio[user_bio]</div>"; ?>  
                        </h4>   
                        <button class="change-bio" name="change-bio">Alterar biografia</button>
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

    <form action="minhaconta.php" method="post" enctype="multipart/form-data">
        <input type="file" name="pfp">
        <button type="submit" name="submit">Carregar foto</button>
    </form>

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
                        echo "Arquivo muito grande";
                    }
                }else{
                    echo "Algo deu errado, tente novamente";
                }
            }else{
                echo "Extensão não suportada";
            }
        }

    ?>
</body>
</html>