<?php
    $qlkh = new QlkhController($conn);
    $select_result = $qlkh->showData('user_infor');
?>

<button class="btn btn-success btn_add">
    <i class="icon fa-solid fa-plus"></i>
    Thêm
</button>

<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên</td>
        <td>Số điện thoại</td>
        <td>email</td>
        <td>địa chỉ</td>
        <td>Ngày sinh</td>
        <td colspan="2">Quản lý</td>

    </tr>
    <?php
        while($row = mysqli_fetch_array($select_result)){
            echo "<tr>";
            echo "<td>".$row['I_id_user_infor']."</td>
                  <td>".$row['T_name']."</td>
                  <td>".$row['T_number_phone']."</td>
                  <td>".$row['T_email']."</td>
                  <td>".$row['T_address']."</td>
                  <td>".$row['D_day_of_birth']."</td>
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