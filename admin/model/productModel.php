<?php
    class ProductModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }
// SẢN PHẨM
        // Hiển thị thông tin sản phẩm
        public function selectProduct(){
            $sql = "SELECT * FROM product";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị thông tin sản phẩm để sửa
        public function selectProduct1($id_sua){
            $sql = "SELECT * FROM product WHERE I_id_pro=$id_sua";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị thông tin sản phẩm để xóa danh mục và đếm để phân trang sp
        public function selectProduct2($id_xoa){
            $sql = "SELECT * FROM product WHERE I_id_category=$id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị thông tin sản phẩm trong phân trang
        public function selectProductPage($idsub, $limit, $start){
            $sql = "SELECT * FROM product WHERE I_id_category = $idsub LIMIT $limit OFFSET $start";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Thêm sản phẩm
        public function insertProduct($name, $img, $tinhnang, $mota, $iddm){
            $sql = "INSERT INTO product(T_name_pro, T_img_sample_pro, T_feature, T_description, I_id_category) 
                    VALUES ('$name', '$img', '$tinhnang', '$mota', '$iddm')";
            mysqli_query($this->conn, $sql);
        }
        // Sửa sản phẩm
        public function updateProduct($name, $img, $tinhnang, $mota, $iddm, $id_sua){
            $sql = "UPDATE product SET T_name_pro = '$name', T_img_sample_pro = '$img', T_feature = '$tinhnang', T_description = '$mota', I_id_category=$iddm 
                    WHERE I_id_pro = $id_sua";              
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa sản phẩm
        public function deleteProduct($id_xoa){
            $sql = "DELETE FROM product WHERE I_id_pro=$id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
// SẢN PHẨM CHI TIẾT
        // Hiển thị thông tin chi tiết sản phẩm
        public function selectProductDetail($idpro){
            $sql = "SELECT * FROM product_details WHERE I_id_pro=$idpro";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Thêm thông tin chung chi tiết sản phẩm
        public function insertProductDetailInfo($idpro, $name, $value){
            $sql = "INSERT INTO product_details(I_id_pro, T_name, T_value)
                    VALUES ($idpro, '$name', '$value')";
            $result = mysqli_query($this->conn, $sql);
            return $result;     
        }
        // Cập nhật thông tin chung chi tiết sản phẩm
        public function updateProductDetailInfor($idpro, $iddepro, $name, $value){
            $sql = "UPDATE product_details SET T_name='$name', T_value='$value' WHERE I_id_pro=$idpro AND I_id_de_pro=$iddepro";
            $result = mysqli_query($this->conn, $sql);
            return $result; 
        }
        // Xóa chi tiết sản phẩm và (xóa sản phẩm+danh mục)
        public function deleteProductDetail($id_xoa_sp_chi_tiet){
            $sql = "DELETE FROM product_details WHERE I_id_pro=$id_xoa_sp_chi_tiet";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
// PHÂN LOẠI SẢN PHẨM
        // Hiển thị thông tin loại sản phẩm
        public function selectProductType($idpro){
            $sql = "SELECT * FROM product_type WHERE I_id_pro=$idpro";
            $result = mysqli_query($this->conn, $sql);
            return $result; 
        }
        // Hiển thị thông tin loại sản phẩm cụ thể để "sửa" thông tin
        public function selectProductType1($idprotype){
            $sql = "SELECT * FROM product_type WHERE I_id_type_pro=$idprotype";
            $result = mysqli_query($this->conn, $sql);
            return $result; 
        }
        // Thêm loại sản phẩm
        public function insertProductType($idpro, $name, $img, $qty, $price){
            $sql = "INSERT INTO product_type(I_id_pro, T_name, T_image_sample_type_pro, I_qty_in_stock, I_price)
                    VALUES ($idpro, '$name', '$img', $qty, $price)";
            $result = mysqli_query($this->conn, $sql);
            return $result; 
        }
        // Sửa loại sản phẩm
        public function updateProductType($name, $img, $qty, $price, $idprotype){
            $sql = "UPDATE product_type SET T_name='$name', T_image_sample_type_pro='$img',
                    I_qty_in_stock=$qty, I_price=$price WHERE I_id_type_pro=$idprotype";
            mysqli_query($this->conn, $sql);
        }
        // Xóa loại sản phẩm
        public function deleteProductType($id_xoa_type_pro){
            $sql = "DELETE FROM product_type WHERE I_id_type_pro=$id_xoa_type_pro";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Dùng để xóa sản phẩm + danh mục
        public function deleteProductType1($id_xoa){
            $sql = "DELETE FROM product_type WHERE I_id_pro=$id_xoa";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Tổng số lượng tất cả sản phẩm còn lại
        public function sumProductType(){
            $sql = "SELECT SUM(I_qty_in_stock) as Tong_so_luong_con_lai FROM product_type";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Đếm số lượng sản phẩm đã bán
        public function sumProductSale(){
            $sql = "SELECT SUM(I_sold) as Tong_so_luong_da_ban FROM product";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Thống kê sản phẩm đã bán
        public function thongKeSpDaBan(){
            $sql = "SELECT
                        MONTH(o.T_order_date) AS Thang,
                        YEAR(o.T_order_date) AS Nam,
                        SUM(od.I_qty) AS So_luong_da_ban
                    FROM
                        order_detail od
                    JOIN
                        orders o ON od.I_id_orders = o.I_id_orders
                    JOIN
                        product_type pt ON od.I_id_type_pro = pt.I_id_type_pro
                    WHERE
                        o.I_status = 3 -- Chỉ lấy các đơn hàng có trạng thái đã xác nhận
                        AND o.T_order_date BETWEEN '2023-01-01' AND '2023-12-31' -- Thay thế '2023-01-01' và '2023-12-31' bằng khoảng thời gian bạn quan tâm
                    GROUP BY
                        Thang, Nam
                    ORDER BY
                        Nam, Thang";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        public function closeConnection() {
            $this->conn->close();
        }
    }
?>