<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<?php
    // Hiển thị thông tin chi tiết đơn hàng
    $order = new OrderController($conn);
    $select_result = $order->selectOrderDetail();
?>
<?php ob_start(); ?>
<form action="" method="post">

    <?php $row = mysqli_fetch_array($select_result); ?>
    <div class="container mt-4 mb-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Thông tin khách hàng</b></h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Tên khách hàng:</strong> <?php echo $row['T_name_user']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Số điện thoại:</strong> <?php echo $row['T_number_phone']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Địa chỉ:</strong> <?php echo $row['T_address']; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Email:</strong> <?php echo $row['T_email']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   

<table class="table table-bordered table-hover text-center">
    <thead class="tr_first">
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Mã đơn hàng</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Đơn giá</th>
            <th scope="col">Thành tiền</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // Hiển thị thông tin chi tiết đơn hàng
        $select_result = $order->selectOrderDetail();
        $stt = 1;
        $thanhtien=0;
        while($row = mysqli_fetch_array($select_result)){
    ?>        
            <tr>
                <input type="hidden" name="iddh" value="<?php echo $row['I_id_orders'] ?>" >
                <input type="hidden" name="idsp[]" value="<?php echo $row['I_id_type_pro'] ?>" >
                <input type="hidden" name="soluong[]" value="<?php echo $row['I_qty'] ?>" >
                <td class="align-middle"><?php echo $stt++; ?></td>
                <td class="align-middle"><?php echo $row['T_code_orders']; ?></td>
                <td class="align-middle"><?php echo $row['T_name']; ?></td>
                <td class="align-middle"><img  width='80' height='80' src='../../public/img/<?php echo $row['T_image_sample_type_pro']; ?>'></td>
                <td class="align-middle"><?php echo $row['I_qty']; ?></td>
                <td class="align-middle"><?php echo number_format($row['I_price'], 0, ',', '.').' VNĐ'; ?></td>
                <td class="align-middle">
                    <?php
                        
                        $tien = $row['I_qty'] * $row['I_price'];
                        $thanhtien += $tien;
                        echo number_format($tien, 0, ',', '.').' VNĐ';
                    ?>
                </td>
            </tr>
            
    <?php        
        }
    ?>
    <tbody>
</table>
    <p style="text-align: right; font-size: 20px; margin-right: 35px;"><b>Tổng: <?php  echo number_format($thanhtien, 0, ',', '.').' VNĐ'; ?></b></p>
    
    
    <?php 
        $order->updateStatusOrder();
        $order->deleteOrder();

        $result = $order->selectOrderDetail();
        $row1 = mysqli_fetch_array($result);
        $trangthai = $row1['I_status'];
    ?>
    <div class="row">
    <div class="col-md-4 d-flex mb-3">
        <form method="post" action="">
            <select name="trangthai" id="trangthai" class="mr-2">
                <option value="0" <?php echo ($trangthai == '0') ? 'selected' : ''; ?>>
                    Chưa xử lý
                </option>
                <option value="1" <?php echo ($trangthai == '1') ? 'selected' : ''; ?>>
                    Duyệt
                </option>
                <option value="2" <?php echo ($trangthai == '2') ? 'selected' : ''; ?>>
                    Đang vận chuyển
                </option>
                <option value="3" <?php echo ($trangthai == '3') ? 'selected' : ''; ?>>
                    Đã giao
                </option>
            </select>
            <input type="submit" value="Cập nhật" name="sua_trang_thai" class="btn btn-success mr-2">
            <input type="submit" value="Xóa" name="xoa_don_hang" class="btn btn-danger">
        </form>
    </div>
</div>


    <div class="row">
        <div class="col-sm-4">
            <a href="main.php?ql=order" class="btn btn-link text-muted" style="text-decoration: none">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</form>
<?php ob_end_flush(); ?>