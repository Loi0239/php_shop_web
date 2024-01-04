<?php
    $cate = new CategoryController($conn);
    $select_result = $cate->selectCategoryParent();
    $cate->deleteCategoryParent();
?>

<button class="btn btn-success btn_add">
    <i class="icon fa-solid fa-plus"></i>
    <a href="main.php?ql=cate_pr_add">Thêm</a>
</button>

<table class="table table-hover">
  <tr class="tr_first">
    <td>STT</td>
    <td>Tên Danh mục</td>
    <td>Hình ảnh</td>
    <td colspan="3">Quản lý</td>
  </tr>

  <?php
    while($row = mysqli_fetch_array($select_result)){
  ?>
      <tr>
        <td><?php echo $row['I_id_category']; ?></td>
        <td><?php echo $row['T_name_category']; ?></td>
        <td>
          <img width='80' height='80' src="../../public/img/<?php echo $row['T_img_sample_category']; ?>" alt="">
        </td>

        <td>
          <a href='main.php?ql=cate_sub&id_sub=<?php echo $row['I_id_category']; ?>'>
            <button class='btn btn-info'>
              <i class='fa-solid fa-eye'></i> Thương hiệu  
            </button>
          </a>
        </td>

        <td>
          <a href='main.php?ql=cate_pr_update&id_sua=<?php echo $row['I_id_category']; ?>'>
            <button class='btn btn-warning'>
              <i class='icon fa-solid fa-screwdriver-wrench'></i> Sửa
            </button>
          </a>
        </td>
                  
        <td>
          <a href='main.php?ql=cate_pr_delete&id_xoa=<?php echo $row['I_id_category']; ?>'>
            <button class='btn btn-danger'>
              <i class='icon fa-solid fa-trash-can'></i> Xóa
            </button>
          </a>
        </td>
      </tr>
  <?php
    }
  ?>
</table>