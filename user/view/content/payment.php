<?php
    include("database/connect.php");
    include("user/controller/paymentController.php");

    $paymentController = new PaymentController($conn);

    if($_GET && !isset($_GET['submit'])){
        $iduser = $_GET['iduser'];
        $counts = explode(',',$_GET['count']);
        $idsps = explode(',',$_GET['idsp']);
        $idtsps = explode(',',$_GET['idtsp']);
        if(!is_array($counts)) {
            $counts = array($counts);
        }

        if(!is_array($idsps)) {
            $idsps = array($idsps);
        }

        if(!is_array($idtsps)) {
            $idtsps = array($idtsps);
        }

        if(isset($_GET['sign'])){
            $sign = $_GET['sign'];
        }else{
            $sign = "";
        }
    }
    if(isset($_GET['submit'])){
        $iduser = $_GET['iduser'];
        parse_str($_GET['idsps'], $idsps);
        parse_str($_GET['idtsps'], $idtsps);
        parse_str($_GET['counts'], $counts);
        $ship = $_GET['ship'];
        $payment = $_GET['payment'];
        $name = $_GET['name'];
        $numberPhone = $_GET['numberPhone'];
        $email = $_GET['email'];
        $address = "";
        if(isset($_GET['check-address'])){
            $address = $_GET['orther-place'];
        }else{
            $address = $_GET['address-detail'].",".$_GET['ward'].",".$_GET['district'].",".$_GET['city'];
        }
        $result = $paymentController->insertOrder($iduser,$idsps,$idtsps,$counts,$ship,$payment,
        $name,$numberPhone,$email,$address);
        if($result == "success" && $_GET['sign'] == "cart"){
            $paymentController->clearCart($iduser,$idsps,$idtsps);
        }
        if($result == "success"){
            header("location:index.php?route=invoice");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./user/assets/css/payment.css">
</head>
<body>
<div class="container">
    <form action="index.php" method="get">
        <input type="hidden" name="route" value="payment">
        <input type="hidden" name="sign" value="<?php echo $sign;?>">
        <?php
            $paymentController->getData($iduser,$idsps,$idtsps,$counts);
        ?>
        <div class="row">
            <div class="col">
                <?php
                    $paymentController->selectInfoUser($iduser);
                ?>
            </div>

            <div class="col">
                <h3 class="title">Đơn hàng của bạn</h3>
                <table>
                    <tr class="row">
                        <td class="col-10" style="font-weight: 600;">SẢN PHẨM</td>
                        <td class="col-2">TẠM TÍNH</td>
                    </tr>
                    <?php
                        $paymentController->selectInfoPro($idsps,$idtsps,$counts);
                    ?>
                    <tr>
                        <td style="text-align: left">
                            <div class="inputBox" style="margin:0;">
                                <label style="font-weight: 600;">shipping</label> <br>
                                <input type="radio" name="ship" id="" value="free" checked>
                                <span>giao hàng miễn phí</span> <br>
                                <input type="radio" name="ship" id="" value = "ht">
                                <span>giao hàng hỏa tốc 50.000 đ</span> <br>
                                <small>DNK Yellow Shoes x 1, Áo dài việt nam x 6, Anchor Bracelet x 1</small>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left">
                            <div class="inputBox" style="margin: 0;">
                                <input type="radio" name="payment" id="" value="cash" checked>
                                <span>Trả tiền mặt khi nhận hàng</span><br>
                                <input type="radio" name="payment" id="" value="ck">
                                <span>Chuyển khoản ngân hàng</span><br>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <input type="submit" name="submit" value="Thanh toán" class="submit-btn">
    </form>
</div>
    <script src="user/assets/script/payment.js"></script>
</body>
</html>