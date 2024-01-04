<?php
    class InvoiceModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function getIdUser($username){
            $sql="SELECT I_id_user FROM users WHERE T_user_name = '$username'";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_id_user'];
        }

        public function selectData($invoice,$iduser){
            if($invoice == -1){
                $sql="SELECT I_id_orders,T_code_orders,T_order_date,I_status FROM orders WHERE I_id_user = $iduser";
            }else{
                $sql="SELECT I_id_orders,T_code_orders,T_order_date,I_status FROM orders WHERE I_status = $invoice AND I_id_user = $iduser";
            }
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function deleteInvoice($idOrder){
            $sql = "UPDATE orders SET I_status = '5' WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function confirmInvoice($idOrder){
            $sql = "UPDATE orders SET I_status = '4' WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function restoreInvoice($idOrder){
            $sql = "UPDATE orders SET I_status = '0' WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>