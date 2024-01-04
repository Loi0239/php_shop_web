<?php
    $pro = new ProductController($conn);
    $result = $pro->selectProduct1();
    $row = mysqli_fetch_assoc($result);
    
    $pro->updateProduct();
?>

<div class="container mt-4">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên sản phẩm:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="tensp" value="<?php echo $row['T_name_pro']?>" placeholder='Nhập tên sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="hinhanh" class="col-sm-2 col-form-label">Hình ảnh chi tiết:</label>
                    <div class="col-sm-10">
                        <div class="d-flex align-items-center" id="image_container">
                            <?php 
                                if ($row) {
                                    $link_imgs = explode(" | ", $row['T_img_sample_pro']);
                                    foreach ($link_imgs as $link_img) {
                                        echo "<img class='mr-2' width='80' height='80' src='../../public/img_detail/{$link_img}'>";
                                    }
                                }
                            ?>
                            <input type="file" class="form-control" id="hinhanh" name="hinhanhchitiet[]" multiple>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label">Mô tả tính năng:</label>
                    <div class="col-sm-10">
                        <?php
                            $dataArray = explode('|', $row['T_feature']);
                        ?>     
                        <input type="text" class="form-control mb-2" name="tinhnang1" value="<?php echo $dataArray[0]; ?>" placeholder='Nhập tính năng 1...'>
                        <input type="text" class="form-control mb-2" name="tinhnang2" value="<?php echo $dataArray[1]; ?>" placeholder='Nhập tính năng 2...'> 
                        <input type="text" class="form-control mb-2" name="tinhnang3" value="<?php echo $dataArray[2]; ?>" placeholder='Nhập tính năng 3...'>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="mota" class="col-sm-2 col-form-label">Mô tả:</label>
                    <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="mota" name="mota" value="<?php echo $row['T_description']?>" placeholder='Nhập mô tả...'> -->
                        <textarea name="mota" id="editor" cols="30" rows="10" class="form-control" placeholder='Nhập mô tả...'>
                            <?php echo $row['T_description']?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mota" class="col-sm-2 col-form-label">Thương hiệu:</label>
                    <div class="col-sm-10">
                        <?php $pro->optionProductCate1(); ?>
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
            <a href="main.php?ql=pro" style="text-decoration:none; color: black; margin-top:50%;">
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