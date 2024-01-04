<?php
    if($_GET){
        $sign = $_GET['ql'];

        switch ($sign) {
            case 'db':
                include('../view/content/dashboard/dashboard.php');
                break;
// Quản lý tài khoản
            case 'qltk':
                include('../view/content/users/qltk.php');
                break;
            case 'qltk_update':
                include('../view/content/users/qltk_update.php');
                break;
            case 'qltk_delete':
                include('../view/content/users/qltk.php');
                break;
// Quản lý danh mục
            //Danh mục cha
            case 'cate_pr':
                include('../view/content/category/category_parent.php');
                break;
            case 'cate_pr_add':
                include('../view/content/category/category_pr_add.php');
                break;
            case 'cate_pr_update':
                include('../view/content/category/category_pr_update.php');
                break;
            case 'cate_pr_delete':
                include('../view/content/category/category_parent.php');
                break;
            // Danh mục con
            case 'cate_sub':
                include('../view/content/category/category_sub.php');
                break;
            case 'cate_sub_add':
                include('../view/content/category/category_sub_add.php');
                break;
            case 'cate_sub_update':
                include('../view/content/category/category_sub_update.php');
                break;
            case 'cate_sub_delete':
                include('../view/content/category/category_sub.php');
                break;
//Quản lý sản phẩm
            case 'pro';
                include('../view/content/product/product.php');
                break;
            case 'pro_add';
                include('../view/content/product/product_add.php');
                break;
            case 'pro_update';
                include('../view/content/product/product_update.php'); 
                break;
            case 'pro_delete';
                include('../view/content/product/product.php');
                break;
            // Sản phẩm chi tiết
            case 'pro_de';
                include('../view/content/product/productdetail.php'); 
                break;
            case 'pro_de_add';
                include('../view/content/product/productdetail_add.php');
                break;
            case 'pro_de_update';
                include('../view/content/product/productdetail_update.php');
                break;
            case 'pro_de_delete';
                include('../view/content/product/productdetail.php');
                break;
            // Loại sản phẩm
            case 'pro_type_add';
                include('../view/content/product/productType_add.php'); 
                break;   
            case 'pro_type_update';
                include('../view/content/product/productType_update.php'); 
                break;   
// Quản lý đơn hàng
            case 'order';
                include('../view/content/order/order.php'); 
                break;
            case 'orderDetail';
                include('../view/content/order/orderDetail.php'); 
                break;
        }
    }else{
        include('../view/content/dashboard/dashboard.php');
    }


?>