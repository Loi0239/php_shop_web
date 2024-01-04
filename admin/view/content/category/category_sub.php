<?php
    $cate = new CategoryController($conn);
    // Hiển thị thông tin danh mục con
    $select_result = $cate->selectCategorySub();
    $cate->deleteCategorySub();
    $id_sub= $_GET['id_sub']
?>


<a href="main.php?ql=cate_sub_add&id_sub=<?php echo $id_sub ?>">
    <button class="btn btn-success btn_add">
        <i class="icon fa-solid fa-plus"></i>
        Thêm
    </button>
</a>


<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên thương hiệu</td>
        <td colspan="2">Quản lý</td>

    </tr>
    <?php
        $select_result = $cate->selectCategorySub();
        while($row = mysqli_fetch_array($select_result)){
    ?>
            <tr>
                <td><?php echo $row['I_id_category']; ?></td>
                <td><?php echo $row['T_name_category']; ?></td>

                <td>
                    <a href='main.php?ql=cate_sub_update&id_sub=<?php echo $row['I_id_parent']; ?>&id_sua=<?php echo $row['I_id_category']; ?>'>
                        <button class='btn btn-warning'>
                            <i class='icon fa-solid fa-screwdriver-wrench'></i>
                            Sửa
                        </button>
                    </a>
                </td>

                <td>
                    <a href='main.php?ql=cate_sub_delete&id_sub=<?php echo $row['I_id_parent']; ?>&id_xoa=<?php echo $row['I_id_category']; ?>'>
                        <button class='btn btn-danger'>
                            <i class='icon fa-solid fa-trash-can'></i>
                            Xóa
                        </button>
                    </a>
                </td>
            </tr>
    <?php
        }
    ?>
</table>

    <div class="row">
        <div class="col mt-3">
            <a href="main.php?ql=cate_pr" style="text-decoration:none; color: black; margin-top:50%;">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>