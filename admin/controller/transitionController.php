<?php
    if(isset($_GET['ql'])){
        $sign = $_GET['ql'];

        switch ($sign) {
            case 'db':
                include('../view/content/dashBoard.php');
                break;
            case 'qltk':
                include('../view/content/qltk.php');
                break;
            case 'cate':
                include('../view/content/category.php');
                break;
            case 'pw':
                include('../view/content/warehouse.php');
                break;
            case 'cart':
                include('../view/content');
                break;
        }
    }else{
        include('../view/content/dashBoard.php');
    }


?>