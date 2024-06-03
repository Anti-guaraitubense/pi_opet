<?php
    include_once 'functions.php';
    include_once 'config.php';
    $logado = false;
    session_start();
    if(isset($_SESSION['id'])){
        $logado = true;
        $id_user_atual = $_SESSION['id'];

        $usercfg = $conn->prepare('SELECT * FROM `configuracao` WHERE (id_user_cfg = :id);');
        $usercfg->bindValue(":id", $id_user_atual);
        $usercfg->execute();

        $usercfg = $usercfg->fetch();
        $theme_cfg = $usercfg['site_theme'];

        if(isset($_GET['logout'])){
            session_destroy();
            goto_page("index.php");
            exit();   
        }
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doasans</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.3.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <?php
        if(isset($_SESSION['id'])){
            if($theme_cfg == "dark_theme"){
                ?>
                <link rel="stylesheet" type="text/css" href="css/dark_theme/dark_theme_index.css">
                <?php
            }else if($theme_cfg == "light_theme"){
                ?>
                <link rel="stylesheet" type="text/css" href="css/light_theme/light_theme_index.css">
                <?php
            }
        }else{
            ?>
            <link rel="stylesheet" type="text/css" href="css/dark_theme/dark_theme_index.css">
            <?php
        }
    ?>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <script src="js/script.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
</head>
<body onload="evitar_dados_reload()";>
    <header>
        <a href="#" class="logo"><i class='bx bxs-package'></i></i>Doasans</a>
        
        <ul class="navlist">
            <li><a href="#home" class="active ">Inicío</a></li>
            <li><a href="#about">Sobre</a></li>
            <li><a href="doacao.php">Faça Sua Doação</a></li>
            <?php
            if($logado){
                ?>
                <li><a href="minhaconta.php">Sua conta  </a></li>
                <li><a href="index.php?logout">Logout</a></li>
                <?php
            }else{
                ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="registrar.php">Registrar</a></li>
                <?php
            }
            ?>
        </ul>

        <div class="nav-icons">
            <a href="#"><i class='bx bx-search'></i></a>
            <a href="#"><i class='bx bx-cart'></i></a>
            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>

    <section class="home" id="home">
        <div class="home-text">
            <h1>Doe, <span>Ajude &</span> <br> Faça uma Boa <br> ação</h1>
            <a href="doacao.php" class="btn">Faça sua Doação<i class='bx bxs-right-arrow'></i></a>
            <a href="askdonate.php" class="btn2">Peça uma Doação</a>
        </div>

        <div class="home-img">
            <img src="img/delivery.svg">
        </div>
    </section>

    <section class="container">
        <div class="container-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z" fill="rgba(0,255,136,1)"></path></svg>
            <h3>08:00 - 20:00</h3>
            <a href="#">Horário de Atendimento</a>
        </div>
        <div class="container-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3ZM20 7.23792L12.0718 14.338L4 7.21594V19H20V7.23792ZM4.51146 5L12.0619 11.662L19.501 5H4.51146Z" fill="rgba(0,255,136,1)"></path></svg>
            <h3>Entre em Contato</h3>
            <a href="#">doasansempresarial@gmail.com</a>
        </div>
        <div class="container-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12.001 9C10.3436 9 9.00098 10.3431 9.00098 12C9.00098 13.6573 10.3441 15 12.001 15C13.6583 15 15.001 13.6569 15.001 12C15.001 10.3427 13.6579 9 12.001 9ZM12.001 7C14.7614 7 17.001 9.2371 17.001 12C17.001 14.7605 14.7639 17 12.001 17C9.24051 17 7.00098 14.7629 7.00098 12C7.00098 9.23953 9.23808 7 12.001 7ZM18.501 6.74915C18.501 7.43926 17.9402 7.99917 17.251 7.99917C16.5609 7.99917 16.001 7.4384 16.001 6.74915C16.001 6.0599 16.5617 5.5 17.251 5.5C17.9393 5.49913 18.501 6.0599 18.501 6.74915ZM12.001 4C9.5265 4 9.12318 4.00655 7.97227 4.0578C7.18815 4.09461 6.66253 4.20007 6.17416 4.38967C5.74016 4.55799 5.42709 4.75898 5.09352 5.09255C4.75867 5.4274 4.55804 5.73963 4.3904 6.17383C4.20036 6.66332 4.09493 7.18811 4.05878 7.97115C4.00703 9.0752 4.00098 9.46105 4.00098 12C4.00098 14.4745 4.00753 14.8778 4.05877 16.0286C4.0956 16.8124 4.2012 17.3388 4.39034 17.826C4.5591 18.2606 4.7605 18.5744 5.09246 18.9064C5.42863 19.2421 5.74179 19.4434 6.17187 19.6094C6.66619 19.8005 7.19148 19.9061 7.97212 19.9422C9.07618 19.9939 9.46203 20 12.001 20C14.4755 20 14.8788 19.9934 16.0296 19.9422C16.8117 19.9055 17.3385 19.7996 17.827 19.6106C18.2604 19.4423 18.5752 19.2402 18.9074 18.9085C19.2436 18.5718 19.4445 18.2594 19.6107 17.8283C19.8013 17.3358 19.9071 16.8098 19.9432 16.0289C19.9949 14.9248 20.001 14.5389 20.001 12C20.001 9.52552 19.9944 9.12221 19.9432 7.97137C19.9064 7.18906 19.8005 6.66149 19.6113 6.17318C19.4434 5.74038 19.2417 5.42635 18.9084 5.09255C18.573 4.75715 18.2616 4.55693 17.8271 4.38942C17.338 4.19954 16.8124 4.09396 16.0298 4.05781C14.9258 4.00605 14.5399 4 12.001 4ZM12.001 2C14.7176 2 15.0568 2.01 16.1235 2.06C17.1876 2.10917 17.9135 2.2775 18.551 2.525C19.2101 2.77917 19.7668 3.1225 20.3226 3.67833C20.8776 4.23417 21.221 4.7925 21.476 5.45C21.7226 6.08667 21.891 6.81333 21.941 7.8775C21.9885 8.94417 22.001 9.28333 22.001 12C22.001 14.7167 21.991 15.0558 21.941 16.1225C21.8918 17.1867 21.7226 17.9125 21.476 18.55C21.2218 19.2092 20.8776 19.7658 20.3226 20.3217C19.7668 20.8767 19.2076 21.22 18.551 21.475C17.9135 21.7217 17.1876 21.89 16.1235 21.94C15.0568 21.9875 14.7176 22 12.001 22C9.28431 22 8.94514 21.99 7.87848 21.94C6.81431 21.8908 6.08931 21.7217 5.45098 21.475C4.79264 21.2208 4.23514 20.8767 3.67931 20.3217C3.12348 19.7658 2.78098 19.2067 2.52598 18.55C2.27848 17.9125 2.11098 17.1867 2.06098 16.1225C2.01348 15.0558 2.00098 14.7167 2.00098 12C2.00098 9.28333 2.01098 8.94417 2.06098 7.8775C2.11014 6.8125 2.27848 6.0875 2.52598 5.45C2.78014 4.79167 3.12348 4.23417 3.67931 3.67833C4.23514 3.1225 4.79348 2.78 5.45098 2.525C6.08848 2.2775 6.81348 2.11 7.87848 2.06C8.94514 2.0125 9.28431 2 12.001 2Z" fill="rgba(0,255,136,1)"></path></svg>
            <h3>Siga nas Redes Sociais</h3>
            <a href="#">@doasans</a>
        </div>
    </section>

    <section class="about" id="about">
        <div class="about-img">
            <img src="img/ajuda.svg">
        </div>
        <div class="about-text">
            <h2>Sempre pensando nos próximos.<br>Faça o mesmo você também!</h2>
            <p>Uma empresa que busca inovar e ajudar todos ao nosso alcance, inovando com o mais novo delivery de doação de comida, passando por uma rígida seleção para ver se o alimento está propício a ser doado de uma forma que não ira prejudicar a saúde de alguém. Venha e ajude você também, faça parte desse novo time!</p>
            <a href="#" class="btn">Explore o Site<i class='bx bxs-right-arrow'></i></a>
        </div>
    </section>
    
    <section class="review" id="review">
        <div class="middle-text">
            <h4>Nossos Consumidores</h4>
            <h2>Avaliações de Nossos Clientes</h2>
        </div>
        <div class="review-content">
            <div class="box">
                <p>Serviço muito bom, recomendo muito! Entrega rápida com um site fácil de usar, estão de parabéns!</p>
                <div class="in-box">
                    <div class="bx-img">
                        <img src="img/ft1.jpg">
                    </div>
                    <div class="bx-txt">
                        <h4>Gustavo Walk</h4>
                        <h5>Engenheiro de Software</h5>
                        <div class="ratings">
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <p>Consegui solicitar minha cesta básica, obrigado Doasans pela incrível forma de ajudar todos que consegue.</p>
                <div class="in-box">
                    <div class="bx-img">
                        <img src="img/ft2.jpg">
                    </div>
                    <div class="bx-txt">
                        <h4>Gabriel França Xiboquinha</h4>
                        <h5>Engenheiro de Software</h5>
                        <div class="ratings">
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <p>Bom atendimento, com grande qualidade geral, site com um visual bonito, com variações de uso e fácil de se usar.</p>
                <div class="in-box">
                    <div class="bx-img">
                        <img src="img/ft3.jpg">
                    </div>
                    <div class="bx-txt">
                        <h4>Neymar Jr</h4>
                        <h5>Jogador de Futebol</h5>
                        <div class="ratings">
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                            <a href="#"><i class="ri-star-fill"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="contact-content">
            <div class="contact-text">
                <h2>Redes Sociais</h2>
                <p>Fique por dentro de nossas redes sociais, onde noticiamos todas as mudanças dentro de nosso site!</p>
                <div class="social">
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="mailto:contato@doasansempresarial.com/"><i class='bx bxl-gmail'></i></a>
                    <a href="https://github.com/Anti-guaraitubense/pi_opet"><i class='bx bxl-github'></i></a>
                </div>
            </div>
            <div class="details">
                <div class="main-d">
                    <a href="https://github.com/gustawalk"><i class='bx bx-user'></i>Gustavo Walk</a>
                </div>
                <div class="main-d">
                    <a href="https://github.com/lgskrt"><i class='bx bx-user'></i>Luiz Weinhardt</a>
                </div>
                <div class="main-d">
                    <a href="#"><i class='bx bx-user'></i>Luis Ludwig</a>
                </div>
                <div class="main-d">
                    <a href="https://github.com/xiboquinha"><i class='bx bx-user'></i>Gabriel Menegaço</a>
                </div>
            </div>

            <!---
            <div class="contact-img">
                <div class="c-one">
                    <img src="img/playstore.png">
                </div>
                <div class="c-one">
                    <img src="img/applestore.png">
                </div>
            </div> -->
            
        </div>
    </section>

    <a href="#" class="scroll"><i class='bx bx-up-arrow-alt'></i></a>
    
    
    <?php
        if(isset($_POST['my-acc'])){

            goto_page("minhaconta.php");
            exit();
        }

        if(isset($_POST['logout'])){

            session_destroy();
            goto_page("index.php");
            exit();
        }

        if($logado){
            
            $infos = $conn->prepare('SELECT * FROM `login` WHERE id_user = :id');
            $infos->bindValue(":id", $id_user_atual);
            $infos->execute();

            $info = $infos->fetch();
            $nome_fix = ucfirst($info['nome_user']);

            ?>
            <?php
        }
    ?>
</body>
</html>