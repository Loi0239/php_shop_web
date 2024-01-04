<?php
    include("database/connect.php");
    include("user/controller/productsController.php");

    $productsController = new ProductsController($conn);
    
    if(isset($_GET['iddm'])) $iddm = $_GET['iddm'];
    else $iddm = "";

    $total_records = $productsController->getTotal_records($iddm);

    if(isset($_GET['text-search'])){
        $text = $_GET['text-search'];
        $total_records = $productsController->getSearch_total_records($text);
    }

    if(isset($_GET['page'])) $page = $_GET['page'];
    else $page = 1;

    $limit = 3;
    $start = ($page-1)*$limit;
    $total_pages = ceil($total_records/$limit);

    if(isset($_GET['addCart'])){
        if(!strcmp($_GET['addCart'],'true')){
            $msg = $productsController->addCart($_GET['idsp'], $_SESSION['username']);
        }else{
            $msg = "warning_cart";
        }
        header("location:index.php?route=product&&msg_add_cart=$msg");
    }

    if(isset($_GET['msg_add_cart'])){
        $msg_add_cart = $_GET['msg_add_cart'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./user/assets/css/products.css">

</head>
<body>
<h1>Trang sản phẩm</h1>

<div class="container">
    <div class="row">
        <div class="col-md-2 col-4 category">
            <h4>Category</h4>
            <ul>
                <?php
                    $productsController->select_category();
                ?>
            </ul>
        </div>
        <div class="col-md-9 col-7 products">
            <div class="row">
                <?php
                    if(isset($text)){
                        $productsController->searchSelect($text,$start,$limit);
                    }else{
                        $productsController->select($iddm,$start,$limit);
                    }                  
                ?>
            </div>
            <div class="row page-number">
                <?php
                    if(isset($text)){
                        $productsController->searchPagination($text,$page,$total_pages);
                    }else{
                        $productsController->pagination($iddm,$page,$total_pages);
                    }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>