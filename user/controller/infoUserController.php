<?php
    include_once('user/model/infoUserModel.php');

    class InfoUserController{
        private $info_sign;

        public function __construct($conn) {
            $this->info_sign = new InfoUserModel($conn);
        }

        public function selectData($usename, $errorMessage){
            $result = $this->info_sign->selectData($usename);
            $row = mysqli_fetch_assoc($result);
            echo '
                <input type="hidden" name="user_id" value="'.$row['I_id_user'].'">
                <div class="row">
                    <h3 class="title">thông tin của bạn</h3>
                    <div class="inputBox col-4">
                        <span>họ và tên</span>
                        <input type="text" name="name" value="'.$row['T_name'].'"> <br>
                    </div>
                    <div class="inputBox col-4">
                        <span style="margin-right: 10px;">ngày sinh</span>
                        <input type="date" placeholder="Vui lòng nhập ngày sinh" name="birthday" value="'.$row['D_day_of_birth'].'">
                    </div>
            
                    <div class="inputBox gender col-4">
                        <span for="sex">Giới tính</span>
                        <div class="totalBox-select">
                            <div class="box-select">
                                <input class="select-gender" type="radio" name="sex" value="Nam"'. ($row['T_gender'] == "Nam" ? "checked" : "").'>
                                <span style="margin-right: 10px;">Nam</span>
                            </div>
                            <div class="box-select">
                                <input class="select-gender" type="radio" name="sex" value="Nữ" '. ($row['T_gender'] == "Nữ" ? "checked" : "").'>
                                <span style="margin-right: 10px;">Nữ</span>
                            </div>
                            <div class="box-select">
                                <input class="select-gender" type="radio" name="sex" value="Khác" '. ($row['T_gender'] == "Khác" ? "checked" : "").'>
                                <span style="margin-right: 10px;">Khác</span>
                            </div>    
                        </div>   
                    </div>
  
                    <div class="inputBox">
                        <span>Địa chỉ</span>
                        <div class="grid grid-3">
                            <select class="selectBox" name="" id="province">
                            </select>
                            <select class="selectBox" name="" id="district">
                                <option value="">chọn quận</option>
                            </select>
                            <select class="selectBox" name="" id="ward">
                                <option value="">chọn phường</option>
                            </select>
                            <input type="text" name="address" placeholder="Vui lòng nhập số nhà và tên đường">
                        </div>
            
                        <input type="hidden" name="province" id="result">
                    </div>

                    <div class="grid grid-2">
                        <div class="inputBox">
                        <span>số điện thoại</span>
                        <input type="number" name="number" value="'.$row['T_number_phone'].'" placeholder="+111 222 33344" maxlength="10">
                        </div>
                        <div class="inputBox">
                        <span>email :</span>
                        <input type="email" name="email" value="'.$row['T_email'].'" placeholder="npc123@gmail.com">
                        </div>
                    </div>
                    <span class="error-message">'.$errorMessage.'</span>
                </div>
            ';
        }

        public function updateData($name,$birthday,$gender,$address,$number,$email,$user_id){
            $result = $this->info_sign->updateData($name,$birthday,$gender,$address,$number,$email,$user_id);
        }
    }
?>