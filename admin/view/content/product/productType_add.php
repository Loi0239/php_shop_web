<?php
    $pro = new ProductController($conn);
    $result=$pro->insertProductType();
?>

<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm Loại Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên sản phẩm:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="ten" placeholder='Nhập tên sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="hinhanh" class="col-sm-2 col-form-label">Hình ảnh:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="hinhanh" name="hinhanh">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="soluong" class="col-sm-2 col-form-label">Số lượng:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="soluong" name="soluong" min='1' placeholder='Nhập số lượng sản phẩm..' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="gia" class="col-sm-2 col-form-label">Giá:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="gia" name="gia" min='1' placeholder='Nhập giá sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <?php
                        if(isset($_POST['btn']) && $result){
                            echo "<p class='text-success mb-0'>Thêm dữ liệu thành công</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Thêm</button>

                <?php $idpro=$_GET['idpro']; ?>
                <button class='btn btn-warning'>
                    <a style="text-decoration: none; color: black;" href='main.php?ql=pro_de&idpro=<?php echo $idpro ?>'>
                        <i class='icon fa-solid fa-screwdriver-wrench'></i> Quay lại
                    </a>
                </button>
            </div>
        </div>
    </form>
</div>