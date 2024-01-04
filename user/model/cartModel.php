<?php
    class CartModel{
        private $conn; 

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectCount($username){
            $sql = "SELECT cp.* FROM cart_pro cp
            JOIN cart c ON cp.I_id_cart = c.I_id_cart
            JOIN users u ON c.I_id_user = u.I_id_user
            WHERE u.T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }


        public function selectData($idCart){
            $sql = "SELECT cart_pro.*, product_type.T_name,product_type.T_image_sample_type_pro,
            product_type.I_price,product.T_name_pro FROM cart_pro
            JOIN product_type ON cart_pro.I_id_type_pro = product_type.I_id_type_pro
            JOIN product ON cart_pro.I_id_pro = product.I_id_pro
            WHERE I_id_cart = $idCart ORDER BY cart_pro.I_id;";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function getIdCart($username){
            $sql = "SELECT c.I_id_cart FROM cart c
            JOIN users u ON c.I_id_user = u.I_id_user
            WHERE u.T_user_name = '$username'";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }  

        public function updateCart($idCart, $idsps, $counts, $sign, $idtsps,$count_keys){
            $idspsString = implode(",", $idsps);
            $countsString = implode(",", $counts);
            $idtspsString = implode(",", $idtsps);
        
            // Tạo câu truy vấn SQL để kiểm tra xem đã có dữ liệu với các I_id_pro, I_qty, I_id_type_pro trong danh sách chưa
            $checkIfExistsQuery = "SELECT I_id_pro, I_qty, I_id_type_pro FROM cart_pro 
            WHERE I_id_pro IN ($idspsString) AND I_id_cart = $idCart AND I_id_type_pro IN ($idtspsString)";
            $checkIfExistsResult = mysqli_query($this->conn, $checkIfExistsQuery);
            $existingData = [];

            // Lấy danh sách các I_id_pro và I_qty đã tồn tại trong bảng cart_pro
            while ($row = mysqli_fetch_assoc($checkIfExistsResult)) {
                $id_pro = $row['I_id_pro'];
                $id_type_pro = $row['I_id_type_pro'];

                $existingData[$id_pro][$id_type_pro] = [
                    'I_qty' => $row['I_qty']
                ];
            }

            $processedPairs = [];// Mảng để lưu trữ các cặp idsp-idtsp đã được xử lý
            foreach ($idsps as $index => $id) {
                $idtspSub = [];
                if($sign === "true"){
                    $select = "SELECT I_id_type_pro FROM product_type WHERE I_id_pro = $id";
                }else{
                    $select = "SELECT I_id_type_pro FROM cart_pro WHERE I_id_pro = $id AND I_id_cart = $idCart";
                }
                $resultSelect = mysqli_query($this->conn, $select);
                while($rowSelect = mysqli_fetch_assoc($resultSelect)){
                    $idtspSub[] = $rowSelect['I_id_type_pro'];
                }
                $countSubIndex = 0;
                foreach ($idtspSub as $subIndex => $idtsp) {
                    if($sign === "true"){
                        if($idtsp == $idtsps[0]){
                            // Tạo khóa để đại diện cho cặp idsp-idtsp
                            $pairKey = $id . '-' . $idtsp;
                            // Kiểm tra xem cặp idsp-idtsp đã được xử lý chưa
                            if (!in_array($pairKey, $processedPairs)) {
                                // Thêm cặp idsp-idtsp vào mảng đã xử lý
                                $count = $counts[$index * count($idtspSub) + $countSubIndex];
                                $processedPairs[] = $pairKey;
                                // Kiểm tra xem I_id_pro có tồn tại không
                                if (array_key_exists($id, $existingData)) {
                                    // Nếu tồn tại, kiểm tra xem I_id_type_pro có tồn tại không
                                    if (array_key_exists($idtsp, $existingData[$id])) {
                                        // Cập nhật bằng cách cộng dồn qty sẵn có với count
                                        $newQty = $sign === "true" ? $existingData[$id][$idtsp]['I_qty'] + $count : $count;
    
                                        // // Thực hiện lệnh UPDATE
                                        $updateQuery = "UPDATE cart_pro SET I_qty = $newQty WHERE I_id_pro = $id AND I_id_cart = $idCart AND I_id_type_pro = $idtsp";
                                        $updateResult = mysqli_query($this->conn, $updateQuery);
                        
                                        if (!$updateResult) {
                                            return false; // Xử lý lỗi nếu có
                                        }
                                    } else {
                                        // Nếu không tồn tại I_id_type_pro, thêm mới với giá trị qty bằng $count và idtsp
                                        $insertQuery = "INSERT INTO cart_pro (I_id_cart, I_id_pro, I_qty, I_id_type_pro) VALUES ($idCart, $id, $count, $idtsp)";
                                        $insertResult = mysqli_query($this->conn, $insertQuery);
                        
                                        if (!$insertResult) {
                                            return false; // Xử lý lỗi nếu có
                                        }
                                    }
                                } else {
                                    // Nếu không tồn tại I_id_pro, thêm mới với giá trị qty bằng $count và idtsp
                                    $insertQuery = "INSERT INTO cart_pro (I_id_cart, I_id_pro, I_qty, I_id_type_pro) VALUES ($idCart, $id, $count, $idtsp)";
                                    $insertResult = mysqli_query($this->conn, $insertQuery);
                        
                                    if (!$insertResult) {
                                        return false; // Xử lý lỗi nếu có
                                    }
                                }
                            }
                            $countSubIndex++;
                        }
                    }else{
                        // Tạo khóa để đại diện cho cặp idsp-idtsp
                        $pairKey = $id . '-' . $idtsp;
                        // Kiểm tra xem cặp idsp-idtsp đã được xử lý chưa
                        if (!in_array($pairKey, $processedPairs)) {
                            // Thêm cặp idsp-idtsp vào mảng đã xử lý
                            $count;
                            foreach($count_keys as $key => $value){
                                if($pairKey == $value){
                                    $count = $counts[$key];
                                    break;
                                }
                            }
                            // $count = $counts[$index * count($idtspSub) + $subIndex];
                            $processedPairs[] = $pairKey;
                            // Kiểm tra xem I_id_pro có tồn tại không
                            if (array_key_exists($id, $existingData)) {
                                // Nếu tồn tại, kiểm tra xem I_id_type_pro có tồn tại không
                                if (array_key_exists($idtsp, $existingData[$id])) {
                                    // Cập nhật bằng cách cộng dồn qty sẵn có với count
                                    $newQty = $sign === "true" ? $existingData[$id][$idtsp]['I_qty'] + $count : $count;

                                    // // Thực hiện lệnh UPDATE
                                    $updateQuery = "UPDATE cart_pro SET I_qty = $newQty WHERE I_id_pro = $id AND I_id_cart = $idCart AND I_id_type_pro = $idtsp";
                                    
                                    $updateResult = mysqli_query($this->conn, $updateQuery);

                                    if (!$updateResult) {
                                        return false; // Xử lý lỗi nếu có
                                    }
                                } else {
                                    // Nếu không tồn tại I_id_type_pro, thêm mới với giá trị qty bằng $count và idtsp
                                    $insertQuery = "INSERT INTO cart_pro (I_id_cart, I_id_pro, I_qty, I_id_type_pro) VALUES ($idCart, $id, $count, $idtsp)";
                                    $insertResult = mysqli_query($this->conn, $insertQuery);
                    
                                    if (!$insertResult) {
                                        return false; // Xử lý lỗi nếu có
                                    }
                                }
                            } else {
                                // Nếu không tồn tại I_id_pro, thêm mới với giá trị qty bằng $count và idtsp
                                $insertQuery = "INSERT INTO cart_pro (I_id_cart, I_id_pro, I_qty, I_id_type_pro) VALUES ($idCart, $id, $count, $idtsp)";
                                $insertResult = mysqli_query($this->conn, $insertQuery);
                    
                                if (!$insertResult) {
                                    return false; // Xử lý lỗi nếu có
                                }
                            }
                        }
                    }
                }
            }
            return true;
        }        
        
        
        public function deleteCart($idCart,$idsp,$idtsp){
            $sql = "DELETE FROM cart_pro WHERE I_id_cart = $idCart AND I_id_pro = $idsp AND I_id_type_pro = $idtsp";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }

        public function getIdUser($username){
            $sql = "SELECT I_id_user FROM users WHERE T_user_name = '$username'";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_array($result);
            return $row['I_id_user'];
        }

        public function getQty($idtsp){ 
            $sql = "SELECT I_qty_in_stock FROM product_type WHERE I_id_type_pro = $idtsp";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_qty_in_stock'];
        }
    }
?>