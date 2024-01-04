<?php
    include_once('../model/qlkhModel.php');

    class QlkhController{
        private $qlkh;

        public function __construct($conn) {
            $this->qlkh = new QlkhModel($conn);
        }

        public function selectData(){
            return $this->qlkh->selectData();
        }

        public function selectData1(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
                $data = $this->qlkh->selectData1($id_sua);
                return $data;
            }
        }

        public function updateData(){
            if(isset($_GET['id_sua'])){
                $id_sua = $_GET['id_sua'];
            } 
            if(isset($_POST['btn'])){
                $name = $_POST['ten'];
                $phone = $_POST['sdt'];
                $email = $_POST['email'];
                $address = $_POST['diachi'];
                $birth = $_POST['ngaysinh'];
                $result = $this->qlkh->updateData($name, $phone, $email, $address, $birth, $id_sua);
                header('location:main.php?ql=qltk');
            }
        }

        public function deleteData(){
            if(isset($_GET['id_xoa'])){
                $id_xoa = $_GET['id_xoa'];
                $this->qlkh->deleteData($id_xoa);
                header('location:main.php?ql=qltk');
            }
        }
    }
?>