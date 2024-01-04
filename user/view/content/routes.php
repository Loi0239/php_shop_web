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
            case 'payment':
                include('user/view/content/payment.php');
                break;
            case 'invoice':
                include('user/view/content/invoice.php');
                break;
            case 'detailOrder':
                include('user/view/content/detailOrder.php');
                break;
            case 'infoUser':
                include('user/view/content/infoUser.php');
                break;
            case 'about':
                include('user/view/content/about.php');
                break;
            }
    }else if(isset($_POST['route'])){
        $router = $_POST['route'];
        switch ($router) {
            case 'infoUser':
                include('user/view/content/infoUser.php');
                break;
        }
    }else{
        include('user/view/content/home.php');
    }


?>