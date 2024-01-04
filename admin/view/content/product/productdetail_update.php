<?php
    $pro = new ProductController($conn);
    $sql = $pro->selectProductDetail();
   
    $pro->updateProductDetailInfor();
?>

<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Chi Tiết Sản Phẩm</h5>
            </div>
            
            <div class="card-body">
                <?php
                    while( $row = mysqli_fetch_array($sql) ){
                ?>
                    <input type="hidden" name="iddepro" value="<?php echo $row['I_id_de_pro']; ?>">
                    <div class="form-group row mb-2">
                        <div class="col-sm-3">
                            <input type="text"class="form-control" name="ten" value="<?php echo $row['T_name'] ?>">
                        </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ten" name="giatri" value="<?php echo $row['T_value'] ?>" placeholder='Nhập tên sản phẩm...' required>
                        </div>
                </div>
                <?php
                    }
                ?>
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