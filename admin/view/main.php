<?php
    session_start();
    include ('../../database/connect.php');
    include ('../controller/qlkhController.php');
    include ('../controller/categoryController.php');
    include ('../controller/productController.php');
    include ('../controller/orderController.php');

    if(isset($_SESSION['userName'])){
        $userName = $_GET('userName');
        $avata = "";
    }

    if($_GET){
        $_SESSION['ql'] = $_GET['ql'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản lý admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <header class="header">
        <h1>trang quản lý</h1>
    </header>

    <main>
        <div class="side_bar">
            <div class="user_name">
                <?php
                    if(empty($avata)){
                        echo '<img src="../assets/img/avata_default.png" alt="avata" class="avata">';
                    }else{
                        echo '<img src="'.$avata.'" alt="avata" class="avata">';
                    }
                ?>
                <p class="name">xin chào <br> <span>Admin</span></p>
            </div>
            <ul class="menu">
                <li><a href="main.php?ql=db" id="dashBoard">
                    <i class="icon fa-solid fa-gauge"></i>
                    DashBoard
                </a></li>
                <li><a href="main.php?ql=qltk" id="userAccount">
                    <i class="icon fa-solid fa-user"></i>
                    Tài khoản người dùng
                </a></li>
                <li><a href="main.php?ql=cate_pr" id="category">
                    <i class="icon fa-solid fa-bars-progress"></i>
                    Danh mục
                </a></li>
                <li class="li_sub_menu">
                    <a href="#" id="product" class="pro">
                        <i class="icon fa-brands fa-product-hunt"></i>
                        Sản phẩm
                    </a>
                    <ul class="sub_menu">
                        <li><a href="main.php?ql=pro" id="productWarehouse">
                            <i class="icon fa-solid fa-warehouse"></i>
                            Kho sản phẩm
                        </a></li>
                        <li><a href="main.php?ql=order" id="order">
                            <i class="icon fa-solid fa-file-lines"></i>
                            Đơn hàng
                        </a></li>
                    </ul>
                </li>
                <li><a href="#" id="signout">
                    <i class="icon fa-solid fa-arrow-right-from-bracket"></i>
                    Đăng xuất
                </a></li>
            </ul>
        </div>

        <div class="content">
            <?php
                include ('../controller/transitionController.php');
            ?>     
        </div>
    </main>

    <footer class="footer">

    </footer>

    <script src="../assets/script/main.js"></script>
</body>
</html>