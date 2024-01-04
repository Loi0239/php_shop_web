<?php
    include_once("user/model/detailProductModel.php");

    class DetailProductController{
        private $detailProduct_sign;

        public function __construct($conn) {
            $this->detailProduct_sign = new DetailProductModel($conn);
        }

        public function select($idsp, $idType){
            $result = $this->detailProduct_sign->select($idsp);
            $result_detail1 = $this->detailProduct_sign->select_detail($idsp);
            $result_detail2 = $this->detailProduct_sign->select_detail($idsp);
            $resultStar = $this->detailProduct_sign->get_total_review($idsp);
            $resultTypes = $this->detailProduct_sign->select_types($idsp);
            $resultType = $this->detailProduct_sign->select_type($idsp,$idType);
            if(isset($_SESSION['username'])){
                $idUser = $this->detailProduct_sign->getID_user($_SESSION['username']);
            }else{
                $idUser = -1;
            }
            $row = mysqli_fetch_array($result);
            $row_type = mysqli_fetch_array($resultType);
            $link_imgs = explode("|", $row['T_img_sample_pro']);
            $link_imgs_length = count($link_imgs);
            $features = explode("|", $row['T_feature']);
            $total_star = 0;
            $count = 0;
            while($rowStar = mysqli_fetch_array($resultStar)){
                $count ++;
                $total_star += $rowStar['I_star'];
            }
            if($count === 0){
                $avarage_star = 0;
            }else{
                $avarage_star = round($total_star/$count, 1);
            }
            echo '
                <div class="column column1 col-3">
                    <div class="slider-container">
                    <div class="main-image"><img src="public/img/'.$link_imgs[0].'" alt="Product Image"></div>
                    <div class="slider-thumbnails">
            ';
            for($i=0; $i<$link_imgs_length; $i++){
                echo '<div class="thumbnail"><img src="public/img/'.$link_imgs[$i].'" alt="Thumbnail"></div>';
            }
            echo'
                    </div>
                    </div>
            ';
            if(!empty($features[0])){
                echo'
                    <div class="features">
                    <h2>Đặc điểm nổi bật</h2>
                ';
                foreach($features as $feature){
                    echo'
                        <div class="row">
                            <p>
                            <i class="fa-solid fa-circle-check"></i>
                            '.$feature.'
                            </p>
                        </div>   
                    ';
                }
                echo'</div>';
            }
            echo'
                </div>
                <div class="column column2 col-5">
                    <div class="info">
                        <h4><i class="fa-solid fa-circle-check"></i>Chính hãng</h4>
            ';
            while($row_detail = mysqli_fetch_array($result_detail1)){
                if(!strcmp($row_detail['T_name'],"Thương hiệu")){
                    echo '<p>Thương hiệu: '.$row_detail['T_value'].'</p>';
                    break;
                }
            }
            echo'
                    </div>
                    <h1>'.$row['T_name_pro'].'</h1>
                    <div class="rate">
                        '.$avarage_star.'
            ';
            while($avarage_star > 0){
                if($avarage_star >= 0.5){
                    echo '<i class="fa fa-star "></i>';
                }else{
                    echo '<i class="fa fa-star-half-alt "></i>';
                }
                $avarage_star -= 1;
            }
            echo '
                        <span>('.$count.') | Đã bán '.$row['I_sold'].'</span>
                    </div>
                    <div class="price">
                        <h1>'.$row_type['I_price'].'</h1><span>-21%</span>
                    </div>
                    <div class="type">
                        <h5>Phân loại</h5>
                        <div class="box-type">
            ';
            while($row_types = mysqli_fetch_array($resultTypes)){
                if($row_types['I_id_type_pro'] === $idType){
                    echo'
                        <a href="index.php?route=detailProduct&idsp='.$idsp.'&idType='.$row_types['I_id_type_pro'].'" class="sub-box-type">
                            <img class="img-select selected" src="user/assets/img/select_success.png" alt="">
                            <img class="img-sample" src="public/img/'.$row_types['T_image_sample_type_pro'].'" alt="">
                            <h3 class="name-type">'.$row_types['T_name'].'</h3>
                            <div class="border-type selected"></div>
                        </a>
                    ';
                }else{
                    echo'
                        <a href="index.php?route=detailProduct&idsp='.$idsp.'&idType='.$row_types['I_id_type_pro'].'" class="sub-box-type">
                            <img class="img-select" src="user/assets/img/select_success.png" alt="">
                            <img class="img-sample" src="public/img/'.$row_types['T_image_sample_type_pro'].'" alt="">
                            <h3 class="name-type">'.$row_types['T_name'].'</h3>
                            <div class="border-type"></div>
                        </a>
                    ';
                }
            }
            echo'
                        </div>
                    </div>
                    <div class="details">
                        <h2>Thông tin chi tiết</h2>
            '; 
            while($row_detail = mysqli_fetch_array($result_detail2)){
                echo '
                    <div class="row">
                        <span>'.$row_detail['T_name'].'</span>
                        <div>'.$row_detail['T_value'].'</div>
                    </div>
                ';
            }
            echo'
                    </div>
                    <div class="description cutoff-text">
                        <h2>Mô tả sản phẩm</h2>
                        <div class="box">
                        <h2>Nội dung quảng cáo</h2>
                        <p>iPhone 14 Pro Max. Bắt trọn chi tiết ấn tượng với Camera Chính 48MP. Trải nghiệm iPhone theo cách hoàn toàn mới với Dynamic Island và màn hình Luôn Bật. Công nghệ an toàn quan trọng – Phát Hiện Va Chạm1 thay bạn gọi trợ giúp khi cần kíp</p>
                        </div>

                        <div class="box">
                        <h2>Tính năng nổi bật</h2>
                        <ul>
                            <li>Màn hình Super Retina XDR 6,7 inch2 với tính năng Luôn Bật và ProMotion</li>
                            <li>Dynamic Island, một cách mới tuyệt diệu để tương tác với iPhone</li>
                            <li>Camera Chính 48MP cho độ phân giải gấp 4 lần</li>
                            <li>Chế độ Điện Ảnh nay đã hỗ trợ 4K Dolby Vision tốc độ lên đến 30 fps</li>
                            <li>Chế độ Hành Động để quay video cầm tay mượt mà, ổn định</li>
                            <li>Công nghệ an toàn quan trọng – Phát Hiện Va Chạm1 thay bạn gọi trợ giúp khi cần kíp</li>
                        </ul>
                        </div>

                        <div class="box">
                        <h2>Pháp lý</h2>
                        <p>1SOS Khẩn Cấp sử dụng kết nối mạng di động hoặc Cuộc Gọi Wi-Fi.
                            2Màn hình có các góc bo tròn. Khi tính theo hình chữ nhật, kích thước màn hình theo đường chéo là 6,69 inch. Diện tích hiển thị thực tế nhỏ hơn.
                            3Thời lượng pin khác nhau tùy theo cách sử dụng và cấu hình; truy cập apple.com/batteries để biết thêm thông tin.
                            4Cần có gói cước dữ liệu. Mạng 5G chỉ khả dụng ở một số thị trường và được cung cấp qua một số nhà mạng. Tốc độ có thể thay đổi tùy địa điểm và nhà mạng. Để biết thông tin về hỗ trợ mạng 5G, vui lòng liên hệ nhà mạng và truy cập apple.com/iphone/cellular.
                            5iPhone 14 Pro Max có khả năng chống tia nước, chống nước và chống bụi. Sản phẩm đã qua kiểm nghiệm trong điều kiện phòng thí nghiệm có kiểm soát đạt mức IP68 theo tiêu chuẩn IEC 60529 (chống nước ở độ sâu tối đa 6 mét trong vòng tối đa 30 phút). Khả năng chống tia nước, chống nước và chống bụi không phải là các điều kiện vĩnh viễn. Khả năng này có thể giảm do hao mòn thông thường. Không sạc pin khi iPhone đang bị ướt. Vui lòng tham khảo hướng dẫn sử dụng để biết cách lau sạch và làm khô máy. Không bảo hành sản phẩm bị hỏng do thấm chất lỏng.
                            6Một số tính năng không khả dụng tại một số quốc gia hoặc khu vực.</p>
                        </div>

                        <div class="box">
                        <h2>Thông số kỹ thuật</h2>
                        <p>Truy cập <a href="apple.com/iphone/compare">apple.com/iphone/compare</a> <br> <br>
                            Giá sản phẩm trên Tiki đã bao gồm thuế theo luật hiện hành. Bên cạnh đó, tuỳ vào loại sản phẩm, hình thức và địa chỉ giao hàng mà có thể phát sinh thêm chi phí khác như phí vận chuyển, phụ phí hàng cồng kềnh, thuế nhập khẩu (đối với đơn hàng giao từ nước ngoài có giá trị trên 1 triệu đồng).....</p>
                        </div>
                    </div>
                    <input type="checkbox" class="expand-btn">
                </div>
                <div class="column column3 col-3">
                    <div class="heading">
                        <img src="public/img/'.$row_type['T_image_sample_type_pro'].'" alt="">
                        <h2>'.$row_type['T_name'].'</h2>
                    </div>
                    <form action="index.php" method="get" class="box">
                        <input type="hidden" name="route" value="cart">
                        <input type="hidden" name="idsp" value="'.$row['I_id_pro'].'">
                        <input type="hidden" name="signDetail" value="true">
                        <input type="hidden" name="idtsp" value="'.$row_type['I_id_type_pro'].'">
                        <h2>Số lượng</h2>
                        <div class="counter">
                        <button type="button" class="decrement">-</button>
                        <input type="input" name="count" class="count" required value="1" min="1" max="'.$row_type['I_qty_in_stock'].'">
                        <button type="button" class="increment">+</button>
                        <span>'.$row_type['I_qty_in_stock'].' sản phẩm có sẵn</span>
                        </div>
                        <p class="sub-total">Tổng tiền : <span>'.$row_type['I_price'].'<i class="fa-solid fa-dong-sign"></i></span></p>
                        <a href="#" class="btn_buy" data-idsp="'.$idsp.'" data-idtsp="'.$row_type['I_id_type_pro'].'" 
                        data-iduser="'.$idUser.'"><i class="fa-solid fa-receipt"></i> Mua ngay</a>
                        <button type="submit" class="btn_add_cart"><i class="fas fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
                    </form>    
                </div>
            ';
        }

        public function selectReview($idsp){
            $result = $this->detailProduct_sign->get_total_review($idsp);
            $total_star = 0;
            $count = 0;
            $count1s = 0;
            $count2s = 0;
            $count3s = 0;
            $count4s = 0;
            $count5s = 0;
            while($row = mysqli_fetch_array($result)){
                $count ++;
                $total_star += $row['I_star'];
                switch ($row['I_star']) {
                    case '1':
                        $count1s ++;
                        break;
                    case '2':
                        $count2s ++;
                        break;
                    case '3':
                        $count3s ++;
                        break;
                    case '4':
                        $count4s ++;
                        break;
                    case '5':
                        $count5s ++;
                        break;
                }
            }
            if($count === 0){
                $avarage_star = 0;
            }else{
                $avarage_star = round($total_star/$count, 1);
            }
            echo '
                <h1>Khách hàng đánh giá</h1>
                <div class="box">
                <div class="overview">
                    <h2>Tổng quan</h2>
                    <div class="stars-container">
                    <span class="heading">'.$avarage_star.'</span>
            ';
            while($avarage_star > 0){
                if($avarage_star >= 0.5){
                    echo '<span class="fa fa-star "></span>';
                }else{
                    echo '<span class="fa fa-star-half-alt "></span>';
                }
                $avarage_star -= 1;
            }
            echo'
                    </div>
                    <p style="padding-top: .8rem; font-size: 1.6rem; color: #aaa;">(<span id="total-star">'.$count.'</span> đánh giá)</p>
                    <hr style="border:3px solid #f1f1f1; margin: .8rem 0">
                    <div class="row">
                    <div class="side">
                        <div>5 star</div>
                        </div>
                        <div class="middle">
                        <div class="bar-container">
                            <div class="bar-5 progress-bar"></div>
                        </div>
                        </div>
                        <div class="side right">
                        <div class="star-counter">'.$count5s.'</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="side">
                        <div>4 star</div>
                        </div>
                        <div class="middle">
                        <div class="bar-container">
                            <div class="bar-4 progress-bar"></div>
                        </div>
                        </div>
                        <div class="side right">
                        <div class="star-counter">'.$count4s.'</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="side">
                        <div>3 star</div>
                        </div>
                        <div class="middle">
                        <div class="bar-container">
                            <div class="bar-3 progress-bar"></div>
                        </div>
                        </div>
                        <div class="side right">
                        <div class="star-counter">'.$count3s.'</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="side">
                        <div>2 star</div>
                        </div>
                        <div class="middle">
                        <div class="bar-container">
                            <div class="bar-2 progress-bar"></div>
                        </div>
                        </div>
                        <div class="side right">
                        <div class="star-counter">'.$count2s.'</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="side">
                        <div>1 star</div>
                        </div>
                        <div class="middle">
                        <div class="bar-container">
                            <div class="bar-1 progress-bar"></div>
                        </div>
                        </div>
                        <div class="side right">
                        <div class="star-counter">'.$count1s.'</div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }

        public function selectComment($idsp,$start,$limit){
            $result = $this->detailProduct_sign->select_review_parent($idsp,$start,$limit);
            while($row=mysqli_fetch_array($result)){
                $star = $row['I_star'];
                //xử lý user
                $resultUser = $this->detailProduct_sign->selectUser($row['I_id_user']);
                $rowUser=mysqli_fetch_array($resultUser);
                $words = explode(" ", $rowUser['T_name']);
                $wordCount = count($words);
                $resultWord = '';
                // Xử lý nếu tên chỉ có một chữ
                if ($wordCount == 1) {
                    $resultWord = strtoupper(substr($words[0], 0, 1));
                } else {
                    // Tên có nhiều hơn một chữ
                    $resultWord .= strtoupper(substr($words[$wordCount - 2], 0, 1));
                    $resultWord .= strtoupper(substr($words[$wordCount - 1], 0, 1));
                }
                echo '
                    <hr style="border:3px solid #f1f1f1; margin: 2rem 0">
                    <div class="box">
                        <div class="user">
                            <div class="heading">
                            <div class="logo">'.$resultWord.'</div>
                            <div class="name">
                                <h1>'.$rowUser['T_name'].'</h1>
                            </div>
                            </div>
                            <div class="tus">
                            <div class="title">
                                <i class="fa-solid fa-paperclip"></i>
                                Đã viết
                            </div>
                            <p>'.$rowUser['I_reviewed'].' đánh giá</p>
                            </div>
                            <hr style="border:2px solid #f1f1f1; margin: .5rem 0">
                            <div class="like">
                            <div class="title">
                                <i class="fa-regular fa-thumbs-up"></i>
                                Đã nhận
                            </div>
                            <p><span class="total-likes">'.$rowUser['I_likes'].'</span> Lượt cảm ơn</p>
                            </div>
                        </div>
                
                        <div class="react">
                            <div class="heading">
                ';
                while($star > 0){
                    echo '<i class="fa fa-star "></i>';
                    $star --;
                }
                echo '
                            </div>
                            <h4><i class="fa-solid fa-circle-check"></i> Đã mua hàng</h4>
                            <p>'.$row['T_comment'].'</p>
                ';
                //xử lí ảnh
                $link_imgs = explode("|", $row['T_img_sample_review']);
                $link_imgs_length = count($link_imgs);
                if($link_imgs_length > 1){
                    echo '<div class="img-container">';
                    for($i=0; $i<$link_imgs_length; $i++){
                        echo '<img src="'.$link_imgs[$i].'" alt="">';
                    }
                    echo '</div>';
                }
                if(isset($_SESSION['username'])){
                    $idUser = $this->detailProduct_sign->getID_user($_SESSION['username']);
                }else{
                    $idUser = -1;
                }
                $result_check_review = $this->detailProduct_sign->check_review($idUser,$row['I_id'],$idsp);
                if($result_check_review != 0){
                    $result_sub_review = $this->detailProduct_sign->select_sub_review($idsp,$row['I_id'],$result_check_review);
                }else{
                    $result_sub_review = $this->detailProduct_sign->select_sub_review_full($idsp,$row['I_id']);
                }
                $total_num_rows = mysqli_num_rows($result_sub_review);
                $total_rows_sub_one = $total_num_rows - 1;
                $total_sub_comment = "bình luận";
                if($total_num_rows > 0){
                    $total_sub_comment = $total_num_rows;
                }
                $resultLikes = $this->detailProduct_sign->selectLike($row['I_id']);
                $resultCheckLikes = $this->detailProduct_sign->checkLike($row['I_id'],$idUser);
                $nameType = $this->detailProduct_sign->getNameTypePro($row['I_id']);
                $rowLikes = mysqli_fetch_assoc($resultLikes);
                $rowCheckLikes = mysqli_fetch_assoc($resultCheckLikes);
                if($rowCheckLikes['like_count'] > 0){
                    $color = "blue";
                }else{
                    $color = "none";
                }
                $username = "";
                    if(isset($_SESSION['username'])){
                        $username = $_SESSION['username'];
                    }
                echo '
                            <span class="types">
                            loại: '.$nameType.'
                            </span> <br>
                            <div class="contact">
                            <p>
                                <span class="likes" data-idcmt="'.$row['I_id'].'" data-iduser="'.$idUser.'" data-idsp="'.$idsp.'" data-iduserofcmt="'.$rowUser['I_id_user'].'">
                                    <i class="icon fa-regular fa-thumbs-up" style="color:'.$color.'"></i> 
                                    <span class="like-count">'.$rowLikes['like_count'].'</span>
                                </span> 
                                <span class="comments" data-idcmt="'.$row['I_id'].'" data-iduser="'.$idUser.'" data-idsp="'.$idsp.'" data-idsub="'.$result_check_review.'">
                                    <i class="icon fa-regular fa-comment fa-flip-horizontal"></i>'.$total_sub_comment.'
                                </span>
                            </p>
                        </div>  
                ';
                if($result_check_review != 0){
                    $result_select_one = $this->detailProduct_sign->select_one_sub_review($result_check_review,$idsp);
                    $row_one_sub = mysqli_fetch_array($result_select_one);
                    $result_sub_user = $this->detailProduct_sign->selectUser($row_one_sub['I_id_user']);
                    $row_sub_user=mysqli_fetch_array($result_sub_user);
                    $words = explode(" ", $row_sub_user['T_name']);
                    $wordCount = count($words);
                    $resultWord = '';
                    // Xử lý nếu tên chỉ có một chữ
                    if ($wordCount == 1) {
                        $resultWord = strtoupper(substr($words[0], 0, 1));
                    } else {
                        // Tên có nhiều hơn một chữ
                        $resultWord .= strtoupper(substr($words[$wordCount - 2], 0, 1));
                        $resultWord .= strtoupper(substr($words[$wordCount - 1], 0, 1));
                    }
                    echo'
                        <div class="comment-box">
                            <div class="sub-react ">
                                <div class="heading">
                                    <div class="logo">'.$resultWord.'</div>
                                    <h4>'.$row_sub_user['T_name'].'</h4>
                                </div>
                                <input type="hidden" id="username" name="username" value="'.$row_sub_user['T_name'].'">
                                <textarea name="comment" class="text-comment" value="'.$row_one_sub['T_comment'].'" required rows="10"></textarea>
                                <button type="submit" class="btn-submit"><i class="icon-submit fa-solid fa-paper-plane"></i></button>
                            </div>
                        </div>
                        <div class="total-sub-react">   
                    ';
                }else{
                    echo'
                    <div class="comment-box">
                        <input type="hidden" id="username" name="username" value="'.$rowUser['T_name'].'">
                        <textarea name="comment" class="text-comment" placeholder="Nhập bình luận của bạn" required rows="10"></textarea>
                        <button type="submit" class="btn-submit"><i class="icon-submit fa-solid fa-paper-plane"></i></button>
                    </div>
                    <div class="total-sub-react">   
                    ';
                }
                while($row_sub = mysqli_fetch_array($result_sub_review)){
                    $result_sub_user = $this->detailProduct_sign->selectUser($row_sub['I_id_user']);
                    $row_sub_user=mysqli_fetch_array($result_sub_user);
                    $words = explode(" ", $row_sub_user['T_name']);
                    $wordCount = count($words);
                    $resultWord = '';
                    // Xử lý nếu tên chỉ có một chữ
                    if ($wordCount == 1) {
                        $resultWord = strtoupper(substr($words[0], 0, 1));
                    } else {
                        // Tên có nhiều hơn một chữ
                        $resultWord .= strtoupper(substr($words[$wordCount - 2], 0, 1));
                        $resultWord .= strtoupper(substr($words[$wordCount - 1], 0, 1));
                    }
                    echo'
                                <div class="sub-react ">
                                    <div class="heading">
                                        <div class="logo">'.$resultWord.'</div>
                                        <h4>'.$row_sub_user['T_name'].'</h4>
                                    </div>
                                    <p>'.$row_sub['T_comment'].'</p>
                                </div>
                    ';
                }
                echo'       </div>';
                if($total_rows_sub_one > 0 ){
                    echo'
                        <h3 class="total-comment"><i class="fa-solid fa-arrow-right-to-bracket"></i> Xem thêm '.$total_rows_sub_one.' câu trả lời</h3>
                    ';
                }
                echo'
                        </div>
                    </div>
                ';
            }
        }

        public function pageNumber($idsp,$page,$total_pages){
            // nếu p > 1 và total_page > 1 mới hiển thị nút prev
            if ($page > 1 && $total_pages > 1){
            echo '<span class="prev" data-idsp="'.$idsp.'" data-page="'.($page-1).'"><< Prev</span>';
            }
            // Lặp khoảng giữa
            for ($i = 1; $i <= $total_pages; $i++){
            // Nếu là trang hiện tại thì hiển thị thẻ span
            // ngược lại hiển thị thẻ a
            if ($i == $page){
            echo '<span class="page">'.$i.'</span>';
            }
            else{
            echo '<span class="pages" data-idsp="'.$idsp.'" data-page="'.$i.'">'.$i.'</span>';
            }
            }
            // nếu p < $total_pages và total_pages > 1 mới hiển thị nút prev
            if ($page < $total_pages && $total_pages > 1){
            echo '<span class="next" data-idsp="'.$idsp.'" data-page="'.($page+1).'" href="index.php?route=detailProduct&idsp='.$idsp.'&page='.($page+1).'">Next >></span>';
            }
        }

        public function getIdType($idsp){
            $result = $this->detailProduct_sign->select_fist_type($idsp);
            $row = mysqli_fetch_array($result);
            return $row['I_id_type_pro'];
        }

        public function checkLike($idcmt,$idUser,$idUserOfCmt){
            $result = $this->detailProduct_sign->checkLike($idcmt,$idUser);
            $row = mysqli_fetch_assoc($result);
            if($row['like_count'] == 0){
                $insert = $this->detailProduct_sign->insertLike($idcmt,$idUser);
                if($insert){
                    $update = $this->detailProduct_sign->updateLikeOfUser($idUserOfCmt,"add");
                    return "thêm thành công";
                }
            }else{
                $delete = $this->detailProduct_sign->deleteLike($idcmt,$idUser);
                if($delete){
                    $update = $this->detailProduct_sign->updateLikeOfUser($idUserOfCmt,"sub");
                    return "xóa thành công";
                }
            }
        }

        public function checkComment($idcmt, $idUser, $idsp){
            $result = $this->detailProduct_sign->checkComment($idcmt,$idUser);
            $row = mysqli_fetch_assoc($result);
            if($row['like_count'] == 0){
                
            }else{
                echo "đã có comment";
            }
        }

        public function addComment($idcmt, $idUser, $idsp, $content){
            $result = $this->detailProduct_sign->addComment($idcmt,$idUser,$idsp,$content);
            if($result){
                return "thành công";
            }else{
                return "thất bại";
            }
        }

        public function updateComment($idcmt, $idUser, $idsp, $content){
            $result = $this->detailProduct_sign->updateComment($idcmt,$idUser,$idsp,$content);
            if($result){
                return "thành công";
            }else{
                return "thất bại";
            }
        }

        public function getTotalPage($idsp){
            $result_total_page = $this->detailProduct_sign->get_total_review($idsp);
            $total_page = mysqli_num_rows($result_total_page);
            return $total_page;
        }
    }
?>