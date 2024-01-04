<?php
    $qlkh = new QlkhController($conn);
    $select_result = $qlkh->selectData();

    $qlkh->deleteData();
?>


<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên</td>
        <td>Số điện thoại</td>
        <td>Email</td>
        <td>Địa chỉ</td>
        <td>Ngày sinh</td>
        <td colspan="2">Quản lý</td>

    </tr>
    
    <?php
    while ($row = mysqli_fetch_array($select_result)) {
        if($row['B_type'] == "1"){
            continue;
        }
    ?>
        <tr>
            <td><?php echo $row['I_id_user']; ?></td>
            <td><?php echo $row['T_name']; ?></td>
            <td><?php echo $row['T_number_phone']; ?></td>
            <td><?php echo $row['T_email']; ?></td>
            <td><?php echo $row['T_address']; ?></td>
            <td><?php echo $row['D_day_of_birth']; ?></td>
            <td>
                <button class='btn btn-warning'>
                    <i class='icon fa-solid fa-screwdriver-wrench'></i>
                    <a href='main.php?ql=qltk_update&id_sua=<?php echo $row['I_id_user']; ?>'>Sửa</a>
                </button>
            </td>
            <td>
                <button class='btn btn-danger'>
                    <i class='icon fa-solid fa-trash-can'></i>
                    <a href='main.php?ql=qltk_delete&id_xoa=<?php echo $row['I_id_user']; ?>'>Xóa</a>
                </button>
            </td>
        </tr>
    <?php
    }
    ?>

</table>