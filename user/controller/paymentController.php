<?php
    include_once('user/model/paymentModel.php');

    class PaymentController{
        private $payment_sign;

        public function __construct($conn) {
            $this->payment_sign = new PaymentModel($conn);
        }

        public function getData($iduser,$idsps,$idtsps,$counts){
            echo'
                <input type="hidden" name="iduser" value="'.$iduser.'">
                <input type="hidden" name="idsps" value="'.http_build_query($idsps).'">
                <input type="hidden" name="idtsps" value="'.http_build_query($idtsps).'">
                <input type="hidden" name="counts" value="'.http_build_query($counts).'">
            ';
        }

        public function selectInfoUser($iduser){
            $row = $this->payment_sign->selectInfoUser($iduser);
            $addresses = explode("|", $row['T_address']);
            echo $addresses[0];
            echo'
                <h3 class="title">thông tin thanh toán</h3>
                <div class="inputBox">
                    <span>họ và tên :</span>
                    <input type="text" name="name" placeholder="Họ tên của bạn" value="'.$row['T_name'].'">
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>số điện thoại :</span>
                        <input type="text" name="numberPhone" placeholder="Số điện thoại của bạn" value="'.$row['T_number_phone'].'">
                    </div>
                    <div class="inputBox">
                        <span>địa chỉ email :</span>
                        <input type="text" name="email" placeholder="Email của bạn" value="'.$row['T_email'].'">
                    </div>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>tỉnh/thành phố :</span>
                        <select name="city" id="province">
                            <option value="" data-district="0">--Chọn tỉnh/thành phố--</option>
            ';
            // Lấy danh sách tỉnh thành từ API
            $api_url = 'https://provinces.open-api.vn/api/p';
            $response = file_get_contents($api_url);
            $provinces_data = json_decode($response, true);
            // Hiển thị các tỉnh thành trong dropdown
            foreach ($provinces_data as $province) {
                $selected = ($addresses[0] === $province['name']) ? 'selected' : '';
                echo "<option value=\"{$province['name']}\" data-district='{$province['code']}' {$selected}>{$province['name']}</option>";
            }   
            echo'
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>quận/huyện :</span>
                        <select name="district" id="district">
                            <option value="'.$addresses[1].'">'.$addresses[1].'</option>
                            
                        </select>
                    </div>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Chọn phường/xã</span>
                        <select name="ward" id="ward">
                            <option value="'.$addresses[2].'">'.$addresses[2].'</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <span>địa chỉ :</span>
                        <input type="text" name="address-detail" placeholder="Ví dụ: số 20, ngõ 90" value="'.$addresses[3].'">
                    </div>
                </div>
                <div class="inputBox">
                    <input type="checkbox" name="check-address" value="on">
                    <span style="color: #444;">giao hàng tới địa điểm khác?</span>
                </div>
                <div class="inputBox">
                    <span>ghi địa chỉ đơn hàng (tùy chọn)</span>
                    <textarea name="orther-place" placeholder="Nhập một địa điểm khác mà bạn có thể nhận hàng thuận tiện hơn."></textarea>
                </div>
            ';
        }

        public function selectInfoPro($idsps, $idtsps, $counts){
            $result = $this->payment_sign->selectInfoPro($idsps,$idtsps,$counts);
            while($row=mysqli_fetch_assoc($result)){
                $idproIndexes = array_keys($idsps, $row['I_id_pro']);
                $idtypeproIndexes = array_keys($idtsps, $row["I_id_type_pro"]);
                $commonIndexes = array_intersect($idproIndexes, $idtypeproIndexes);
                echo'
                    <tr class="row row-info-pro">
                        <td class="col-2"><img src="public/img/'.$row['T_image_sample_type_pro'].'" alt=""></td>
                        <td class="col-4 info">
                        <span class="info-name-pro">'.$row['T_name_pro'].'-'.$row['T_name'].'</span> 
                        <span>số lượng x'.$counts[implode(", ", $commonIndexes)].'</span></td>
                        <td class="col-4"></td>
                        <td class="col-2 price">'.$row['I_price']*$counts[implode(", ", $commonIndexes)].'</td>
                    </tr>
                ';
            }
            echo'
                <tr class="row row-info-pro">
                    <td class="col-2" style="font-weight: 600;font-size:1.4rem">Tổng tiền</td>
                    <td class="col-4 info"></td>
                    <td class="col-4"></td>
                    <td class="col-2 price-total" style="font-weight: 600;font-size:1.4rem">0</td>
                </tr>
            ';
        }
        
        public function insertOrder($iduser,$idsps,$idtsps,$counts,$ship,$payment,
        $name,$numberPhone,$email,$address){
            //tạo mã đơn hàng tự động
            $kitu = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $codeLength=4;
            $orderCode ='#';
            for($i=0;$i<$codeLength;$i++){
                $orderCode .= $kitu[rand(0, strlen($kitu) - 1)];
            }
            $orderDate = date("Y-m-d H:i:s");
            $resultOrder = $this->payment_sign->insertOrder($iduser,$orderCode,$name,$numberPhone,
            $address,$email,$orderDate,$ship,$payment);
            $resultOrderDetail = $this->payment_sign->insertOrderDetail($resultOrder,$idtsps,$idsps,$counts);
            if($resultOrderDetail){
                $resulDecrease = $this->payment_sign->decreaseQty($idtsps,$counts);
                $resulIncrease = $this->payment_sign->increaseQty($idsps,$counts);
                return "success";
            }else{
                return "có lỗi";
            }
        }

        public function clearCart($iduser,$idsps,$idtsps){
            $idCart = $this->payment_sign->getIdCart($iduser);
            $result = $this->payment_sign->clearCart($idsps,$idtsps,$idCart);
            return $result;
        }
    }
?>