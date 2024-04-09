<?php
    session_start();
    if(isset($_SESSION['id'])){
        $id_user_atual = $_SESSION['id'];
    }else{
        goto_page("index.php");
    }

    include 'config.php';
    include 'functions.php';

    $usercfg = $conn->prepare('SELECT * FROM `configuracao` WHERE `id_user_cfg` = :id;');
    $usercfg->bindValue(":id", $id_user_atual);
    $usercfg->execute();

    $usercfg = $usercfg->fetch();

    $theme_cfg = $usercfg['site_theme'];

?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Doasans</title>
    <script src="js/script.js"></script>
    <?php
        if(isset($_SESSION['id'])){
            if($theme_cfg == "dark_theme"){
                ?>
                <link rel="stylesheet" type="text/css" href="css/dark_theme/dark_theme_userconfig.css">
                <?php
            }else if($theme_cfg == "light_theme"){
                ?>
                <link rel="stylesheet" type="text/css" href="css/light_theme/light_theme_userconfig.css">
                <?php
            }
        }else{
            ?>
            <link rel="stylesheet" type="text/css" href="css/dark_theme/dark_theme_userconfig.css">
            <?php
        }
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body onload="evitar_dados_reload()";>
    <div class="container">
        <div class="leftbox">
            <nav>
                <a href="minhaconta.php" class="active"><i class='bx bxs-user'></i></a>
                <a href="card.php" class="active"><i class='bx bxs-credit-card'></i></a>
                <a href="userconfig.php" class="deactive"><i class='bx bxs-cog'></i></a>
                <a href="index.php" class="active"><i class='bx bx-arrow-back'></i></a>
            </nav>
        </div>

        <form action="" method="post" id="saveform">
            <div class="cfgbox">
                <legend class="leg">Tema do site</legend>

                <div class="option">
                    <?php 
                        if($theme_cfg == "dark_theme"){
                            ?>
                            <input type="radio" id="dark_theme" name="theme" value="dark_theme" checked />
                            <?php
                        }else{
                            ?>
                            <input type="radio" id="dark_theme" name="theme" value="dark_theme"/>
                            <?php
                        }
                    ?>
                    <label for="dark_theme">Escuro</label>
                </div>

                <div class="option">
                    <?php 
                        if($theme_cfg == "light_theme"){
                            ?>
                            <input type="radio" id="light_theme" name="theme" value="light_theme" checked />
                            <?php
                        }else{
                            ?>
                            <input type="radio" id="light_theme" name="theme" value="light_theme"/>
                            <?php
                        }
                    ?>
                    <label for="light_theme">Claro</label>
                </div>

                <button class="btnsave" name="savecfg">Salvar</button>
            </form>
        </div>
    </div>

    <?php 
        if(isset($_POST['savecfg'])){
            
            $theme = $_POST['theme'];
            
            if($theme != $theme_cfg){
                $update_theme = $conn->prepare("UPDATE `configuracao` SET `site_theme` = :theme WHERE id_user_cfg = :id");
                $update_theme->bindValue(":theme", $theme);
                $update_theme->bindValue(":id", $id_user_atual);
                $update_theme->execute();

                goto_page("userconfig.php");
            }
        }
    ?>
    
</body>
</html>