<?php
    include_once('user/model/cartModel.php');

    class HomeController{
        private $cart_sign;

        public function __construct($conn) {
            $this->cart_sign = new HomeModel($conn);
        }

        public function selectData($usename){
            $result = $this->cart_sign->selectData($usename);
            $total_cart = 0;
            if($result){
                while($row = mysqli_fetch_array($result)){
                    $total_cart ++;
                }
                echo "
                        <a href='index.php?route=cart' class='fas fa-shopping-cart' id='cart-btn'>
                            <span class='count_cart'>".$total_cart."</span>
                        </a>
                    ";
            }else{
                return 0;
            }
        }
    }
?>