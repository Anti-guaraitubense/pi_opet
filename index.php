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

    <div class="reg-acc">
        <a href="login.php">Login</a>
        <a href="registrar.php">Registrar</a>
    </div>

    <form action="index.php" method="post">
        <input type="submit" value="Apagar sessão" name="del_ses">
    </form>

    <?php 

        session_start();
        
        if(isset($_POST['del_ses'])){

            session_destroy();
            exit();
        }

        if(isset($_SESSION['id'])){

            $id = $_SESSION['id'];

            echo "<h1> BEM VINDO $id!!";
        }
    ?>
</body>
</html>