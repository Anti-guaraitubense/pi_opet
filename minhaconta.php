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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minha conta</title>
</head>
<body>
    <a href="index.php">Nome do site</a>
    <?php 
        echo "Você tem $info[score_user] pontos acumulados no site!";
    ?>
</body>
</html>