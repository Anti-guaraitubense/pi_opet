<?php 
    include_once 'config.php';
    include_once 'functions.php';
    session_start();
    if(!isset($_SESSION['id'])){
        goto_page("index.php");
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
    <title>Doasans</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/minhaconta.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
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
                <a href="minhaconta.php" class="deactive"><i class='bx bxs-user'></i></a>
                <a href="card.php" class="active"><i class='bx bxs-credit-card'></i></a>
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
                <form action="minhaconta.php" method="post">
                    <h2>CPF</h2>
                    <?php
                        if($info['cpf_user'] == NULL){
                            if(isset($_POST['change_cpf'])){
                                ?>
                                    <p><input type="number" name="cpf" class="input-bio"> <input type="submit" value="enviar" name="sub_cpf" class="btn"></p>
                                <?php
                            }else{
                                ?>
                                    <p>Insira seu CPF<button class="btn" name="change_cpf">Alterar</button></p>
                                <?php
                            }
                        }else{
                            $cpf_user =  $info['cpf_user'];
                            $cpf_user = array_map('intval', str_split($cpf_user));
                            
                            echo "<p>$cpf_user[0]$cpf_user[1]$cpf_user[2]-***-***.**</p>";
                        }
                        if(isset($_POST['sub_cpf'])){
                            $cpf = $_POST['cpf'];
                            $checkcpf = check_cpf($cpf);
                            
                            if($checkcpf == true){
                                $change_cpf = $conn->prepare('UPDATE `login` SET `cpf_user` = :cpf WHERE `id_user` = :id');
                                $change_cpf->bindValue(":cpf", $cpf);
                                $change_cpf->bindValue(":id", $id_user_atual);
                                $change_cpf->execute();

                                goto_page("minhaconta.php");
                            }else{
                                echo "<h5 class='error-cpf'>CPF Inválido</h5>";
                            }
                        }
                    ?>
                    <h2>Telefone</h2>
                    <?php
                        if($info['nmr_user'] == NULL){
                            if(isset($_POST['change_num'])){
                                ?>
                                    <p><input type="number" name="num" class="input-bio"> <input type="submit" value="enviar" name="sub_num" class="btn"></p>
                                <?php
                            }else{
                                ?>
                                    <p>Insira seu Número de Telefone<button class="btn" name="change_num">Alterar</button></p>
                                <?php
                            }
                        }else{
                            $num_user = $info['nmr_user'];
                            $num_user = array_map('intval', str_split($num_user));

                            echo "<p>($num_user[0]$num_user[1]) $num_user[2]$num_user[3]$num_user[4]$num_user[5]$num_user[6]-****</p>";
                        }
                        if(isset($_POST['sub_num'])){
                            $num = $_POST['num'];
                            $checknum = check_num($num);

                            if($checknum == true){
                                $change_num = $conn->prepare('UPDATE `login` SET `nmr_user` = :num WHERE `id_user` = :id');
                                $change_num->bindValue(":num", $num);
                                $change_num->bindValue(":id", $id_user_atual);
                                $change_num->execute();

                                goto_page("minhaconta.php");
                            }else{
                                echo "<h5 class='error-nmr'>Número Inválido</h5>";
                            }
                        }
                    ?>
                    <h2>Endereço</h2>
                    <?php 
                        if($info['cep_user'] == NULL){
                            if(isset($_POST['change_cep'])){
                            ?>
                                <p><input type="number" name="cep" class="input-bio"><input type="submit" value="enviar" name="sub_cep" class="btn"></p>
                            <?php
                            }else{
                                ?>
                                    <p>Insira seu CEP<button class="btn" name="change_cep">Alterar</button></p>
                                <?php
                            }
                            if(isset($_POST['sub_cep'])){
                                $cep = $_POST['cep'];

                                $ch = curl_init();
                                $link = "viacep.com.br/ws/$cep/json/";

                                curl_setopt($ch, CURLOPT_URL, $link);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                $data = curl_exec($ch);

                                $info_cep = json_decode($data);

                                if($info_cep != NULL && $info_cep->uf != NULL){
                                    
                                    $change_cep = $conn->prepare('UPDATE `login` SET `cep_user` = :cep WHERE `id_user` = :id');
                                    $change_cep->bindValue(":cep", $cep);
                                    $change_cep->bindValue(":id", $id_user_atual);
                                    $change_cep->execute();

                                    goto_page("minhaconta.php");
                                }else{
                                    echo "<h5 class='error-cep'>CEP inválido</h5>";
                                }
                            }
                        }else{

                            $cep_user = $info['cep_user'];
                            $endereco = get_address($cep_user);
                            $endereco = mb_strimwidth($endereco, 0, 20, "...");
                            $uf = get_uf($cep_user);
                            $bairro = get_district($cep_user);
                            
                            echo "<p>$endereco - $bairro - $uf</p>";
                        }
                    ?>
                </form>
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
                    goto_page("minhaconta.php");
                }
            ?>
                    </form>
                </div>
                <div class="pfp-box">
                    <form action="minhaconta.php" method="post" enctype="multipart/form-data">
                            <?php 
                                if(isset($_POST['change-pfp'])){
                                    ?>
                                    <label for="pfp" class="label-pfp">Arquivo</label>
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

                            goto_page("minhaconta.php");
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