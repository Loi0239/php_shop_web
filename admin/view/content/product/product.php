<?php 
    $pro = new ProductController($conn);
    
    $pro->filterProduct();
    $pro->deleteProduct();
?>
<!-- Phân trang -->
<?php
    // Lấy từ fiterProduct()
    $idPr = isset($_SESSION['idPr']) ? $_SESSION['idPr'] : 0;
    $idSub = isset($_SESSION['idSub']) ? $_SESSION['idSub'] : 0; 

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 5;
    $start = ($currentPage - 1) * $limit;

    // Truy vấn để lấy dãy sản phẩm cụ thể
    $result = $pro->selectProductPage($idSub, $limit, $start);
    // Đếm tổng số sản phẩm để tính số trang
    $totalProducts = mysqli_num_rows($pro->selectProduct2($idSub)); // Hiển thị sản phẩm ở idsub
    $totalPages = ceil($totalProducts / $limit);

    // Tính số thứ tự bắt đầu
    $stt = ($currentPage - 1) * $limit + 1;
?>

<!-- Hiển thị số trang và số sản phẩm -->
<div>
    <p style="text-align: right; padding-right: 15px;"><b>Tổng số sản phẩm: <?php echo $totalProducts; ?></b></p>
</div>

<button class="btn btn-success btn_add">
    <a href="main.php?ql=pro_add&idPr=<?php echo $idPr; ?>&page=<?php echo $currentPage; ?>">
      <i class="icon fa-solid fa-plus"></i>
      Thêm
    </a>
</button>
<!-- Bảng sản phẩm -->
<div id="productTableContainer">
<table class="table table-hover">
    <tr class="tr_first">
        <td>STT</td>
        <td>Tên sản phẩm</td>
        <td>Số lượng đã bán</td>
        <td colspan="3">Quản lý</td>
    </tr>
    <?php
        while ($row = mysqli_fetch_array($result)) {
    ?>
            <tr>
                <td><?php echo $stt++ ?></td>
                <td><?php echo $row['T_name_pro']; ?></td>
                <td><?php echo $row['I_sold']; ?></td>
            
                <td>
                    <a href='main.php?ql=pro_de&idpro=<?php echo $row['I_id_pro']; ?>'>
                        <button class='btn btn-info'>
                            <i class='fa-solid fa-eye'></i>Chi tiết
                        </button>
                    </a>
                </td>

                <td>
                    <a href='main.php?ql=pro_update&id_sua=<?php echo $row['I_id_pro']; ?>&idPr=<?php echo $idPr; ?>&idSub=<?php echo $idSub; ?>&page=<?php echo $currentPage; ?>'>
                        <button class='btn btn-warning'>   
                            <i class='icon fa-solid fa-screwdriver-wrench'></i> Sửa
                        </button>
                    </a>
                </td>
                
                <td>
                    <a href='main.php?ql=pro_delete&id_xoa=<?php echo $row['I_id_pro']; ?>&idPr=<?php echo $idPr; ?>&idSub=<?php echo $idSub; ?>&page=<?php echo $currentPage; ?>'>
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
</div>
<!-- Hiển thị các liên kết phân trang -->
<div class="pagination">
    <a href="#">&laquo;</a>
    <?php
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='main.php?ql=pro&danhmucPR=$idPr&danhmucSub=$idSub&page=$i'";
            if ($i == $currentPage) {
                echo " class='active'";
            }
            echo "> $i</a>";
        }
    ?>
    <a href="#">&raquo;</a>
</div>


<link rel="stylesheet" href="../assets/css/product.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../assets/script/product.js"></script>

<!-- <script>
    // productAjax.js
function deleteProduct(productId) {
    // Sử dụng AJAX để gọi phương thức xóa sản phẩm từ ProductController
    $.ajax({
        type: 'POST',
        url: '../controller/productController.php',
        data: { action: 'deleteProduct', productId: productId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Nếu xóa thành công, có thể cập nhật giao diện người dùng hoặc thực hiện các thao tác khác
                alert('Product deleted successfully!');
            } else {
                alert('Failed to delete product.');
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
</script> -->