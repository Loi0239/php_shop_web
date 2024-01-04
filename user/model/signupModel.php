<?php
    class SignupModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function insert($username, $password, $email, $phonenumber){
            $sql = "INSERT INTO users (`T_user_name`, `T_password`, `T_number_phone`, `T_email`, `I_reviewed`, `I_likes`, `B_type`) 
            VALUES ('$username', '$password', '$phonenumber', '$email', 0, 0, 0)";
            if($result = mysqli_query($this->conn, $sql)){
                $i_id_user = mysqli_insert_id($this->conn);
                $sql_cart = "INSERT INTO cart (I_id_user) VALUES ($i_id_user)";
                $result_cart = mysqli_query($this->conn, $sql_cart);
                return true;
            }
            return false;
        }
    }
?>
