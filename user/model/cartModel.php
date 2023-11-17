<?php
    class CartModel{
        private $conn; 

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectCount($username){
            $sql = "SELECT cp.* FROM cart_pro cp
            JOIN cart c ON cp.I_id_cart = c.I_id_cart
            JOIN users u ON c.I_id_user = u.I_id_user
            WHERE u.T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }


        public function selectData($idsps){
            if(!empty($idsps)){
                $idspsString = implode(",", $idsps);
                $sql = "SELECT * FROM product WHERE I_id_pro IN ($idspsString)";
                $result = mysqli_query($this->conn,$sql);
                return $result;
            }else{
                return false;
            }
        }

        public function getIdCart($username){
            $sql = "SELECT c.I_id_cart FROM cart c
            JOIN users u ON c.I_id_user = u.I_id_user
            WHERE u.T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function updateCart($idCart,$idsps,$counts){
            $idspsString = implode(",", $idsps);
            $countsString = implode(",", $counts);
            $sql = "UPDATE cart_pro SET I_qty = CASE ";
            foreach ($idsps as $index => $id) {
                $count = $counts[$index];
                $sql .= "WHEN I_id_pro = $id THEN $count ";
            }
            $sql .= "ELSE I_qty END WHERE I_id_pro IN ($idspsString) AND I_id_cart = $idCart";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }    
        
        public function deleteCart($idCart,$idsp){
            $sql = "DELETE FROM cart_pro WHERE I_id_cart = $idCart AND I_id_pro = $idsp";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }
    }
?>