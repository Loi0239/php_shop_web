<?php
    require_once '../controller/productController.php';
    require_once '../../database/connect.php';
    
    if(isset($_GET['sign'])) {
        $sign = $_GET['sign'];
    
        if($sign == 'line') {
            // Xử lý cho biểu đồ dường
            $controller = new ProductController($conn);
            $data = $controller->thongKeSpDaBan();
        } else {
            // Xử lý khi giá trị của sign không hợp lệ
            echo json_encode(array('error' => 'Invalid sign parameter'));
        }
    } else {
        // Xử lý khi không có tham số sign
        echo json_encode(array('error' => 'Missing sign parameter'));
    }
?>