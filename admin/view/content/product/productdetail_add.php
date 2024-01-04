<?php
    $pro = new ProductController($conn);
    $result=$pro->insertProductDetailInfo();
?>

<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm Thông Tin Chung Chi Tiết Sản Phẩm</h5>
            </div>
            <div class="card-body">
                <div class="form-group row mb-2">
                    <label for="ten" class="col-sm-2 col-form-label">Tên trường:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="ten" placeholder='Nhập tên trường...' required>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="giatri" class="col-sm-2 col-form-label">Giá trị:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="giatri" name="giatri" placeholder='Nhập giá trị...' required>
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
                <!-- <button class='btn btn-warning' name="btn" type="submit" >
                    <i class='icon fa-solid fa-screwdriver-wrench'></i> Thêm
                </button> -->
            </div>
        </div>
    </form>
</div>