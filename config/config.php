<?php 

    $link = mysqli_connect('localhost', 'root', '', 'shop_26_05_2019_kislyakov');
    mysqli_set_charset($link, 'utf8');

    if(!$link) {
        echo 'Не удалось подключиться к базе данных!';
    }
    
?>
