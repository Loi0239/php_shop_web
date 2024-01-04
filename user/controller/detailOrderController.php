<?php
    include_once('user/model/detailOrderModel.php');

    class DetailOrderController{
        private $detailOrder_sign;

        public function __construct($conn) {
            $this->detailOrder_sign = new DetailOrderModel($conn);
        }

        public function selectInfo($idOrder){
            $result = $this->detailOrder_sign->selectInfo($idOrder);
            $row = mysqli_fetch_assoc($result);
            echo'
                <p>Mã đơn hãng: <span>'.$row['T_code_orders'].'</span></p>
                <p>Họ và tên: <span>'.$row['T_name_user'].'</span></p>
            ';
        }

        public function selectDetail($idOrder){
            $result = $this->detailOrder_sign->selectDetail($idOrder);
            $idUser = $this->detailOrder_sign->getIdUser($idOrder);
            $count = 1;
            while($row = mysqli_fetch_array($result)){
                $namePro = $this->detailOrder_sign->getNamePro($row['I_id_type_pro']);
                $idPro = $this->detailOrder_sign->getidPro($row['I_id_type_pro']);
                $idCmt = $this->detailOrder_sign->getidCmt($idPro,$row['I_id_type_pro'],$idUser);
                $resultTypePro = $this->detailOrder_sign->selectTypePro($row['I_id_type_pro']);
                $status = $this->detailOrder_sign->getStatus($idOrder);
                $comment = $this->detailOrder_sign->getComment($idCmt);
                $star = $this->detailOrder_sign->getStar($idCmt);
                $rowTypePro = mysqli_fetch_assoc($resultTypePro);
                if($status == 4){
                    $space = '<div class="col-3"></div>';
                    $btnReview = '
                    <div class="box-toggle-review col-2">
                        <button class="toggle-review" onclick="toggleReview('.strval($count).')">Đánh giá</button>
                    </div>';
                }else{
                    $space = '<div class="col-5"></div>';
                    $btnReview = '';
                }
                echo'
                    <div class="product">
                        <div class="product-info row">
                            <div class="col-1">
                                <img src="public/img/'.$rowTypePro['T_image_sample_type_pro'].'" alt="">
                            </div>
                            <div class="col-3">
                                <span>'.$namePro.'-'.$rowTypePro['T_name'].'</span>
                            </div>
                            '.$space.'
                            <div class="box-info col-3">
                                <p>Số lượng: '.$row['I_qty'].'</p>
                                <p>Giá: '.$row['I_price'].'</p>
                            </div>
                            '.$btnReview.'
                        </div>
                        <div class="review" id="review'.strval($count).'" data-iduser="'.$idUser.'" data-idpro="'.$idPro.'"
                        data-idtypepro="'.$row['I_id_type_pro'].'" data-idcmt="'.$idCmt.'">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span style="font-size: 2rem;">'.$star.'</span>
                            </div>
                            <textarea name="" id="" class="text-comment" placeholder="Nội dung đánh giá ...">'.$comment.'</textarea>
                            <input type="hidden" class="countStar" id="countStar'.$count.'" name="countStar" value="'.$star.'">
                            <button class="btn submitComment"><i class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </div>
                ';
                $count++;
            }
        }

        public function handleReview($sign,$star,$content,$idUser,$idsp,$idtsp,$idcmt){
            if($sign == "addComment"){
                $result = $this->detailOrder_sign->addReview($star,$content,$idUser,$idsp,$idtsp);
                $reviewed = $this->detailOrder_sign->addReviewed($idUser);
            }else if($sign == "updateComment"){
                $result = $this->detailOrder_sign->updateReview($star,$content,$idUser,$idsp,$idtsp,$idcmt);
            }
            if($result){
                echo "success";
            }
        }
    }
?>