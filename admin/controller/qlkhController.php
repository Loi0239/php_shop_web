<?php
    include_once('../model/qlkhModel.php');

    class QlkhController{
        private $qlkh;

        public function __construct($conn) {
            $this->qlkh = new QlkhModel($conn);
        }

        public function showData($name_table){
            return $this->qlkh->selectData($name_table);
        }
    }
?>