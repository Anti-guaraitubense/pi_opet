<?php
    session_start();
    include_once 'config.php';
    include_once 'functions.php';

    if(!isset($_SESSION['id'])){
        goto_page("login.php");
    }else{
        $id_user_atual = $_SESSION['id'];
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Doasans</title>
        <link rel="stylesheet" type="text/css" href="css/askdonate.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <script src="js/donate.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="item">
                <div class="contact">
                    <div class="first-text">Entre em contato</div>
                    <img src="img/message.svg" class="image">
                    <div class="social-links">
                        <span class="second-text">Siga nas redes sociais</span>
                        <ul class="social-media">
                            <li><a href="#"><i class='bx bxl-instagram'></i></a></li>
                            <li><a href="mailto:contato@doasansempresarial.com/"><i class='bx bxl-gmail'></i></a></li>
                            <li><a href="#"><i class='bx bxl-twitter'></i></a></li>
                            <li><a href="https://github.com/Anti-guaraitubense/pi_opet"><i class='bx bxl-github'></i></a></li>
                            <button class="btn1"><a href="index.php">Voltar</a></button>
                        </ul>
                        <button class="btn">Enviar</button>
                    </div>
                </div>
                    <div class="submit-form">
                        <h4 class="third-text">Faça seu pedido!</h4>
                        <form action="https://formsubmit.co/doasansempresarial@gmail.com" method="POST">
                            <div class="input-box">
                                <input type="text" name="name" class="input" required>
                                <label for="">Nome</label>
                            </div>
                            <div class="input-box">
                                <input type="email" name="email" class="input" required>
                                <label for="">E-mail</label>
                            </div>
                            <div class="input-box">
                                <input type="tel" name="tel" class="input" required>
                                <label for="">Telefone</label>
                            </div>
                            <div class="input-box">
                                <textarea name="text" id="message" class="input" cols="30" rows="10" required></textarea>
                                <label for="">Seu pedido</label>
                            </div>
                            <button class="btn" type="submit">Enviar</button>
                        </form>
                    </div>

            </div>
        </div>
    </body>
</html>