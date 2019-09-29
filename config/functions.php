<?php 

    function d($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';

        return true;
    }

    function getUserData($link, $id) {
        $query="SELECT * FROM `users` WHERE `id`=$id";
        $result=mysqli_query($link, $query);
        $result=mysqli_fetch_assoc($result);

        return $result;
    }

    function checkLoginUser($link) {
        if(isset($_SESSION['user_id'])) {
            $userData=getUserData($link, $_SESSION['user_id']);
            return $userData;
        } else {
            header('location: ' 
                    .$_SERVER['REQUEST_SCHEME'].'://'
                    .$_SERVER['SERVER_NAME'].'/login/login.php');
            return false;
        }
    }
?>