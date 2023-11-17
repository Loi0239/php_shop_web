<?php
    if(isset($_GET['route'])){
        $router = $_GET['route'];

        switch ($router) {
            case 'home':
                include('user/view/content/home.php');
                break;
            case 'product':
                include('user/view/content/products.php');
                break;
            case 'detailProduct':
                include('user/view/content/detailProduct.php');
                break;
            case 'cart':
                include('user/view/content/cart.php');
                break;
            }
    }else{
        include('user/view/content/home.php');
    }
?>