<?php 

    $title="Личный кабинет";

    include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/config/functions.php');

    session_start();

    $userData=checkLoginUser($link);

    include_once($_SERVER['DOCUMENT_ROOT'].'/modules/header.php');
?>

    <div class="lk-panel wrapper">
        <h1>Личный кабинет</h1>
        <p>Привет, <?=$userData['name']; ?>!</p>
    </div>
    


<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php');
?>

</body>
</html>