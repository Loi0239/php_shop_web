<?php
    include("database/connect.php");
    include("user/controller/infoUserController.php");

    $infoUserController = new InfoUserController($conn);

    $errorMessage = ''; // Khởi tạo biến thông báo lỗi
    if (isset($_POST['submit'])) {
        $name = $_POST["name"];
        $birthday = $_POST["birthday"];
        $gender = $_POST["sex"];
        $address = $_POST["address"];
        $province = $_POST["province"];
        $number = $_POST["number"];
        $email = $_POST["email"];
        $user_id = $_POST["user_id"];

        // Kiểm tra xem số điện thoại có đúng 10 chữ số không
        if (strlen($number) !== 10 || !is_numeric($number)) {
            $errorMessage .= "Số điện thoại không hợp lệ. Vui lòng nhập đúng 10 chữ số.<br>";
        }

        // Kiểm tra định dạng email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage .= "Địa chỉ email không hợp lệ. Vui lòng nhập đúng định dạng email.<br>";
        }

        // Nếu có lỗi, bạn có thể chuyển hướng trở lại trang form với thông báo lỗi
        if (empty($errorMessage)) {
            // Chuyển số điện thoại thành chuỗi
            $number = strval($number);

            // Kết hợp giá trị từ các select và input thành một giá trị address
            $address = "{$province} | {$address}";
            $infoUserController->updateData($name,$birthday,$gender,$address,$number,$email,$user_id);
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="user/assets/css/infoUser.css">
</head>

<body>
  <div class="container">
    <form action="index.php" method="post">
        <input type="hidden" name="route" value="infoUser">
        <?php
            $infoUserController->selectData($_SESSION['username'],$errorMessage);
        ?>

        <input type="submit" name="submit" value="Lưu thay đổi" class="submit-btn">
    </form>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="user/assets/script/infoUser.js"></script>
</body>

</html>