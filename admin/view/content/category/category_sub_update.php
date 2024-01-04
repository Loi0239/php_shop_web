<?php
    $cate = new CategoryController($conn);
    // Hiển thị thông tin danh mục để sửa
    $result = $cate->selectCategorySub1();
    $row = mysqli_fetch_assoc($result);
    
    $cate->updateCategorySub();
?>


<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Thương Hiệu</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên thương hiệu:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="tendm" value="<?php echo $row['T_name_category']?>" placeholder='Nhập tên thương hiệu...' required>
                    </div>
                </div>
                <input type="hidden" name="" value="<?php echo $idpr = $row['I_id_parent'] ?>">
                <div class="form-group row">
                    <label for="iddm" class="col-sm-2 col-form-label">Danh mục:</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-sm w-50 text-center" id="iddm" name="iddm">
                                <option selected disabled>--------Danh sách--------</option>
                                    
                            <?php
                                $result = $cate->selectCategoryParent();
                                while($row=mysqli_fetch_array($result)){
                            ?>
                                <option value="<?php echo $row['I_id_category'] ?>" <?php echo ($row['I_id_category'] == $idpr) ? 'selected' : ''; ?>>
                                    <?php echo $row['T_name_category']; ?>
                                </option>                                                   
                            <?php
                                }
                            ?>
                        </select>  
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Sửa</button>
            </div>
        </div>
    </form>
</div>