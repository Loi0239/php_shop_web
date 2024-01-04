<?php
    $order = new OrderController($conn);
    // Xử lý yêu cầu lọc
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectedStatus = $_POST['trangthai'];
        if ($selectedStatus == '4') {
            // Nếu giá trị chọn là 4, hiển thị tất cả đơn hàng
            $select_result = $order->selectOrder();
        } else {
            // Ngược lại, thực hiện truy vấn với điều kiện lọc
            $select_result = $order->selectOrderWithFilter();
        }
    } else {
        // Nếu không có yêu cầu lọc, hiển thị tất cả đơn hàng
        $select_result = $order->selectOrder();
    }
?>
<div class="row mb-3">
    <div class="col">
        <form method="post" id="filterForm">
            <label><b>Lọc đơn hàng: </b></label>
            <select name="trangthai" id="trangthai">
                <option value="4" <?php echo (isset($_POST['trangthai']) && $_POST['trangthai'] == '4') ? 'selected' : ''; ?>>
                    Tất cả đơn hàng
                </option>
                <option value="0" <?php echo (isset($_POST['trangthai']) && $_POST['trangthai'] == '0') ? 'selected' : ''; ?>>
                    Đơn hàng mới
                </option>
                <option value="1" <?php echo (isset($_POST['trangthai']) && $_POST['trangthai'] == '1') ? 'selected' : ''; ?>>
                    Đã duyệt
                </option>
                <option value="2" <?php echo (isset($_POST['trangthai']) && $_POST['trangthai'] == '2') ? 'selected' : ''; ?>>
                    Đang vận chuyển
                </option>
                <option value="3" <?php echo (isset($_POST['trangthai']) && $_POST['trangthai'] == '3') ? 'selected' : ''; ?>>
                    Đã hoàn thành
                </option>
            </select>
        </form>
    </div>
</div>
<script>
    document.getElementById('trangthai').onchange = function() {
        // Lấy giá trị của option được chọn
        var selectedValue = this.value;
        document.forms["filterForm"].submit();
    };
</script>


<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Mã đơn hàng</td>
        <td>Ngày đặt hàng</td>
        <td>Trạng thái</td>
        <td>Quản lý</td>
    </tr>
    <?php
        $stt=1;
        while($row = mysqli_fetch_array($select_result)){
    ?>
            <tr>
                <td class="align-middle"><?php echo $stt++ ?></td>
                <td class="align-middle"><?php echo $row['T_code_orders']; ?></td>
                <td class="align-middle"><?php echo $row['T_order_date']; ?></td>
                <td class="align-middle">
                    <?php
                        if($row['I_status']==0){
                            echo "<p class='pt-3' style='color: red;'><b>Đơn hàng mới</b></p>";
                        } 
                        else if($row['I_status']==1){
                            echo "<p class='pt-3' style='color: green;'><b>Đã duyệt</b></p>";
                        }
                        else if($row['I_status']==2){
                            echo "<p class='pt-3' style='color: #ffa500;'><b>Đang vận chuyển</b></p>";
                        }
                        else echo "Đã hoàn thành";
                    ?>  
                </td>
                <td class="align-middle">
                    <a href='main.php?ql=orderDetail&idOrder=<?php echo $row['I_id_orders'] ?>'>
                        <button class='btn btn-info'>
                            <i class='fa-solid fa-eye'></i>
                            Xem đơn hàng
                        </button>
                    </a>
                </td>
            </tr>
    <?php
        }
    ?>
</table>