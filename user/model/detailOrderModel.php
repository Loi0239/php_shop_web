<?php
    class DetailOrderModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectInfo($idOrder){
            $sql = "SELECT T_code_orders, T_name_user, I_status FROM orders WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function getStatus($idOrder){
            $sql = "SELECT I_status FROM orders WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_status'];
        }

        public function getComment($idCmt){
            $sql = "SELECT T_comment FROM review WHERE I_id = $idCmt";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            if($idCmt == 0){
                return "";
            }else{ 
                return $row['T_comment'];
            }
        }

        public function getStar($idCmt){
            $sql = "SELECT I_star FROM review WHERE I_id = $idCmt";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            if($idCmt == 0){
                return 0;
            }else{
                return $row['I_star'];
            }
        }

        public function selectDetail($idOrder){
            $sql = "SELECT * FROM order_detail WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function selectTypePro($idTypePro){
            $sql = "SELECT T_name,T_image_sample_type_pro FROM product_type WHERE I_id_type_pro = $idTypePro";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function addReview($star,$content,$idUser,$idsp,$idtsp){
            $sql = "INSERT INTO review (I_star, T_comment, I_likes, I_id_pro, I_id_type_pro, I_id_user)
            VALUES ($star, '$content', 0, $idsp, $idtsp, $idUser)";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function updateReview($star,$content,$idUser,$idsp,$idtsp,$idcmt){
            $sql = "UPDATE review SET I_star = $star, T_comment = '$content', I_id_pro = $idsp,
            I_id_type_pro = $idtsp, I_id_user = $idUser WHERE (I_id = $idcmt)";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function getNamePro($idTypePro){
            $sql = "SELECT T_name_pro FROM product 
            JOIN product_type ON product.I_id_pro = product_type.I_id_pro
            WHERE product_type.I_id_type_pro = $idTypePro";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['T_name_pro'];
        }

        public function getIdPro($idTypePro){
            $sql = "SELECT I_id_pro FROM product_type WHERE I_id_type_pro = $idTypePro";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_id_pro'];
        }

        public function getIdUser($idOrder){
            $sql = "SELECT I_id_user FROM orders WHERE I_id_orders = $idOrder";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_id_user'];
        }

        public function getIdCmt($idPro,$idTypePro,$idUser){
            $sql = "SELECT I_id FROM review WHERE I_id_pro = $idPro AND I_id_type_pro = $idTypePro AND I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            if(empty($row['I_id'])){
                $idcmt = 0;
            }else{
                $idcmt = $row['I_id'];
            }
            return $idcmt;
        }

        public function addReviewed($idUser){
            $sql = "UPDATE users SET I_reviewed = I_reviewed + 1 WHERE I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }
    }
?>