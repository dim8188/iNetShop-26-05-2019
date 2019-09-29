<?php 

    include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/config/functions.php');

    // session_start();  для проврки зароса sql использолвали

    if(isset($_SESSION['user_id'])) {
        $userData=getUserData($link, $_SESSION['user_id']);
    }
    
    // echo $_SESSION['test']; для проверки sql запроса  в catalogHandler.php
    
    $query = "SELECT category FROM `categories` c WHERE c.`parent_id` = 0 ORDER by c.`id`";
    $result = mysqli_query($link, $query);
    $menu = '';


    while ($row = mysqli_fetch_assoc($result)) {

        $menu .= "
            <a href=\"/\" class=\"nav-link\">{$row['category']}</a> <br>
        ";     
      
    };

    // session_destroy();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <header class="wrapper">
        <div class="menu-links">
            <a href="/" class="logo"></a>
            <nav>
                
                <?php
                    echo $menu;
                ?>

            </nav>
        </div>
        <div class="purchase">
            <div class="customer">
                <div class="customer_pic"></div>
                <div class="customer_name">
                    
                    <?php if(isset($_SESSION['user_id'])): ; ?>
                    Привет, <?=$userData['name']; ?>! 
                    (<a href="/login/account.php" class="login">личный кабинет</a>)
                    <?php else: ; ?>
                    (<a href="/login/login.php" class="login">войти</a>)
                    <?php endif; ?>
                </div>
            </div>
            <div class="basket">
                <div class="basket_pic"></div>
                <div class="basket_data">
                    Корзина (5)
                </div>
            </div>
        </div>
    </header>

    <div class="header-underline wrapper">
        <hr>
    </div>

    <div class="sandbox wrapper">
        <a href="/">ГЛАВНАЯ</a> / <a href="/">MУЖЧИНАМ</a>
    </div>