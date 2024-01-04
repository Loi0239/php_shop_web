<?php
    class DetailProductModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        //xử lý sản phẩm
        public function select($idsp){
            $sql = "SELECT * FROM product WHERE I_id_pro = $idsp";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        //xử lý review
        public function check_review($idUser,$idcmt,$idsp){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp AND I_id_comment_parent = $idcmt ORDER BY I_id DESC";
            $result = mysqli_query($this->conn, $sql);
            while($row=mysqli_fetch_array($result)){
                if($row['I_id_user']==$idUser){
                    return $row['I_id'];
                }
            }
            return 0;
        }

        public function select_review_parent($idsp,$start,$limit){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp 
            AND I_id_comment_parent IS NULL ORDER BY I_id DESC LIMIT $start,$limit";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }
        
        public function get_total_review($idsp){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp 
            AND I_id_comment_parent IS NULL";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select_sub_review($idsp,$idcmt,$idcmtSub){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp AND I_id_comment_parent = $idcmt 
            ORDER BY 
                CASE 
                    WHEN I_id = $idcmtSub THEN 0 
                    ELSE 1 
                END, 
                I_id DESC";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select_sub_review_full($idsp,$idcmt){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp AND I_id_comment_parent = $idcmt ORDER BY I_id DESC";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function select_one_sub_review($idcmt,$idsp){
            $sql = "SELECT * FROM review WHERE I_id_pro = $idsp AND I_id = $idcmt";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function checkComment($idcmt,$idUser){
            $sql = "SELECT COUNT(*) AS reply_count FROM review
            WHERE I_id_comment_parent = $idcmt AND I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function addComment($idcmt,$idUser,$idsp,$content){
            $sql = "INSERT INTO review (T_comment,I_id_comment_parent,I_id_pro,I_id_user) 
            VALUES ('$content',$idcmt,$idsp,$idUser)";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function updateComment($idcmt,$idUser,$idsp,$content){
            $sql = "UPDATE review SET T_comment = '$content' WHERE I_id_pro = $idsp AND I_id = $idcmt AND I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        //Xử lý user
        public function selectUser($idUser){
            $sql = "SELECT * FROM users WHERE I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function getID_user($username){
            $sql = "SELECT I_id_user FROM users WHERE T_user_name = '$username'";
            $row = mysqli_fetch_assoc(mysqli_query($this->conn,$sql));
            $idUser = $row['I_id_user'];
            return strval($idUser);
        }

        public function updateLikeOfUser($idUser,$sign){
            $select = "SELECT I_likes FROM users WHERE I_id_user = $idUser";
            $result = mysqli_query($this->conn,$select);
            $row = mysqli_fetch_assoc($result);
            $value = intval($row['I_likes']);
            if($sign === "add"){
                $value++;
            }else{
                $value--;
            }
            $sql = "UPDATE users SET I_likes = $value WHERE I_id_user = $idUser";
            $resultUpdate = mysqli_query($this->conn,$sql);
            return $resultUpdate;
        }

        //xử lý chi tiết/phân loại sản phẩm
        public function select_detail($idsp){
            $sql = "SELECT * FROM product_details WHERE I_id_pro = $idsp";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function select_types($idsp){
            $sql = "SELECT * FROM product_type WHERE I_id_pro = $idsp";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function select_type($idsp,$idType){
            $sql = "SELECT * FROM product_type WHERE I_id_pro = $idsp AND I_id_type_pro = $idType";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function select_fist_type($idsp){
            $sql = "SELECT * FROM product_type WHERE I_id_pro = $idsp LIMIT 1";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }


        public function getNameTypePro($idcmt){
            $sql = "SELECT T_name FROM product_type 
            JOIN review ON review.I_id_type_pro = product_type.I_id_type_pro
            WHERE review.I_id = $idcmt";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row['T_name'];
        }
        // xử lý likes
        public function insertLike($idcmt,$idUser){
            $sql = "INSERT INTO Likes (I_id_review, I_id_user) VALUES ($idcmt, $idUser)";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function deleteLike($idcmt,$idUser){
            $sql = "DELETE FROM Likes WHERE I_id_review = $idcmt AND I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function checkLike($idcmt,$idUser){
            $sql = "SELECT COUNT(*) AS like_count FROM Likes WHERE I_id_review = $idcmt AND I_id_user = $idUser";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function selectLike($idcmt){
            $sql = "SELECT COUNT(*) AS like_count FROM Likes WHERE I_id_review = $idcmt";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }
    }
?>