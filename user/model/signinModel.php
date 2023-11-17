<?php
    class SigninModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function check(){
            $sql = "SELECT * FROM users";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>