<?php
    class PaymentModel{
        private $conn;

        public function __construct($conn) {
            $this->conn = $conn;
        }

        public function selectInfoUser($iduser){
            $sql = "SELECT * FROM users WHERE I_id_user = $iduser";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_assoc($result);
            return $row;
        }

        public function selectInfoPro($idsps,$idtsps,$counts){
            $idspsString = implode(",", $idsps);
            $idtspsString = implode(",", $idtsps);

            $sql = "SELECT * FROM product 
            JOIN product_type ON product.I_id_pro = product_type.I_id_pro
            WHERE product_type.I_id_pro IN ($idspsString) AND I_id_type_pro IN ($idtspsString)";
            $result = mysqli_query($this->conn, $sql);
            return $result;
        }

        public function insertOrder($iduser,$orderCode,$name,$numberPhone,
        $address,$email,$orderDate,$ship,$payment){
            $sql="INSERT INTO orders (I_id_user, T_code_orders, T_name_user, T_number_phone, T_address, T_email,
            T_order_date, T_method_ship, T_method_payment, I_status) 
            VALUES ($iduser, '$orderCode', '$name', '$numberPhone', '$address', '$email', '$orderDate',
            '$ship', '$payment', 0)";
            $result = mysqli_query($this->conn,$sql);
            return $this->conn->insert_id;
        }

        public function insertOrderDetail($resultOrder, $idtsps, $idsps, $counts){
            $idtspString = implode(',', $idtsps);
            $prices = [];
            $sql = "SELECT I_price FROM product_type WHERE I_id_type_pro IN ($idtspString)";
            $result = mysqli_query($this->conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $prices[] = $row['I_price'];
            }
            $check = true;
            $sqlInsert = "INSERT INTO order_detail (I_id_orders, I_id_type_pro, I_id_pro, I_qty, I_price) VALUES";

            for ($i = 0; $i < count($idtsps); $i++) {
                // Thêm dấu phẩy giữa các giá trị
                $sqlInsert .= "($resultOrder, $idtsps[$i], $idsps[$i], $counts[$i], $prices[$i]),";
                // Chạy truy vấn khi cần
                if ($i % 10 == 9 || $i == count($idtsps) - 1) {
                    // Loại bỏ dấu phẩy cuối cùng
                    $sqlInsert = rtrim($sqlInsert, ',');

                    // Thực hiện truy vấn
                    $resultInsert = mysqli_multi_query($this->conn, $sqlInsert);
                    if (!$resultInsert) {
                        $check = false;
                        break; // Thoát khỏi vòng lặp nếu có lỗi
                    }
                    // Reset chuỗi SQL cho lần lặp tiếp theo
                    $sqlInsert = "INSERT INTO order_detail (I_id_orders, I_id_type_pro, I_id_pro, I_qty, I_price) VALUES";
                }
            }
            return $check;
        }

        public function decreaseQty($idtsps,$counts){
            $idtspString = implode(',',$idtsps);
            $sql = "SELECT I_qty_in_stock FROM product_type WHERE I_id_type_pro IN ($idtspString)";
            $result = mysqli_query($this->conn,$sql);
            $i = 0;
            $new_qty = [];
            while($row=mysqli_fetch_assoc($result)){
                $new_qty[] = $row['I_qty_in_stock'] - intval($counts[$i],10);
            }
            for ($i = 0; $i < count($idtsps); $i++) {
                // Thêm dấu phẩy giữa các giá trị
                $sqlDecrease= "UPDATE product_type SET I_qty_in_stock = $new_qty[$i] WHERE I_id_type_pro = $idtsps[$i]";
                // Chạy truy vấn khi cần
                if ($i % 10 == 9 || $i == count($idtsps) - 1) {
                    // Loại bỏ dấu phẩy cuối cùng
                    $sqlDecrease = rtrim($sqlDecrease, ',');

                    // Thực hiện truy vấn
                    $resultDecrease = mysqli_multi_query($this->conn, $sqlDecrease);
                    if (!$resultDecrease) {
                        $check = false;
                        break; // Thoát khỏi vòng lặp nếu có lỗi
                    }
                }
            }
        }

        public function increaseQty($idsps,$counts){
            $idspString = implode(',',$idsps);
            $sql = "SELECT I_sold FROM product WHERE I_id_pro IN ($idspString)";
            $result = mysqli_query($this->conn,$sql);
            $i = 0;
            $new_qty = [];
            while($row=mysqli_fetch_assoc($result)){
                $new_qty[] = $row['I_sold'] + intval($counts[$i],10);
            }
            for ($i = 0; $i < count($idsps); $i++) {
                // Thêm dấu phẩy giữa các giá trị
                $sqlIncrease= "UPDATE product SET I_sold = $new_qty[$i] WHERE I_id_pro = $idsps[$i]";
                // Chạy truy vấn khi cần
                if ($i % 10 == 9 || $i == count($idsps) - 1) {
                    // Loại bỏ dấu phẩy cuối cùng
                    $sqlIncrease = rtrim($sqlIncrease, ',');

                    // Thực hiện truy vấn
                    $resultIncrease = mysqli_multi_query($this->conn, $sqlIncrease);
                    if (!$resultIncrease) {
                        $check = false;
                        break; // Thoát khỏi vòng lặp nếu có lỗi
                    }
                }
            }
        }

        public function getIdCart($iduser){
            $sql = "SELECT I_id_cart FROM cart WHERE I_id_user = $iduser";
            $result = mysqli_query($this->conn,$sql);
            $row = mysqli_fetch_assoc($result);
            return $row['I_id_cart'];
        }

        public function clearCart($idsps,$idtsps,$idCart){
            $idspString = implode(',',$idsps);
            $idtspString = implode(',',$idtsps);
            $sql = "DELETE FROM cart_pro WHERE I_id_cart = $idCart 
            AND I_id_pro IN ($idspString) AND I_id_type_pro IN ($idtspString)";
            $result = mysqli_query($this->conn,$sql);
            return $result;
        }
    }
?>