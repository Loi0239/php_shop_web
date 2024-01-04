<?php
    $pro = new ProductController($conn);
    $result = $pro->selectProductDetail();
    $pro->deleteProductDetail();
    $pro->deleteProductType();
?>
<!-- Thông tin chi tiết sản phẩm -->
<div class="container mt-5 mb-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><b>Thông tin chung chi tiết sản phẩm: </b></h5>
                        <hr>
                        <!-- Hiển thị hình ảnh chi tiết từ bảng sản phẩm -->
                        <div class="row mb-3">
                            <div class="col d-flex">
                                <p class='mt-3'><b>Hình ảnh chi tiết: </b></p>
                                <?php
                                    $query = $pro->selectProductImgDetail();
                                    $row1= mysqli_fetch_array($query);
                                    if ($row1) {
                                        $link_imgs = explode(" | ", $row1['T_img_sample_pro']);
                                        foreach ($link_imgs as $link_img) {
                                            echo "<img class='mr-2' width='80' height='80' src='../../public/img_detail/{$link_img}'>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Hiển thị các trường thông tin -->
                        <div style="display:grid; grid-template-columns:50% 50%">
                        <?php 
                            while($row=mysqli_fetch_array($result)){
                        ?>
                                <div class="row">
                                    <div class="col-md-12">
                                            <?php
                                                if ($row) {
                                                    echo '<p>' . htmlspecialchars($row['T_name']) . ': ' . htmlspecialchars($row['T_value']) . '</p>';
                                                } else {
                                                    echo '<p>Vui lòng thêm dữ liệu!!</p>';
                                                }
                                            ?>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class='btn btn-primary'>
                            <?php $idpro = $_GET['idpro']; ?>
                            <a style="text-decoration: none; color: black;" href='main.php?ql=pro_de_add&idpro=<?php echo $idpro; ?>'>
                                <i class='icon fa-solid fa-screwdriver-wrench'></i> Thêm
                            </a>
                        </button>
                        <button class='btn btn-warning'>
                            <a style="text-decoration: none; color: black;" href='main.php?ql=pro_de_update&idpro=<?php echo $idpro; ?>'>
                                <i class='icon fa-solid fa-screwdriver-wrench'></i> Sửa
                            </a>
                        </button>
                        <a href='main.php?ql=pro_de_delete&idpro=<?php echo $idpro; ?>&id_xoa_sp_chi_tiet=<?php echo $idpro; ?>'>
                            <button class='btn btn-danger'>
                                <i class='icon fa-solid fa-trash-can'></i> Xóa
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 mt-5">
                    <a href="main.php?ql=pro" style="text-decoration: none; color:black;">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại kho sản phẩm 
                    </a>
            </div>
        </div>
</div>  

<!-- Phân loại sản phẩm -->
<?php 
    $pro = new ProductController($conn);
    $select_result1 = $pro->selectProductType();
?>

<?php $idpro = $_GET['idpro']; ?>
<a href="main.php?ql=pro_type_add&idpro=<?php echo $idpro; ?>">
    <button class='btn btn-success'>
        <i class="icon fa-solid fa-plus"></i> Thêm
    </button>
</a>

<h3 style="text-align:center;">Phân loại sản phẩm</h3 style="text-align:center;">
<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên loại sản phẩm</td>
        <td>Hình ảnh</td>
        <td>Số lượng</td>
        <td>Giá</td>
        <td colspan="2">Quản lý</td>

    </tr>
    <?php
        while($row1 = mysqli_fetch_array($select_result1)){
    ?>
            <tr>
                    <td class="align-middle"><?php echo $row1['I_id_type_pro']; ?></td>
                    <td class="align-middle"><?php echo $row1['T_name']; ?></td>
                    <td class="align-middle"><img  width='80' height='80' src='../../public/img/<?php echo $row1['T_image_sample_type_pro']; ?>'></td> 
                    <td class="align-middle"><?php echo $row1['I_qty_in_stock']; ?></td>
                    <td class="align-middle"><?php echo $row1['I_price']; ?></td>
                    
                    <td class="align-middle">
                        <a href='main.php?ql=pro_type_update&idpro=<?php echo $row1['I_id_pro']; ?>&id_sua_type_pro=<?php echo $row1['I_id_type_pro']; ?>'>
                            <button class='btn btn-warning'>
                                <i class='icon fa-solid fa-screwdriver-wrench'></i> Sửa
                            </button>
                        </a>
                    </td>
                    
                    <td class="align-middle"> 
                        <a href='main.php?ql=pro_de_delete&idpro=<?php echo $row1['I_id_pro']; ?>&id_xoa_type_pro=<?php echo $row1['I_id_type_pro']; ?>'>
                            <button class='btn btn-danger'>
                                <i class='icon fa-solid fa-trash-can'></i> Xóa
                            </button>
                        </a> 
                    </td>
            </tr>
    <?php
        }
    ?>
</table>