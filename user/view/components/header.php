<?php
   include("database/connect.php");
   include("user/controller/cartController.php");

   $cartController = new CartController($conn);
?>

<header class="header">
   <a href="../../../index.php?route=home" class="logo">
      <img src="../../../user/assets/img/logo.png" alt="LOGO">
   </a>

   <nav class="navbar">
      <a href="index.php">trang chủ</a>
      <a href="index.php?route=product">sản phẩm</a>
      <a href="index.php?route=about">về chúng tôi</a>
   </nav>

   <div class="icons">
      <form action="index.php" method="get">
         <input type="hidden" name="route" value="product">
         <input type="text" name="text-search" class="text-search" placeholder="search here">
         <button type="submit"></button>
      </form>
      <button class="btn-search"><a class="fas fa-search"></a></button>
      <?php
         if(isset($_SESSION['username'])){
            $cartController->selectCount($_SESSION['username']);
            echo "
            <a href='#' class='fas fa-user btn-user'></a>
            <ul class='dropdown-user'>
               <li><a href='index.php?route=infoUser'>
                  <i class='fas fa-user'></i>
                  Thông tin cá nhân
               </a></li>
               <li><a href='index.php?route=invoice'>
                  <i class='fas fa-user'></i>
                  Đơn hàng của bạn
               </a></li>
               <hr>
               <li><a href='/user/view/content/signout.php'>
                  <i class='fa-solid fa-right-from-bracket'></i>
                  Đăng xuất
               </a></li>
            </ul>
            ";
         }else{
            echo "
               <a href='user/view/content/signin.php' class='fas fa-shopping-cart' id='cart-btn'>
                  <span class='count_cart'>0</span>
               </a>
            ";
            echo "<a href='user/view/content/signin.php' class='btn-signin'>Sign in</a>";
         }
      ?>
   </div>
    <div id="menu-btn" class="fas fa-bars"></div>

</header>

<div class="clear-header"></div>