<?php 
    include_once 'config.php';

    session_start();

    if(!isset($_SESSION['id'])){
        header("location:index.php");
        exit();
    }
    $user_id = $_SESSION['id'];

    $infosuser = $conn->prepare('SELECT * from `login` WHERE id_user = :id');
    $infosuser->bindValue(":id", $user_id);
    $infosuser->execute();

    $info = $infosuser->fetch();

    if($info['user_perm'] <= 0){
        header("location:minhaconta.php");
        exit();
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de doações</title>
    <link rel="stylesheet" type="text/css" href="css/controledoacao.css">
    <script src="js/script.js"></script>
</head>
<body onload="evitar_dados_reload();">

    <?php 
        $count_doacao = $conn->prepare("SELECT * FROM `doacao` WHERE 1");
        $count_doacao->execute();

        while($row = $count_doacao->fetch()){
            echo "$row[user_doador] - $row[nome_doacao] <br>";
        }
    ?>
</body>