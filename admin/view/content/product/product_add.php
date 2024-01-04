<?php
    $pro = new ProductController($conn);
    $pro->insertProduct();
?>

<div class="container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label">Tên sản phẩm:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tensp" placeholder='Nhập tên sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label">Hình ảnh mô tả:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" name="hinhanhchitiet[]" multiple required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label">Mô tả tính năng:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control mb-2" name="tinhnang1" placeholder='Nhập tính năng 1...'>
                        <input type="text" class="form-control mb-2" name="tinhnang2" placeholder='Nhập tính năng 2...'>
                        <input type="text" class="form-control mb-2" name="tinhnang3" placeholder='Nhập tính năng 3...'>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label">Mô tả:</label>
                    <div class="col-sm-10">
                        <textarea name="mota" id="editor" cols="30" rows="10" class="form-control" placeholder='Nhập mô tả...'></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <?php $pro->optionProductCate(); ?>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Thêm</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col mt-3">
            <a style="text-decoration: none; color: black;" href='main.php?ql=pro'>
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Khởi tạo CKEditor
        CKEDITOR.replace('mota');
    </script>