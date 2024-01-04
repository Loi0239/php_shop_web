<?php
  include("database/connect.php");
  include("user/controller/invoiceController.php");

  $invoiceController = new InvoiceController($conn);

  if(isset($_GET['idInvoice'])){
    $invoice = $_GET['idInvoice'];
  }else{
    $invoice = -1;
  }

  if(isset($_GET['idOrder']) && isset($_GET['sign'])){
    if($_GET['sign'] == "delete"){
      $invoiceController->deleteInvoice($_GET['idOrder']);
    }else if($_GET['sign'] == "confirm"){
      $invoiceController->confirmInvoice($_GET['idOrder']);
    }else if($_GET['sign'] == "restore"){
      $invoiceController->restoreInvoice($_GET['idOrder']);
    }  
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="user/assets/css/invoice.css">
  <title>Document</title>
</head>

<body>
  <div class="container">
    <div class="bar">
      <a class="btn-change" data-id="-1" href="#">Tất cả</a>
      <a class="btn-change" data-id="0" href="#">Chờ duyệt</a>
      <a class="btn-change" data-id="1" href="#">Đã duyệt</a>
      <a class="btn-change" data-id="2" href="#">Đang vận chuyển</a>
      <a class="btn-change" data-id="3" href="#">Đã hoàn thành</a>
      <a class="btn-change" data-id="4" href="#">Đã mua</a>
      <a class="btn-change" data-id="5" href="#">Đã hủy</a>
    </div>
    <h3>Danh sách hóa đơn</h3>
    <table class="table table-bordered table-hover">
      <tr class="table-dark">
        <td>STT</td>
        <td>Mã đơn hàng</td>
        <td>Ngày đặt hàng</td>
        <td>Trạng thái</td>
        <td colspan="2">Chi tiết</td>
      </tr>
      <?php
        $invoiceController->selectData($invoice);  
      ?>
    </table>
    <a href="index.php?route=product" class="back-btn"><i class="fa-solid fa-caret-left"></i> Tiếp tục mua</a>
  </div>
  <script src="user/assets/script/invoice.js"></script>
</body>

</html>