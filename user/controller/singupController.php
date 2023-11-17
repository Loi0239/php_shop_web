<?php
    include_once("../../model/signupModel.php");


    class SignupController{
        private $signup_sign;

        public function __construct($conn) {
            $this->signup_sign = new SignupModel($conn);
        }

        public function insert($username, $password, $email, $phonenumber){
            $result = $this->signup_sign->insert($username, $password, $email, $phonenumber);
            return $result;
        }
    }
?>