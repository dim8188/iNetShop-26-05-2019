<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
    // session_start(); для проверки sql

    sleep(3);
    $conditions = '';
    $price = '';
    $category_id = '';
    $size_id = '';
    if ( !empty($_GET['price']) && isset($_GET['price'])) {
        
        $price=$_GET['price'];
        $price_array = explode('-', $price);

        // if ( count($price_array) == 2 ) {
        //     $conditions = "WHERE `price` BETWEEN {$price_array[0]} AND {$price_array[1]}";
        // } else {
        //     $conditions = "WHERE `price` >= {$price_array[0]}";
        // }

        if ( count($price_array) == 2 ) {
            $price = " BETWEEN {$price_array[0]} AND {$price_array[1]}";
        } else {
            $price = " >= {$price_array[0]}";
        }

        $conditions = "ctl.`price` {$price}";

    }
    
    if (!empty($_GET['size']) && isset($_GET['size']) ) {
          
        if ($conditions) {
            $conditions .= " AND s.`id` = {$_GET['size']}";
        } else {
            $conditions = " s.`id` = {$_GET['size']}";
        }
    }

    if (!empty($_GET['category']) && isset($_GET['category'])) {

        if ($conditions) {
            $conditions .= " AND ctl.`category` = {$_GET['category']}"; 
        } else {
            $conditions = " ctl.`category` = {$_GET['category']}"; 
        }
        

    }

    if ($conditions) {

        $conditions = ' WHERE ' . $conditions;
           
    } else {

        echo 'По данному запросу ничего не найдено.';
    }




    // quantity
    // id --- catalog_id --- size_id --- quantity
    // 1           2            1           4
    // 2           2            2           15


    // explode();
    // implode();

    $count_products_on_page=4;

    if(!empty($_GET['numPage'])) {
        $now_page=$_GET['numPage'];
    }

    $start_row=($now_page-1)*$count_products_on_page;

    // $count_sql="SELECT * FROM `catalog` $conditions";
    
    $count_sql="
        SELECT ctl.*,
        categ.`category` AS `cat`,
        q.`size_id`,
        q.`quantity`,
        s.`size`
            FROM `catalog` ctl
            LEFT JOIN `categories` categ
            ON categ.`id` = ctl.`category`
            LEFT JOIN `quantity` q
            ON q.`catalog_id` = ctl.`id`
            LEFT JOIN `sizes` s
            ON s.`id` = q.`size_id` 
            {$conditions}
            
        ";
            
            // echo $count_sql;
            // WHERE ctl.`category` = {$category_id} 
            // AND ctl.`price` {$conditions}
            // AND s.id = {$size_id}
        

    $result_count = mysqli_query($link, $count_sql);
    $count_pages=ceil(mysqli_num_rows($result_count)/$count_products_on_page);

    $query = " 
        SELECT ctl.*,
        categ.`category` AS `cat`,
        q.`size_id`,
        q.`quantity`,
        s.`size`
            FROM `catalog` ctl
            LEFT JOIN `categories` categ
            ON categ.`id` = ctl.`category`
            LEFT JOIN `quantity` q
            ON q.`catalog_id` = ctl.`id`
            LEFT JOIN `sizes` s
            ON s.`id` = q.`size_id` 
            {$conditions}  limit {$start_row}, {$count_products_on_page}
    ";

    // $_SESSION['test'] =  $query; для проверки sql
    
    //$data = [ 'products'=> $query];
    // if ($result) {
        $result = mysqli_query($link, $query);
    // }
    

    $data=[
        'products'=> [],
        'pagination'=> [
            'countPages'=> $count_pages,
            'nowPage'=> $now_page
        ]
    ];

    while( $row = mysqli_fetch_assoc($result) ) {
        array_push($data['products'], $row);
    }

    echo json_encode($data);
?>