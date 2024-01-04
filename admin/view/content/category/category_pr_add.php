<?php
    $cate = new CategoryController($conn);
    $cate->insertCategoryParent();
?>

<div class="container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm Danh Mục</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên danh mục:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="tendm" placeholder='Nhập tên danh mục...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sdt" class="col-sm-2 col-form-label">Hình ảnh:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="sdt" name="img" required>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Thêm</button>
            </div>
        </div>
    </form>
</div>