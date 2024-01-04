<?php
    class InfoUserModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectData($username){
            $sql = "SELECT * FROM users WHERE T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function updateData($name,$birthday,$gender,$address,$number,$email,$user_id){
            $sql = "UPDATE users SET T_name= '$name' , D_day_of_birth= '$birthday', T_gender= '$gender', T_address= '$address', 
            T_number_phone= '$number', T_email= '$email' WHERE I_id_user= $user_id";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>