<?php
    include_once('../model/productModel.php');
    include_once('../model/categoryModel.php');
    include_once('../model/orderModel.php');

    class ProductController{
        private $pro;
        private $cate;
        private $order;

        public function __construct($conn) {
            $this->pro = new ProductModel($conn);
            $this->cate = new CategoryModel($conn);
            $this->order = new OrderModel($conn);
        }
// Sản phẩm
        // Hiển thị thông tin sản phẩm
        public function selectProduct(){
            return $this->pro->selectProduct();
        }
        // Hiển thị thông tin sản phẩm để sửa
        public function selectProduct1(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
                $data = $this->pro->selectProduct1($id_sua);
                return $data;
            }
        }   
        // Hiển thị thông tin sản phẩm để lấy hình ảnh chi tiết
        public function selectProductImgDetail(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
                $data = $this->pro->selectProduct1($idpro);
                return $data;
            }
        }   
        // Thêm sản phẩm
        public function insertProduct(){
            if(isset($_POST['btn'])){
                $name = $_POST['tensp'];
                $imploded_names = '';
                if(isset($_FILES['hinhanhchitiet'])){
                    $file = $_FILES['hinhanhchitiet'];
                    $file_names = $file['name'];
                
                    if (is_array($file_names)) { 
                        $imploded_names = implode(" | ", $file_names);
                        $img = $imploded_names;
                    }
                }
                $tinhnang1 = $_POST['tinhnang1']; $tinhnang2 = $_POST['tinhnang2']; $tinhnang3= $_POST['tinhnang3'];
                $tinhnang = $tinhnang1 . ' | ' . $tinhnang2 . ' | ' . $tinhnang3;
                $mota = $_POST['mota'];
                $iddm = $_POST['iddm'];
                $this->pro->insertProduct($name, $img, $tinhnang, $mota, $iddm);

                $uploadsDirectory = '../../public/img/';
                $uploadedFiles = [];

                foreach ($file['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($file['name'][$key]);

                    // Kiểm tra xem có lỗi không
                    if ($file['error'][$key] === UPLOAD_ERR_OK) {
                        // Đường dẫn đầy đủ tới file trong thư mục uploads
                        $targetPath = $uploadsDirectory . $filename;

                        // Kiểm tra và chuyển file vào thư mục uploads
                        if (move_uploaded_file($tmp_name, $targetPath)) {
                            // Lưu đường dẫn của file vào mảng
                            $uploadedFiles[] = $targetPath;
                        } else {
                            // Xử lý lỗi nếu cần
                            echo "Có lỗi xảy ra khi tải lên file $filename.";
                        }
                    } else {
                        // Xử lý lỗi nếu cần
                        echo "Có lỗi xảy ra với file $filename: " . $file['error'][$key];
                    }
                }
                // $idPr = isset($_GET['idPr']) ? $_GET['idPr'] : '';
                // $idsub = isset($_GET['idsub']) ? $_GET['idsub'] : '';
                // $page = isset($_GET['page']) ? $_GET['page'] : '';
                // header("location: main.php?ql=pro&idPr={$idPr}&page={$page}");
            }
        }     
        // Sửa sản phẩm
        public function updateProduct(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
            } 
            if(isset($_POST['btn'])){
                $name = $_POST['tensp'];
                $imploded_names = '';
                if(isset($_FILES['hinhanhchitiet'])){
                    $file = $_FILES['hinhanhchitiet'];
                    $file_names = $file['name'];
                
                    if (is_array($file_names)) { 
                        $imploded_names = implode(" | ", $file_names);
                        $img = $imploded_names;
                    }
                }
                $tinhnang1 = $_POST['tinhnang1']; $tinhnang2 = $_POST['tinhnang2']; $tinhnang3= $_POST['tinhnang3'];
                $tinhnang = $tinhnang1 . ' | ' . $tinhnang2 . ' | ' . $tinhnang3;
                $mota = $_POST['mota'];
                $iddm = $_POST['iddm'];
                $id_sua = $_GET['id_sua'];
                $result = $this->pro->updateProduct($name, $img, $tinhnang, $mota, $iddm, $id_sua);
                
                $uploadsDirectory = '../../public/img/';
                foreach ($file['tmp_name'] as $key => $tmp_name) {
                    $filename = basename($file['name'][$key]);
                    // Kiểm tra tên tệp
                    if ($filename != "array") {
                        $targetPath = $uploadsDirectory . $filename;
                    } else {
                        // Tên tệp là "array", xử lý nếu cần
                        echo "Invalid file name: " . $filename;
                    }
                }
                // $idPr = isset($_GET['idPr']) ? $_GET['idPr'] : '';
                // $idSub = isset($_GET['idSub']) ? $_GET['idSub'] : '';
                // $page = isset($_GET['page']) ? $_GET['page'] : '';
                // header("location: main.php?ql=pro&idPr={$idPr}&idSub={$idSub}&page={$page}");
            }
        }
        // Xóa sản phẩm
        public function deleteProduct(){
            // $id_xoa = I_id_pro 
            if(isset($_GET['id_xoa'])){
                $id_xoa = $_GET['id_xoa'];
                $this->pro->deleteProductDetail($id_xoa); // Xóa chi tiết sản phẩm

                $query = $this->pro->selectProductType($id_xoa);
                $row = mysqli_fetch_array($query);
                $idprotype = $row['I_id_type_pro'];
                if($idprotype){
                    $this->order->deleteProductTypeOrderDetail($idprotype); // Xóa loại sp có trong giỏ hàng
                }
                

                $this->pro->deleteProductType1($id_xoa); // Xóa loại sản phẩm
                $result=$this->pro->deleteProduct($id_xoa); // Xóa sản phẩm
                // echo json_encode(['success' => $result]);
                // $idPr = isset($_GET['idPr']) ? $_GET['idPr'] : '';
                // $idSub = isset($_GET['idSub']) ? $_GET['idSub'] : '';
                // $page = isset($_GET['page']) ? $_GET['page'] : '';
                // header("location: main.php?ql=pro&idPr={$idPr}&idSub={$idSub}&page={$page}");
            }
        }
        // Bộ lọc sản phẩm
        public function filterProduct(){
        ?>
            <form name="form" method="get" class="form-inline">
                <label for="danhmucPR" class="col-sm-2 col-form-label"><B>BỘ LỌC SẢN PHẨM</B>:</label>
                <div class="col-md-5 d-flex mb-2">
                    <select class="form-select form-select-sm w-50 text-center" id="danhmucPR" name="danhmucPR" onchange="redirectOnChange();">
                        <?php
                            // Hiển thị danh sách danh mục cha
                            $result = $this->cate->selectCategoryParent();
                            $idPr = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                if ($idPr == 0) $idPr = $row['I_id_category']; // Giữ lại id của catePr đầu tiên
                        ?>
                                <option value="<?php echo $row['I_id_category'] ?>" <?php if (isset($_GET['danhmucPR']) && $_GET['danhmucPR'] == $row['I_id_category']) echo 'selected'; ?>>
                                    <?php echo $row['T_name_category'] ?>
                                </option>
                        <?php
                            }
                        ?>
                    </select>
                    <!-- Danh mục con -->
                    <?php
                        if (isset($_GET['danhmucPR'])) $idPr = $_GET['danhmucPR'];
                        $result1 = $this->cate->selectCategorySub($idPr); // Hiển thị danh sách danh mục con
                    ?>
                    <select class="form-select form-select-sm w-50 text-center" style="margin-right:20%;" name="danhmucSub" id="danhmucSub" onchange="redirectOnChange();">
                        <?php
                            $idsub = 0;
                            while ($row = mysqli_fetch_array($result1)) {
                                if ($idsub == 0) $idsub = $row['I_id_category'];
                        ?>
                                <option value="<?php echo $row['I_id_category'] ?>" <?php if (isset($_GET['danhmucSub']) && $_GET['danhmucSub'] == $row['I_id_category']){ echo 'selected'; $idsub = $_GET['danhmucSub']; } ?>>
                                    <?php echo $row['T_name_category'] ?>
                                </option>
                        <?php
                                session_start();
                                $_SESSION['idSub'] = $idsub;
                                $_SESSION['idPr'] = $idPr;
                            }
                        ?>
                    </select>
                    
                    <script>
                        function redirectOnChange() {
                            var selectedValuePR = document.getElementById("danhmucPR").value;
                            var selectedValueSub = document.getElementById("danhmucSub").value;
                            
                            // Chuyển hướng trang với giá trị đã chọn
                            window.location.href = "main.php?ql=pro&danhmucPR=" + selectedValuePR + "&danhmucSub=" + selectedValueSub;
                        }
                    </script>
                </div>
            </form>
        <?php
        }
        // Hiển thị thông tin sản phẩm trong phân trang
        public function selectProductPage($idsub, $limit, $start){
            return $this->pro->selectProductPage($idsub, $limit, $start);
        }
        public function selectProduct2($idsub){
            return $this->pro->selectProduct2($idsub); // Hiển thị sp để dùng trong hàm đếm để phân trang
        }
        // Select option phân loại danh mục để thêm sản phẩm (include đến file product_add)
        public function optionProductCate(){
        ?>
            <label for="iddm" class="col-sm-2 col-form-label">Thương hiệu:</label>
            <div class="col-sm-10">
            <select class="form-select form-select-sm w-50 text-center" id="iddm" name="iddm">
                    <option selected disabled>
                        --------Danh sách--------
                    </option>
            <?php
                // Hiển thị danh sách danh mục cha
                $result = $this->cate->selectCategoryParent();
                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <option disabled>
                        <?php echo $row['T_name_category'] ?>
                    </option>

                    <?php
                        $parentId = $row['I_id_category'];
                        // Hiển thị danh sách danh mục con
                        $result1 = $this->cate->selectCategorySub2($parentId);
                        while ($row1 = mysqli_fetch_array($result1)) {
                    ?>
                            <option value="<?php echo $row1['I_id_category'] ?>">
                                <?php echo $row1['T_name_category'] ?>
                            </option>
                    <?php
                        }
                    ?>
                <?php
                }
                ?>
            </select>
            </div>
        <?php   
        }
        // Select option phân loại danh mục để sửa sản phẩm (include đến file product_update)
        public function optionProductCate1(){
        ?>
            <select class="form-select form-select-sm w-50 text-center" id="iddm" name="iddm">
                    <option selected disabled>
                        --------Danh sách--------
                    </option>
            <?php
                $result = $this->cate->selectCategoryParent();
                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <option disabled>
                        <?php echo $row['T_name_category'] ?>
                    </option>

                    <?php
                        $parentId = $row['I_id_category'];
                        $result1 = $this->cate->selectCategorySub2($parentId);
                        $resultPro = $this->pro->selectProduct1($_GET['id_sua']);
                        $rowPro = mysqli_fetch_array($resultPro);
                        while ($row1 = mysqli_fetch_array($result1)) {
                    ?>
                            <option value="<?php echo $row1['I_id_category'] ?>" <?php echo ($row1['I_id_category'] == $rowPro['I_id_category']) ? 'selected' : '';   ?>>
                                    <?php echo $row1['T_name_category']; ?>
                            </option>    
                    <?php
                        }
                    ?>
                <?php
                }
                ?>
            </select>
        <?php
        }
