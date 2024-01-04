<?php
    include_once('user/model/cartModel.php');

    class CartController{
        private $cart_sign;

        public function __construct($conn) {
            $this->cart_sign = new CartModel($conn);
        }

        public function selectCount($usename){
            $result = $this->cart_sign->selectCount($usename);
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

        public function selectData($idsps,$qtys,$idCart){
            $result = $this->cart_sign->selectData($idCart);
            $resultIdUser = $this->cart_sign->getIdUser($_SESSION['username']);
            $count = 0;
            if($result){
                while($row_result = mysqli_fetch_array($result)){
                    $qty = $this->cart_sign->getQty($row_result['I_id_type_pro']);
                    echo '
                        <div class="row show_item" data-idcart="'.$idCart.'" data-idsp="'.$row_result['I_id_pro'].'" 
                        data-idtsp="'.$row_result['I_id_type_pro'].'" data-iduser="'.$resultIdUser.'">
                            <div class="col-5 show_pro">
                                <input type="checkbox" name="check" id="child_check" data-price="'.$row_result['I_price']*$qtys[$count].'">
                                <img src="public/img/'.$row_result['T_image_sample_type_pro'].'" alt="ảnh sản phẩm">
                                <h5 class="name_product">'.$row_result['T_name_pro'].' - '.$row_result['T_name'].'</h5>
                            </div>
                            <div class="col-2 price_cart">
                                <span class="test">'.$row_result['I_price'].'</span>
                            </div>
                            <div class="col-2 qty">
                                <button type="button" class="decrement">-</button>
                                <input type="input" name="count[]" class="count" required value="'.$qtys[$count].'" min="1" max="'.$qty.'" onchange="updateQty(this)">
                                <button type="button" class="increment">+</button>
                                <input type="hidden" name="hidden_count[]" class="hidden_count" value="'.$qtys[$count].'-'.$row_result['I_id_pro'].'-'.$row_result['I_id_type_pro'].'">
                            </div>
                            <div class="col-2 total_price_cart">
                                <span>'.$row_result['I_price']*$qtys[$count].'</span>
                            </div>
                            <div class="col-1">
                                <i class="delete fa-solid fa-trash-can"></i>
                            </div>
                        </div>
                    ';
                    $count++;
                }
            }
        }

        public function getIdCart($username){
            $result = $this->cart_sign->getIdCart($username);
            $row = mysqli_fetch_array($result);
            return $row['I_id_cart'];
        }

        public function getIdsps($username){
            $total_cart = $this->cart_sign->selectCount($username);
            $idsps = array();
            while($row = mysqli_fetch_array($total_cart)){
                if(!in_array($row['I_id_pro'],$idsps)){
                    $idsps[] = $row['I_id_pro'];
                }
            }
            return $idsps;
        }

        public function getQtys($username){
            $total_cart = $this->cart_sign->selectCount($username);
            $qtys = array();
            while($row = mysqli_fetch_array($total_cart)){
                $qtys[] = $row['I_qty'];
            }
            return $qtys;
        }

        public function getIdtsps($username){
            $total_cart = $this->cart_sign->selectCount($username);
            $idtsps = array();
            while($row = mysqli_fetch_array($total_cart)){
                $idtsps[] = $row['I_id_type_pro'];
            }
            return $idtsps;
        }

        public function updateCart($idCart,$idsps,$counts,$sign,$idtsps,$count_keys){
            $result = $this->cart_sign->updateCart($idCart,$idsps,$counts,$sign,$idtsps,$count_keys);
            if($result){
                return $msg = "success_cart";
            }else{
                return $msg = "fail_cart";
            }
        }

        public function deleteCart($idCart,$idsp,$idtsp){
            return $this->cart_sign->deleteCart($idCart,$idsp,$idtsp);
        }
    }
?>