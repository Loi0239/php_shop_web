<?php
    include_once('../model/orderModel.php');

    class OrderController{
        private $order;

        public function __construct($conn) {
            $this->order = new OrderModel($conn);
        }
        // Hiển thị tất cả đơn hàng
        public function selectOrder(){
            $result = $this->order->selectOrder();
            return $result;
        }
        // Hiển thị để lọc đơn hàng theo trạng thái
        public function selectOrderWithFilter(){
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectedStatus = $_POST['trangthai'];
                $result = $this->order->selectOrderWithFilter($selectedStatus);
                return $result;
            }
        }
        // Cập nhật trạng thái đơn hàng
        public function updateStatusOrder(){
            if(isset($_POST['sua_trang_thai'])){
                $trangthai = $_POST['trangthai'];
                $idOrder = $_GET['idOrder'];
                $this->order->updateStatusOrder($trangthai, $idOrder);
                header('location: main.php?ql=order');
            }
        }
        // Hiển thị đơn hàng chi tiết
        public function selectOrderDetail(){
            if(isset($_GET['idOrder'])){
                $idOrder = $_GET['idOrder'];
                $result = $this->order->selectOrderDetail($idOrder);
                return $result;
            }
        }
        // Xóa đơn hàng
        public function deleteOrder(){
            if(isset($_POST['xoa_don_hang'])){
                $idOrder = $_GET['idOrder'];
                $this->order->deleteOrderDetail($idOrder);
                $this->order->deleteOrder($idOrder);
                header('location: main.php?ql=order');
            }
        }
        public function deleteProductTypeOrderDetail(){
            
        }
    }
?>