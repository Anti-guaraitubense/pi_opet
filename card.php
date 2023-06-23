<?php
    session_start();
    if(isset($_SESSION['id'])){
        $id_user_atual = $_SESSION['id'];
    }else{
        header("location:index.php");
    }

    include 'config.php';
    include 'functions.php';
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Doasans</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" type="text/css" href="css/card.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body onload="evitar_dados_reload()";>
    <div class="container">
        <div class="leftbox">
            <nav>
                <a href="minhaconta.php" class="active"><i class='bx bxs-user'></i></a>
                <a href="card.php" class="deactive"><i class='bx bxs-credit-card'></i></a>
                <a href="#" class="active"><i class='bx bxs-cog'></i></a>
                <a href="index.php" class="active"><i class='bx bx-arrow-back'></i></a>
                
            </nav>
        </div>
        <div class="rightbox">
            <div class="profile">
                <h1>Cadastre seu cartão</h1>
                <div class="cartoes-box">
                <?php
                    $cartoes = $conn->prepare('SELECT * FROM `cartao` WHERE `id_user_cartao` = :id');
                    $cartoes->bindValue(":id", $id_user_atual);
                    $cartoes->execute();

                    if($cartoes->rowCount() > 0){
                        if(isset($_GET['more']) && $cartoes->rowCount() > 4){
                            while($row = $cartoes->fetch()){
                                $num_card = str_split($row['nmr_cartao'], 4);
                                $num_card = end($num_card);
                                ?>
                                    <img src="img/ccflags/mastercard.png" style="width: 40px; height: 25px; vertical-align: center;">
                                    <span class="cartoes">****-****-****-****-<?php echo $num_card?> Val: <?php echo $row['mesv_cartao']?> / <?php echo $row['anov_cartao']?></span>
                                    <br>
                                <?php
                            }
                        }else{
                            if($cartoes->rowCount() <= 4){
                                while($row = $cartoes->fetch()){
                                    $num_card = str_split($row['nmr_cartao'], 4);
                                    $num_card = end($num_card);
                                    ?>
                                        <img src="img/ccflags/mastercard.png" style="width: 40px; height: 25px; vertical-align: center;">
                                        <span class="cartoes">****-****-****-****-<?php echo $num_card?> Val: <?php echo $row['mesv_cartao']?> / <?php echo $row['anov_cartao']?></span>
                                        <br>
                                    <?php
                                }
                            }else if($cartoes->rowCount() > 4){
                                
                                $cartoes = $conn->prepare('SELECT * FROM `cartao` WHERE `id_user_cartao` = :id LIMIT 4');
                                $cartoes->bindValue(":id", $id_user_atual);
                                $cartoes->execute();
    
                                while($row = $cartoes->fetch()){
                                    $num_card = str_split($row['nmr_cartao'], 4);
                                    $num_card = end($num_card);
                                    ?>
                                        <img src="img/ccflags/mastercard.png" style="width: 40px; height: 25px; vertical-align: center;">
                                        <span class="cartoes">****-****-****-****-<?php echo $num_card?> Val: <?php echo $row['mesv_cartao']?> / <?php echo $row['anov_cartao']?></span>
                                        <br>
                                    <?php
                                }
                                ?>
                                    <a href="card.php?more">Clique aqui para ver mais</a>
                                <?php
                            }
                        } 
                    }
                ?>
                </div>
                <?php 
                    if(!isset($_GET['more'])){
                        ?>

                        <form action="card.php" method="post">
                        <div class="inputbox">
                            <span>Número de Cartão</span>
                            <input type="text" maxlength="16" class="card-number-input" name="card_num">
                        </div>
                        <div class="inputbox">
                            <span>Nome no Cartão</span>
                            <input type="text" maxlength="30" class="card-holder-input" name="card_name">
                        </div>
                        <div class="flexbox">
                            <div class="inputbox">
                                <span>Mês de Vencimento</span>
                                <select name="card_month" id="" class="month-input">
                                    <option value="month"select disabled>Mês</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="inputbox">
                                <span>Ano de Vencimento</span>
                                <select name="card_year" id="" class="year-input">
                                    <option value="year"select disabled>Ano</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                    <option value="2032">2032</option>
                                    <option value="2033">2033</ooption>
                                    <option value="2034">2034</option>
                                </select>
                            </div>
                            <div class="inputbox">
                                <span>CVV</span>
                                <input type="text" maxlength="3" class="cvv-input" name="card_cvv">
                            </div>
                        </div>
                        <button class="submit-btn" name="change">Enviar</button>
                        </form>

                        <?php
                    }
                ?>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_POST['change'])){
            $card_num = $_POST['card_num'];
            $card_name = $_POST['card_name'];
            $card_cvv = $_POST['card_cvv'];
            $card_month = $_POST['card_month'];
            $card_year = $_POST['card_year'];

            if(check_card($card_num, $card_name, $card_cvv, $card_month, $card_year)){
                
                $add_card = $conn->prepare('INSERT INTO `cartao` (`id_user_cartao`, `nome_cartao`, `nmr_cartao`, `mesv_cartao`, `anov_cartao`, `cvv_cartao`) 
                                                    VALUES (:id, :nome, :nmr, :mesv, :anov, :cvv);');
                $add_card->bindValue(":id", $id_user_atual);
                $add_card->bindValue(":nome", $card_name);
                $add_card->bindValue(":nmr", $card_num);
                $add_card->bindValue(":mesv", $card_month);
                $add_card->bindValue(":anov", $card_year);
                $add_card->bindValue(":cvv", $card_cvv);
                $add_card->execute();

                header("location:card.php");
            }else{
                echo "<h5>Informações incorretas</h5>";
            }
        }
    ?>
</body>
</html>