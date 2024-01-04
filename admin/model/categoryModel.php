<?php
    require_once('../model/categoryModel.php');

    class CategoryModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }
// Danh mục cha
        // Hiển thị thông tin danh mục cha để quản lí
        public function selectCategoryParent(){
            $sql = "SELECT * FROM category WHERE I_id_parent IS NULL ";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị thông tin danh mục cha để sửa
        public function selectCategoryParent1($id_sua){
            $sql = "SELECT * FROM category WHERE I_id_category=$id_sua";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // 
        public function selectCategoryParent2($id_pr){
            $sql = "SELECT * FROM category WHERE I_id_category=$id_pr";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Thêm thông tin danh mục cha
        public function insertCategoryParent($name, $image) {    
            $sql = "INSERT INTO category (T_name_category, T_img_sample_category) VALUES ('$name', '$image') ";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Sửa thông tin danh mục cha
        public function updateCategoryParent($name, $image, $id_sua) {
            $sql = "UPDATE category SET T_name_category = '$name', T_img_sample_category = '$image' WHERE I_id_category = $id_sua ";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa thông tin danh mục cha
        public function deleteCategoryParent($id_xoa){
            $sql = "DELETE FROM category WHERE I_id_category=$id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

// Danh mục con
        // Hiển thị danh sách danh mục con
        public function selectCategorySub($id_sub){
            $sql = "SELECT * FROM category WHERE I_id_parent=$id_sub";
            $result = mysqli_query($this->conn, $sql);
            return $result;            
        }
        // Hiển thị danh sách danh mục con để sửa
        public function selectCategorySub1($id_sua){
            $sql = "SELECT * FROM category WHERE I_id_category=$id_sua";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị danh sách danh mục con để thêm/sửa sản phẩm
        // (dùng trong hàm optionProductCate và optionProductCate1)
        public function selectCategorySub2($parentId){
            $sql = "SELECT * FROM category WHERE I_id_parent = $parentId";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị thông danh mục con để xóa sản phẩm->xóa danh mục cha 
        // (dùng trong hàm deleteCategoryParent())
        public function selectCategorySub3($id_xoa){
            $sql = "SELECT * FROM category WHERE I_id_parent = $id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Thêm danh mục con
        public function insertCategorySub($name, $iddm) {    
            $sql = "INSERT INTO category (T_name_category, I_id_parent) VALUES ('$name', $iddm) ";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Sửa danh mục con
        public function updateCategorySub($name, $iddm, $id_sua) {
            $sql = "UPDATE category SET T_name_category = '$name', I_id_parent=$iddm WHERE I_id_category = $id_sua ";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa danh mục con
        public function deleteCategorySub($id_xoa){
            $sql = "DELETE FROM category WHERE I_id_category=$id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa danh mục con để xóa danh mục cha (dùng trong hàm deleteCategoryParent())
        public function deleteCategorySub1($id_xoa1){
            $sql = "DELETE FROM category WHERE I_id_category=$id_xoa1";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>