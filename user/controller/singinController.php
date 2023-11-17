<?php
    include_once("../../model/signinModel.php");


    class SigninController{
        private $signin_sign;

        public function __construct($conn) {
            $this->signin_sign = new SigninModel($conn);
        }

        public function check($username, $password){
            $result = $this->signin_sign->check();
            while($row = mysqli_fetch_array($result)){
                if(!strcmp($username, $row['T_user_name']) && !strcmp($password, $row['T_password'])){
                    if($row['B_type']){
                        return "admin";
                    }else{
                        return "user";
                    }
                }
            }
            return false;
        }
    }
?>