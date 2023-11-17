<?php
    $qlkh = new QlkhController($conn);
    $select_result = $qlkh->showData('category');
?>

<button class="btn btn-success btn_add">
    <i class="icon fa-solid fa-plus"></i>
    Thêm
</button>

<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên Danh mục</td>
        <td>Mô tả danh mục</td>
        <td>Mã danh mục cha</td>
        <td colspan="3">Quản lý</td>

    </tr>
    <?php
        while($row = mysqli_fetch_array($select_result)){
            echo "<tr>";
            echo "<td>".$row['I_id_category']."</td>
                  <td>".$row['T_name_category']."</td>
                  <td>".$row['T_description']."</td>
                  <td>".$row['I_id_parent']."</td>
                  <td><button class='btn btn-info'>
                  <i class='fa-solid fa-eye'></i>
                    <a href=''>xem sản phẩm</a>
                  </button></td>
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