// Chi tiết sản phẩm
        // Hiển thị chi tiết sản phẩm
        public function selectProductDetail(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
                $result=$this->pro->selectProductDetail($idpro);
                return $result;
            }
        }
        // Thêm chi tiết sản phẩm
        public function insertProductDetailInfo(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
            } 
            if(isset($_POST['btn'])){
                $name = $_POST['ten'];
                $value = $_POST['giatri'];
                $result=$this->pro->insertProductDetailInfo($idpro, $name, $value);
                return $result;
            }
        }
        // Sửa chi tiết sản phẩm
        public function updateProductDetailInfor(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
            } 
            if(isset($_POST['btn'])){
                $iddepro = $_POST['iddepro'];
                $name = $_POST['ten'];
                $value = $_POST['giatri'];
                $this->pro->updateProductDetailInfor($idpro, $iddepro, $name, $value);
                header("location: main.php?ql=pro_de&idpro={$idpro}");
            }
        }
        // Xóa chi tiết sản phẩm
        public function deleteProductDetail(){
            if(isset($_GET['id_xoa_sp_chi_tiet'])){
                $id_xoa_sp_chi_tiet=$_GET['id_xoa_sp_chi_tiet'];
                $this->pro->deleteProductDetail($id_xoa_sp_chi_tiet);
                $idpro = isset($_GET['idpro']) ? $_GET['idpro'] : '';
                header("location: main.php?ql=pro_de&idpro={$idpro}");
            }
        }
