<?php
    $logado = false;
    session_start();
    if(isset($_SESSION['id'])){
        $logado = true;
        $id_user_atual = $_SESSION['id'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nome foda</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload()";>
    <a href="#" class="logo">Nome do site</a>

    <?php 

        if($logado){
        ?>
            <div class="my-acc">
                <a href="#" class="sua-conta">Sua Conta</a>
            </div>
                
            <form action="index.php" method="post">
                <div class="logout-box">
                    <input type="submit" value="Logout" name="logout" class="logout">
                </div>
            </form>
        <?php 
        }else{
        ?>
            <div class="reg-acc">
                <a href="login.php">Login</a>
                <a href="registrar.php">Registrar</a>
            </div>
        <?php
        }
    ?>

    <?php 
        
        if(isset($_POST['logout'])){

            session_destroy();
            header("location:index.php");
            exit();
        }

        if($logado){

            echo "<h1> BEM VINDO $id_user_atual!!";
        }
    ?>
</body>
</html>