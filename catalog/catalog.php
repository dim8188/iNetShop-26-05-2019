<?php 

    $title="Каталог товаров";

    // session_start();

    include_once($_SERVER['DOCUMENT_ROOT'].'/modules/header.php');

    include_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/config/functions.php');

    if(isset($_SESSION['user_id'])) {
        $userData=getUserData($link, $_SESSION['user_id']);
    }
     
    $query = "select  (@pv := concat(@pv, ',', id)) as tree,
                (@pcat := concat(@pcat, ',', category)) AS categ
            from    (select * from `categories`
            order by parent_id, id) categories_sorted,
            (select @pv := '1') initialisation,
            (select @pcat := '') 

            init_categories
            where   find_in_set(parent_id, @pv)
            and     length(concat(@pv, ',', id))
            ORDER BY tree desc LIMIT 1";

    $result = mysqli_query($link, $query);
    $v_row = mysqli_fetch_assoc($result);

    $v_categ = substr($v_row['categ'], 1);
    $v_categ = explode(',', $v_categ);
    // print_r($v_categ);

    

    $v_id = substr($v_row['tree'], 2);
    $v_id = explode(',', $v_id);
    // print_r($v_id);

    $category = '';

    foreach($v_categ as $key => $value) {
        $category .= "
        
        <div class=\"choice_section_list_item\" data-content=\"{$v_id[$key]}\">{$value}</div>\n
        
        ";      
        // $a[$v_id[$key]] = $value;

    }

    //-------------------- for size -----------------------------------------
    $size = '';
    $v_forSize = $v_row['tree']; //будем выбирать размеры для полученных категорий
    $querySize = "
        SELECT s.`size`, s.`id` FROM `quantity` q, `sizes` s 
          WHERE s.`id` = q.`size_id` 
           and q.`catalog_id` in ({$v_forSize}) 
        ORDER BY s.`size`
    ";
     
    // echo $v_forSize;
    // echo $querySize;


    $res_qSize = mysqli_query($link, $querySize);
    while ($rowSize = mysqli_fetch_assoc($res_qSize)) {

        $size .= "
            <div class=\"choice_section_list_item\" data-content=\"{$rowSize['id']}\"> {$rowSize['size']} </div>
        ";

    }
    
    // echo $size;

    //------------------------ for price -----------------------------------
    $price = '';
    $queryPrice = "
        SELECT pr.`id`,  pr.`ranges` 
           FROM `price_range` pr 
        ORDER BY pr.`id`
    ";
    $res_qPrice = mysqli_query($link, $queryPrice);
    while ($rowPrice = mysqli_fetch_assoc($res_qPrice)) {
        
        $price .= "
        <div class=\"choice_section_list_item\" data-content=\"{$rowPrice['ranges']}\"> {$rowPrice['ranges']} руб.</div>
        ";

    }

    echo $price;




?>

    <div class="caption">
        <h1>МУЖЧИНАМ</h1>
        <p>Все товары</p>
    </div>

    <div class="choice wrapper">
        <div class="choice_section category" data-name="category">
            <div class="choice_section_name">
                <div class="choice_section_name_text">
                    Категория
                </div>
                <div class="choice_section_name_arrow arrow-down">

                </div>
            </div>
            <div class="choice_section_list">

                <?php

                    echo $category;
                
                ?>
            
            </div>
        </div>
        
        <div class="choice_section size" data-name="size">
            <div class="choice_section_name">
                <div class="choice_section_name_text">
                    Размер
                </div>
                <div class="choice_section_name_arrow arrow-down">

                </div>
            </div>
            <div class="choice_section_list">
                <?php

                    echo $size;
                
                ?>
            </div>
        </div>
        
        <div class="choice_section cost" data-name="price">
            <div class="choice_section_name">
                <div class="choice_section_name_text">
                    Стоимость
                </div>
                <div class="choice_section_name_arrow arrow-down">

                </div>
            </div>
            <div class="choice_section_list">
                <?php
                    echo $price;
                ?>
                <!-- <div class="choice_section_list_item"  data-content="0-1000">
                    0-1000 руб.
                </div>
                <div class="choice_section_list_item" data-content="1000-3000">
                    1000-3000 руб.
                </div>
                <div class="choice_section_list_item" data-content="3000-6000">
                    3000-6000 руб.
                </div>
                <div class="choice_section_list_item" data-content="6000-20000">
                    6000-20000 руб.
                </div>
                <div class="choice_section_list_item" data-content="20000">
                    от 20000 руб.
                </div> -->
            </div>
        </div> 
    </div>

    <div class="catalog wrapper"></div>

    <div class="pagination wrapper"></div>

<?php 
    include_once($_SERVER['DOCUMENT_ROOT'].'/modules/footer.php');
?>

    <script src="/javascript/main.js"></script>
</body>
</html>