// Loại sản phẩm
        // Hiển thị thông tin loại sản phẩm
        public function selectProductType(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
            }
            $result=$this->pro->selectProductType($idpro);
            return $result;
        }
        // Hiển thị thông tin loại sản phẩm cụ thể để sửa
        public function selectProductType1(){
            if(isset($_GET['id_sua_type_pro'])){
                $idprotype = $_GET['id_sua_type_pro'];
                $result = $this->pro->selectProductType1($idprotype);
                return $result;
            }
        }
        // Thêm loại sản phẩm
        public function insertProductType(){
            if(isset($_GET['idpro'])){
                $idpro = $_GET['idpro'];
            }
            if(isset($_POST['btn'])){
                $name = $_POST['ten'];
                $img = $_POST['hinhanh'];
                $qty = $_POST['soluong'];
                $price = $_POST['gia'];
                $result=$this->pro->insertProductType($idpro, $name, $img, $qty, $price); 
                return $result;
            }
        }
        // Sửa loại sản phẩm
        public function updateProductType(){
            if(isset($_POST['btn'])){
                $name = $_POST['ten'];
                $img = $_POST['hinhanh'];
                $qty = $_POST['soluong'];
                $price = $_POST['gia'];
                $idprotype = $_GET['id_sua_type_pro'];
                $this->pro->updateProductType($name, $img, $qty, $price, $idprotype);

                $idpro = isset($_GET['idpro']) ? $_GET['idpro'] : '';
                header("location: main.php?ql=pro_de&idpro={$idpro}");
            }
        }
        // Xóa loại sản phẩm
        public function deleteProductType(){
            if(isset($_GET['id_xoa_type_pro'])){
                $id_xoa_type_pro=$_GET['id_xoa_type_pro'];
                $this->order->deleteProductTypeOrderDetail($id_xoa_type_pro); // Xóa loại sản phẩm có trong đơn hàng
                $this->pro->deleteProductType($id_xoa_type_pro);
                
                $idpro = isset($_GET['idpro']) ? $_GET['idpro'] : '';
                header("location: main.php?ql=pro_de&idpro={$idpro}");
            }
        }
        // Tổng tất cả loại sp còn lại
        public function sumProductType(){
            return $this->pro->sumProductType();
        }
        // Đếm số lượng sản phẩm đã bán
        public function sumProductSale(){
            return $this->pro->sumProductSale();
        }
        // Thống kê sản phẩm đã bán
        public function thongKeSpDaBan(){
            $rs = $this->pro->thongKeSpDaBan();

            // Chuyển đổi dữ liệu thành mảng
            $data = array();
            while($row=mysqli_fetch_array($rs)){
                $data[] = $row;
            }
            echo json_encode($data);
        }
    }
?>