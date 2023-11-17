<?php
    class QlkhModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectData($name_table){
            $sql = "SELECT * FROM $name_table";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
    }
?>