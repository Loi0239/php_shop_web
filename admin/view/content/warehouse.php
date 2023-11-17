<?php
    $qlkh = new QlkhController($conn);
    $select_result = $qlkh->showData('product');
?>

<button class="btn btn-success btn_add">
    <i class="icon fa-solid fa-plus"></i>
    Thêm
</button>

<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên sản phẩm</td>
        <td>Số lượng trong kho</td>
        <td>giá</td>
        <td>ảnh minh họa</td>
        <td colspan="2">Quản lý</td>

    </tr>
    <?php
        while($row = mysqli_fetch_array($select_result)){
            echo "<tr>";
            echo "<td>".$row['I_id_pro']."</td>
                  <td>".$row['T_name_pro']."</td>
                  <td>".$row['I_qty_in_stock']."</td>
                  <td>".$row['I_price'].".000 vnđ</td>
                  <td>".$row['T_img_sample']."</td>
                  <td><button class='btn btn-warning'>
                    <i class='icon fa-solid fa-screwdriver-wrench'></i>
                    <a href=''>Sửa</a>
                  </button></td>
                  <td><button class='btn btn-danger'>
                    <i class='icon fa-solid fa-trash-can'></i>
                    <a href=''>Xóa</a>
                  </button></td>";
            echo "</tr>";
        }
    ?>
</table>