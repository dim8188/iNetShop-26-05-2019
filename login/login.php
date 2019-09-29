<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
    if(!empty($_POST)) {

        $pass=md5(md5($_POST['pass']));
        $login=$_POST['login'];

        $query="SELECT * FROM `users` 
                            WHERE `login`='$login'
                            AND `password`='$pass'
        ";

        $result=mysqli_query($link, $query);

        if(mysqli_num_rows($result) != 0) {
            $user=mysqli_fetch_assoc($result);

            session_start();
            $_SESSION['user_id']=$user['id'];

            header('location: '
                .$_SERVER['REQUEST_SCHEME'].'://'
                .$_SERVER['SERVER_NAME'].'/login/account.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход в личный кабинет</title>

    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <div class="sign-panel">
        <div class="sign-panel-inset">
            <a href="/" class="sign-panel-inset_logo"></a>
            <h1>Вход в личный кабинет</h1>
            <form method="POST" action="">
                <input type="text" name="login" placeholder="введите имя">
                <input type="password" name="pass" placeholder="введите пароль">
                <input type="submit" value="войти">
            </form>
        </div>
    </div>
</body>
</html>