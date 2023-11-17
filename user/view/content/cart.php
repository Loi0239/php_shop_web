<?php
    include("database/connect.php");

    $idCart = $cartController->getIdCart($_SESSION['username']);
    $idsps = $cartController->getIdsps($_SESSION['username']);
    $qtys = $cartController->getQtys($_SESSION['username']);

    if(isset($_GET['count'])){
        $counts = $_GET['count'];

        if (!is_array($counts)) {
            $counts = array($counts);
        }

        $msg = $cartController->updateCart($idCart,$idsps,$counts);
        header("location:index.php?route=cart&&msg_add_cart=$msg");
    }

    if(isset($_POST['delete'])){
        $cartController->deleteCart($_POST['idcart'],$_POST['idsp']);
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
                        $cartController->selectData($idsps,$qtys,$idCart);
                    ?>    
                </div>       
            </div>
            <div class="col-md-3 box_buy">
                <div class="label_price">
                    <span class="label">Tạm tính</span>
                    <span class="price">100000Đ</span>
                </div>
                <hr>
                <div class="label_total_price">
                    <span class="label">Tổng tiền</span>
                    <span class="total_price">100000Đ</span>
                </div>

                <button type="submit" class="btn_buy"><i class="fa-solid fa-receipt"></i> Mua Hàng</button>
                <button type="submit" class="btn_update_cart">
                    <i class="fa-solid fa-pen-to-square"></i> Cập nhật giỏ hàng
                </button>
            </div>
        </div>
    </form>
</body>
</html>