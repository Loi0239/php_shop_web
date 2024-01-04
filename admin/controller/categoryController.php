<?php
    include_once('../model/categoryModel.php');
    include_once('../model/productModel.php');
    include_once('../model/orderModel.php');

    class CategoryController{
        private $cate;
        private $pro;
        private $order;

        public function __construct($conn) {
            $this->cate = new CategoryModel($conn);
            $this->pro = new ProductModel($conn);
            $this->order = new OrderModel($conn);
        }
// Danh mục cha
        // Hiển thị thông tin danh mục cha để quản lí
        public function selectCategoryParent(){
            return $this->cate->selectCategoryParent();
        }
        // Hiển thị thông tin danh mục cha để sửa
        public function selectCategoryParent1(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
                $data = $this->cate->selectCategoryParent1($id_sua);
                return $data;
            }
        }
        // Thêm thông tin danh mục cha
        public function insertCategoryParent(){
            if(isset($_POST['btn'])){
                $name = $_POST['tendm'];
                $image = $_FILES['img']['name']; // Chỉ lấy tên hình ảnh để gửi lên database
                $image_tmp_name = $_FILES['img']['tmp_name']; // Lấy đường dẫn của ảnh

                $result = $this->cate->insertCategoryParent($name, $image);
                move_uploaded_file($image_tmp_name, '../../public/img/'. $image);
                header('location: main.php?ql=cate_pr');
            }
        }
        // Sửa danh mục cha
        public function updateCategoryParent(){
            if(isset($_POST['btn'])){
                $name = $_POST['tendm'];
                $image = $_FILES['img']['name']; // Chỉ lấy tên hình ảnh để gửi lên database
                $image_tmp_name = $_FILES['img']['tmp_name']; // Lấy đường dẫn của ảnh
                $id_sua = $_GET['id_sua'];

                $this->cate->updateCategoryParent($name, $image, $id_sua);
                move_uploaded_file($image_tmp_name, '../../public/img/'. $image);
                header('location: main.php?ql=cate_pr');
            }
        }
        // Xóa thông tin danh mục cha
        public function deleteCategoryParent(){
            if(isset($_GET['id_xoa'])){
                $id_xoa = $_GET['id_xoa']; // $id_xoa = I_id_category (của danh mục cha)
                $sql = $this->cate->selectCategorySub3($id_xoa);  // Hiển thị thông danh mục con để lấy được I_id_category                               
                if($row = mysqli_fetch_array($sql)){
                    $id_xoa1 = $row['I_id_category']; // I_id_category (của danh mục con)

                    $sql = $this->pro->selectProduct2($id_xoa1); // Hiển thị sản phẩm ở I_id_category
                    if($result=mysqli_fetch_array($sql)){
                        $idpro = $result['I_id_pro'];
                        $this->pro->deleteProductDetail($idpro); // Xóa chi tiết sản phẩm

                        $query = $this->pro->selectProductType($idpro);
                        if($row = mysqli_fetch_array($query)){
                            $idprotype = $row['I_id_type_pro'];
                            $this->order->deleteProductTypeOrderDetail($idprotype); // Xóa loại sp có trong đơn hàng
                        }
                        $this->pro->deleteProductType1($idpro); // Xóa loại sản phẩm
                            
                        $this->pro->deleteProduct($idpro); // Xóa sản phẩm 
                    }
                    $this->cate->deleteCategorySub1($id_xoa1); // Xóa danh mục con 
                }
                $this->cate->deleteCategoryParent($id_xoa); // Xóa danh mục cha
                header('location:main.php?ql=cate_pr');
            }
        }

// Danh mục con
        // Hiển thị thông tin danh mục con để quản lí
        public function selectCategorySub(){
            if(isset($_GET['id_sub'])){
                $data = $this->cate->selectCategorySub($_GET['id_sub']);
                return $data;
            }
        }
        // Hiển thị thông tin danh mục con để sửa
        public function selectCategorySub1(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
                $data = $this->cate->selectCategorySub1($id_sua);
                return $data;
            }
        }
        public function selectCategorySub2($idPr){
            if(isset($_GET['danhmucPR'])){
                $idPr=$_GET['danhmucPR'];
                $data = $this->cate->selectCategorySub($idPr);
                return $data;
            }
        }
        // Thêm thông tin danh mục con
        public function insertCategorySub(){
            if(isset($_POST['btn'])){
                $name = $_POST['tendm'];
                $iddm = $_POST['iddm'];

                $result = $this->cate->insertCategorySub($name, $iddm);
                // Lấy giá trị id_sub từ URL
                $id_sub = isset($_GET['id_sub']) ? $_GET['id_sub'] : '';
                // Chuyển hướng về trang main.php với tham số id_sub
                header("location: main.php?ql=cate_sub&id_sub={$id_sub}");
            }
        }
        // Sửa thông tin danh mục con
        public function updateCategorySub(){
            if(isset($_POST['btn'])){
                $name = $_POST['tendm'];
                $iddm = $_POST['iddm'];
                $id_sua = $_GET['id_sua'];

                $this->cate->updateCategorySub($name, $iddm, $id_sua);
                $id_sub = isset($_GET['id_sub']) ? $_GET['id_sub'] : '';
                header("location: main.php?ql=cate_sub&id_sub={$id_sub}");
            }
        }
        // Xóa thông tin danh mục con
        public function deleteCategorySub(){
            if(isset($_GET['id_xoa'])){
                $id_xoa = $_GET['id_xoa']; // $id_xoa = I_id_category

                $sql=$this->pro->selectProduct2($id_xoa);
                // $result=mysqli_fetch_array($sql);
                if($result=mysqli_fetch_array($sql)){
                    $idpro = $result['I_id_pro'];
                    $this->pro->deleteProductDetail($idpro); // Xóa chi tiết sản phẩm
    
                    $query = $this->pro->selectProductType($idpro);
                    $row = mysqli_fetch_array($query);
                    $idprotype = $row['I_id_type_pro'];
                    $this->order->deleteProductTypeOrderDetail($idprotype); // Xóa loại sp có trong giỏ hàng
    
                    $this->pro->deleteProductType1($idpro); // Xóa loại sản phẩm
    
                    $this->pro->deleteProduct($idpro); // Xóa sản phẩm
                }

                $this->cate->deleteCategorySub($id_xoa); // Xóa danh mục con

                $id_sub = isset($_GET['id_sub']) ? $_GET['id_sub'] : '';
                header("location: main.php?ql=cate_sub&id_sub={$id_sub}");                
            }
        }
    }
?>