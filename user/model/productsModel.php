<?php
    class ProductsModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function select_category(){
            $sql = "SELECT * FROM category";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select_category_parent(){
            $sql = "SELECT * FROM category WHERE I_id_parent IS NULL";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select_sub_category($iddm){
            $sql = "SELECT * FROM category WHERE I_id_parent = $iddm";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select($iddm,$start,$limit,$count){
            if(empty($iddm)){
                $sql = "SELECT * FROM product LIMIT $start,$limit";
            }else if($count > 0){
                $sql = "SELECT * FROM product p 
                JOIN pro_cate pc ON p.I_id_pro = pc.I_id_pro 
                JOIN category c ON pc.I_id_category = c.I_id_category 
                WHERE c.I_id_parent = ".$iddm." LIMIT $start, $limit";
            }else{
                $sql = "SELECT * FROM product p 
                JOIN pro_cate c ON p.I_id_pro = c.I_id_pro 
                WHERE c.I_id_category = ".$iddm." LIMIT $start, $limit";
            }

            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function newSelect(){
            $sql = "SELECT * FROM product ORDER BY I_id_pro DESC LIMIT 20";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function addCart($idCart,$idsp){
            $sql_select = "SELECT * FROM cart_pro WHERE I_id_cart = $idCart AND I_id_pro = $idsp";
            $result_select = mysqli_query($this->conn,$sql_select);
            $row = mysqli_fetch_array($result_select);
            if($row !== null){
                $sql_update = "UPDATE cart_pro SET I_qty = ".($row['I_qty'] + 1).
                " WHERE I_id_cart = $idCart AND I_id_pro = $idsp";
                $result_update = mysqli_query($this->conn,$sql_update);
                return $result_update;
            }else{
                $sql = "INSERT INTO cart_pro (I_id_cart, I_id_pro, I_qty) VALUES ($idCart, $idsp, '1')";
                $result = mysqli_query($this->conn, $sql);
                return $result;
            }
        }

        public function getID_user($username){
            $sql = "SELECT I_id_user FROM users WHERE T_user_name = '$username'";
            $row = mysqli_fetch_assoc(mysqli_query($this->conn,$sql));
            $idUser = $row['I_id_user'];
            return strval($idUser);
        }

        public function getId_cart($idUser){
            $sql = "SELECT I_id_cart FROM cart WHERE I_id_user = '$idUser'";
            $row = mysqli_fetch_assoc(mysqli_query($this->conn,$sql));
            $idCart = $row['I_id_cart'];
            return strval($idCart);
        }

        public function getTotal_records($iddm){
            if(empty($iddm)){
                $sql = "SELECT COUNT(I_id_pro) as total FROM product";
            }else{
                $sql = "SELECT COUNT(p.I_id_pro) as total FROM product p
                JOIN pro_cate c ON p.I_id_pro = c.I_id_pro
                WHERE c.I_id_category = $iddm";
            }

            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row['total'];
        }
    }
?>