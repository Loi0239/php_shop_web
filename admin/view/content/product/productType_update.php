<?php
    $pro = new ProductController($conn);
    $sql = $pro->selectProductType1();
    $row = mysqli_fetch_array($sql);

    $pro->updateProductType();
?>

<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Loại Sản Phẩm</h5>
            </div>
            
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên sản phẩm:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="ten" value="<?php echo $row['T_name'] ?>" placeholder='Nhập tên sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="hinhanh" class="col-sm-2 col-form-label">Hình ảnh:</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="hinhanh" name="hinhanh" value="<?php echo $row['T_image_sample_type_pro'] ?>">
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="soluong" class="col-sm-2 col-form-label">Số lượng:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="soluong" name="soluong" min='1' value="<?php echo $row['I_qty_in_stock'] ?>" placeholder='Nhập số lượng sản phẩm...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gia" class="col-sm-2 col-form-label">Giá:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="gia" name="gia" min='1' value="<?php echo $row['I_price'] ?>" placeholder='Nhập giá sản phẩm...' required>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">
                    Sửa
                </button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col mt-3">
            <?php $idpro=$_GET['idpro']; ?>
            <a style="text-decoration: none; color: black;" href='main.php?ql=pro_de&idpro=<?php echo $idpro; ?>'>
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

</div>