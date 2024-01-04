<?php
    class OrderModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }
        // Hiển thị tất cả đơn hàng
        public function selectOrder(){
            $sql = "SELECT * FROM orders";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị đơn hàng cụ thể
        public function selectOrder1($idOrder){
            $sql = "SELECT * FROM orders WHERE I_id_orders=$idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Hiển thị để lọc đơn hàng theo trạng thái
        public function selectOrderWithFilter($selectedStatus){
            $sql = "SELECT * FROM orders where I_status=$selectedStatus";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Cập nhật trạng thái đơn hàng
        public function updateStatusOrder($trangthai, $idOrder){
            $sql = "UPDATE orders SET I_status=$trangthai WHERE I_id_orders=$idOrder";
            mysqli_query($this->conn, $sql);
        }
        // Hiển thị đơn hàng chi tiết
        public function selectOrderDetail($idOrder){
            $sql = "SELECT
                        orders.I_id_orders,
                        orders.T_code_orders,
                        orders.T_name_user,
                        orders.T_number_phone,
                        orders.T_address,
                        orders.T_email,
                        orders.I_status,
                        order_detail.I_qty,
                        order_detail.I_price,
                        product_type.I_id_type_pro,
                        product_type.T_name,
                        product_type.T_image_sample_type_pro
                    FROM order_detail 
                    INNER JOIN orders ON order_detail.I_id_orders = orders.I_id_orders
                    INNER JOIN product_type ON order_detail.I_id_type_pro = product_type.I_id_type_pro
                    where order_detail.I_id_orders='$idOrder'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa đơn hàng
        public function deleteOrder($idOrder){
            $sql = "DELETE FROM orders WHERE I_id_orders=$idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        public function deleteOrderDetail($idOrder){
            $sql = "DELETE FROM order_detail WHERE I_id_orders=$idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        // Xóa sản phẩm trong đơn hàng chi tiết
        public function deleteProductTypeOrderDetail($idTypePro){
            $sql = "DELETE FROM order_detail WHERE I_id_type_pro= $idTypePro";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>