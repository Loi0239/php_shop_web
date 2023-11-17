<?php
    class HomeModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectData($username){
            $sql = "SELECT cp.* FROM cart_pro cp
            JOIN cart c ON cp.I_id_cart = c.I_id_cart
            JOIN users u ON c.I_id_user = u.I_id_user
            WHERE u.T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>