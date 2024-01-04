<?php
    include_once("user/model/productsModel.php");

    class ProductsController{
        private $products_sign;

        public function __construct($conn) {
            $this->products_sign = new ProductsModel($conn);
        }

        public function select_category(){
            $result = $this->products_sign->select_category();
            while($row = mysqli_fetch_array($result)){
                if(empty($row['I_id_parent'])){
                    $sub_result = $this->products_sign->select_sub_category($row['I_id_category']);
                    $sub_count_row = mysqli_num_rows($sub_result);
                    if($sub_count_row > 0){
                        echo'
                            <li>
                                <a class="parent_category">
                                    <img src="public/img/'.$row['T_img_sample_category'].'" alt="ảnh minh họa">
                                    '.$row['T_name_category'].'
                                </a>
                                <ul class="sub_category">
                        ';
                        while($sub_row = mysqli_fetch_array($sub_result)){
                            echo'
                                <li><a href="index.php?route=product&&iddm='.$sub_row['I_id_category'].'">
                                    '.$sub_row['T_name_category'].'
                                </a></li>
                            ';
                        }
                        echo'
                                </ul>
                            </li>
                        ';
                    }else{
                        echo'
                            <li>
                                <a class="parent_category" href="index.php?route=product&&iddm='.$row['I_id_category'].'">
                                    <img src="'.$row['T_img_sample_category'].'" alt="ảnh minh họa">
                                    '.$row['T_name_category'].'
                                </a>
                            </li>
                        ';
                    }
                }
            }
        }

        public function select_category_parent(){
            $result = $this->products_sign->select_category_parent();
            while($row = mysqli_fetch_array($result)){
                echo '
                    <a href="index.php?route=product&&iddm='.$row['I_id_category'].'" class="icons">
                        <img src="public/img/'.$row['T_img_sample_category'].'" alt="ảnh minh họa">
                        <div class="info">
                        <h3>'.$row['T_name_category'].'</h3>
                        </div>
                    </a>
                ';
            }
        }

        public function select($iddm,$start,$limit){
            if(!empty($iddm)){
                $check = $this->products_sign->select_sub_category($iddm);
                $count = 0;
                while($row = mysqli_fetch_array($check)){
                    $count++;
                }
            }else{
                $count = 0;
            }
            $result = $this->products_sign->select($iddm,$start,$limit,$count);
            while($row = mysqli_fetch_array($result)){
                $link_imgs = explode("|", $row['T_img_sample_pro']);
                echo '
                    <a href="index.php?route=detailProduct&&idsp='.$row['I_id_pro'].'" class="col-lg-3 col-md-4 col-6 item">
                        <img class="image_pro" src="public/img/'.$link_imgs[0].'" alt="ảnh sản phẩm">
                        <h3 class="name-product">'.$row['T_name_pro'].'</h3>
                        <div class="review-sold">
                            <div class="review">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                            </div>
                            <div class="sold">'.$row['I_sold'].' sold</div>
                        </div>
                    </a>';
            }
            return false;
        }
        
        public function searchSelect($text,$start,$limit){
            $result = $this->products_sign->searchSelect($text,$start,$limit);
            while($row = mysqli_fetch_array($result)){
                $link_imgs = explode("|", $row['T_img_sample_pro']);
                echo '
                    <a href="index.php?route=detailProduct&&idsp='.$row['I_id_pro'].'" class="col-lg-3 col-md-4 col-6 item">
                        <img class="image_pro" src="public/img/'.$link_imgs[0].'" alt="ảnh sản phẩm">
                        <h3 class="name-product">'.$row['T_name_pro'].'</h3>
                        <div class="review-sold">
                            <div class="review">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                                <img src="user/assets/img/star.png" alt="">
                            </div>
                            <div class="sold">'.$row['I_sold'].' sold</div>
                        </div>
                    </a>';
            }
            return false;
        }

        public function newSelect(){
            $result = $this->products_sign->newSelect();
            while($row = mysqli_fetch_array($result)){
                $link_imgs = explode("|", $row['T_img_sample_pro']);
                echo ' 
                    <a href="index.php?route=detailProduct&&idsp='.$row['I_id_pro'].'" class="box">
                        <img src="public/img/'.$link_imgs[0].'" alt="PRODUCT">
                        <h3>'.$row['T_name_pro'].'</h3>
                        <div class="sold">'.$row['I_sold'].' sold</div>
                    </a>';
            }
        }

        public function addCart($idsp,$username){
            $idUser = $this->products_sign->getId_user($username);
            $idCart = $this->products_sign->getId_cart($idUser);
            $result = $this->products_sign->addCart($idCart,$idsp);
            if($result){
                return $msg = "success_cart";
            }else{
                return $msg = "fail_cart";
            }
        }

        public function getTotal_records($iddm){
            $result = $this->products_sign->getTotal_records($iddm);
            return $result;
        }

        public function getSearch_total_records($text){
            $result = $this->products_sign->getSearch_total_records($text);
            return $result;
        }

        public function pagination($iddm,$page,$total_pages){
            if(empty($iddm)){
                $str = "";
            }else{
                $str ='&&iddm='.$iddm;
            }
                
            // nếu p > 1 và total_page > 1 mới hiển thị nút prev
            if ($page > 1 && $total_pages > 1){
            echo '<a href="index.php?route=product&page='.($page-1).$str.'">Prev</a>';
            }
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_pages; $i++){
            // Nếu là trang hiện tại thì hiển thị thẻ span
            // ngược lại hiển thị thẻ a
            if ($i == $page){
            echo '<span>'.$i.'</span>';
            }
            else{
            echo '<a href="index.php?route=product&page='.$i.$str.'">'.$i.'</a>';
            }
            }
            // nếu p < $total_pages và total_pages > 1 mới hiển thị nút prev
            if ($page < $total_pages && $total_pages > 1){
            echo '<a href="index.php?route=product&page='.($page+1).$str.'">Next</a>';
            }
        }

        public function searchPagination($text,$page,$total_pages){                
            // nếu p > 1 và total_page > 1 mới hiển thị nút prev
            if ($page > 1 && $total_pages > 1){
            echo '<a href="index.php?route=product&text-search='.$text.'&page='.($page-1).'">Prev</a>';
            }
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_pages; $i++){
            // Nếu là trang hiện tại thì hiển thị thẻ span
            // ngược lại hiển thị thẻ a
            if ($i == $page){
            echo '<span>'.$i.'</span>';
            }
            else{
            echo '<a href="index.php?route=product&text-search='.$text.'&page='.$i.'">'.$i.'</a>';
            }
            }
            // nếu p < $total_pages và total_pages > 1 mới hiển thị nút prev
            if ($page < $total_pages && $total_pages > 1){
            echo '<a href="index.php?route=product&text-search='.$text.'&page='.($page+1).'">Next</a>';
            }
        }
    }
?>