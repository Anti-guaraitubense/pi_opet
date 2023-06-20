<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <title>Doasans</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/card.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body onload="evitar_dados_reload()";>
    <div class="container">
        <div class="leftbox">
            <nav>
                <a href="minhaconta.php" class="active"><i class='bx bxs-user'></i></a>
                <a href="card.php" class="active"><i class='bx bxs-credit-card'></i></a>
                <a href="#" class="active"><i class='bx bxs-cog'></i></a>
                <a href="index.php" class="active"><i class='bx bx-arrow-back'></i></a>
                
            </nav>
        </div>
        <div class="rightbox">
            <div class="profile">
                <h1>Cadastre seu cartão</h1>
                <form action="">
                <div class="inputbox">
                    <span>Número de Cartão</span>
                    <input type="text" maxlength="16" class="card-number-input">
                </div>
                <div class="inputbox">
                    <span>Nome no Cartão</span>
                    <input type="text" class="card-holder-input">
                </div>
                <div class="flexbox">
                    <div class="inputbox">
                        <span>Mês de Vencimento</span>
                        <select name="" id="" class="month-input">
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
                        <select name="" id="" class="year-input">
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
                        <input type="text" maxlength="3" class="cvv-input">
                    </div>
                </div>
                <button class="submit-btn" name="change">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>