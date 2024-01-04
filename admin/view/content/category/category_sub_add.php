<?php
    $cate = new CategoryController($conn);
    $cate->insertCategorySub();
?>

<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm Thương hiệu</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên thương hiệu:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="tendm" placeholder='Nhập tên thương hiệu...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="iddm" class="col-sm-2 col-form-label">Danh mục:</label>
                    <div class="col-sm-10">
                        <select class="form-select form-select-sm w-50 text-center" id="iddm" name="iddm">
                                    <option selected disabled>--------Danh sách--------</option>
                            <?php
                                // Hiển thị thông tin danh mục cha 
                                $result = $cate->selectCategoryParent();
                                while($row=mysqli_fetch_array($result)){
                            ?>
                                    <option value="<?php echo $row['I_id_category'] ?>"><?php echo $row['T_name_category'] ?></option>                                                    
                            <?php
                                }
                            ?>
                        </select>  
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Thêm</button>
            </div>
        </div>
    </form>
</div>