<?php
    $cate = new CategoryController($conn);
    // Hiển thị thông tin danh mục cha để sửa
    $result = $cate->selectCategoryParent1();
    $row = mysqli_fetch_assoc($result);
    
    $cate->updateCategoryParent();
?>

<div class="container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Danh Mục Cha</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên danh mục:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="tendm" value="<?php echo $row['T_name_category']?>" placeholder='Nhập tên danh mục...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mota" class="col-sm-2 col-form-label">Hình ảnh:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="mota" name="img" value="<?php echo $row['T_img_sample_category']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Sửa</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col mt-3">
            <a href="main.php?ql=cate_pr" style="text-decoration:none; color: black; margin-top:50%;">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>