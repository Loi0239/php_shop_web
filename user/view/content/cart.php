<?php
    include("database/connect.php");

    $idCart = $cartController->getIdCart($_SESSION['username']);
    $idsps = $cartController->getIdsps($_SESSION['username']);
    $idtsps = $cartController->getIdtsps($_SESSION['username']);
    $qtys = $cartController->getQtys($_SESSION['username']);

    if(isset($_GET['count'])){
        $counts = [];
        $count_keys = [];
        if(isset($_GET['hidden_count'])){
            $hidden_counts = $_GET['hidden_count'];
            foreach ($hidden_counts as $item) {
                // Sử dụng substr để cắt bỏ số và ký tự '-' đầu tiên
                $trimmedItem = substr($item, 2);
                // Lấy phần tử đầu tiên của mảng
                $parts = explode('-', $item);
                $firstNumber = $parts[0];
                $counts[] = $firstNumber;
                // Thêm chuỗi đã cắt vào mảng kết quả
                $count_keys[] = $trimmedItem;
            }
        }else{
            $counts = $_GET['count'];
        }

        if(!isset($_SESSION['username'])){
            header("location:user/view/content/signin.php");
        }

        if(!is_array($counts)) {
            $counts = array($counts);
        }


        
        if(isset($_GET['idsp'])){
            $idsps = array($_GET['idsp']);
        }

        if(isset($_GET['idtsp'])){
            $idtsps = array($_GET['idtsp']);
        }

        if(isset($_GET['signDetail'])){
            $sign = $_GET['signDetail'];
        }else{
            $sign = "false";
        }
        
        $msg = $cartController->updateCart($idCart,$idsps,$counts,$sign,$idtsps,$count_keys);
        header("location:index.php?route=cart&&msg_add_cart=$msg");
    }

    if(isset($_POST['delete'])){
        $cartController->deleteCart($_POST['idcart'],$_POST['idsp'],$_POST['idtsp']);
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
    <link rel="stylesheet" href="./user/assets/css/cart.css">

</head>
<body>
<form action="index.php" method="get" class="container"> 
    <input type="hidden" name="route" value="cart">
        <div class="row">
            <div class="col-md-9">
                <div class="row show_all">
                    <div class="col-5">
                        <input type="checkbox" name="" id="parent_check">
                        <span>Tất cả ( ... sản phẩm)</span>
                    </div>
                    <div class="col-2">
                        <span>Đơn giá</span>
                    </div>
                    <div class="col-2">
                        <span>Số lượng</span>
                    </div>
                    <div class="col-2">
                        <span>Thành tiền</span>
                    </div>
                    <div class="col-1">
                        <i class="delete fa-solid fa-trash-can"></i>
                    </div>
                </div>

                <div class="show_items">
                    <?php
                        $cartController->selectData($idsps,$qtys,$idCart,$idtsps);
                    ?>    
                </div>       
            </div>
            <div class="col-md-3 box_buy">
                <div class="label_price">
                    <span class="label">Tạm tính</span>
                    <span class="price">0Đ</span>
                </div>
                <hr>
                <div class="label_total_price">
                    <span class="label">Tổng tiền</span>
                    <span class="total_price">0Đ</span>
                </div>

                <a href="#" type="submit" class="btn_buy"><i class="fa-solid fa-receipt"></i> Mua Hàng</a>
                <button type="submit" class="btn_update_cart">
                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật giỏ hàng
                </button>
            </div>
        </div>
    </form>
    <script src="user/assets/script/cart.js"></script>
</body>
</html>