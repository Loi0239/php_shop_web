<?php
  include("database/connect.php");
  include("user/controller/detailOrderController.php");

  $detailOrderController = new DetailOrderController($conn);

  if(isset($_GET['idOrder'])){
    $idOrder = $_GET['idOrder'];
  }

  if(isset($_GET['sign'])){
    $sign = $_GET['sign'];
    $star = $_GET['star'];
    $content = $_GET['content'];
    $idUser = $_GET['idUser'];
    $idsp = $_GET['idsp'];
    $idtsp = $_GET['idtsp'];
    $idcmt = $_GET['idcmt'];

    $detailOrderController->handleReview($_GET['sign'],$_GET['star'],$_GET['content'],
    $_GET['idUser'],$_GET['idsp'],$_GET['idtsp'],$_GET['idcmt'],);
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="user/assets/css/detailOrder.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>

  <section class="orders">

    <h1 class="title">chi tiết hóa đơn</h1>

    <div class="box">
        <?php
          $detailOrderController->selectInfo($idOrder);
        ?>

      <div class="product-container">
        <?php
          $detailOrderController->selectDetail($idOrder);
        ?>
      </div>
    </div>
  </section>
  <script src="user/assets/script/detailOrder.js"></script>
</body>

</html>