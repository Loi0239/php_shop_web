<?php
   include("database/connect.php");
   include("user/controller/cartController.php");

   $cartController = new CartController($conn);
?>

<header class="header">
   <a href="../../../index.php?route=home" class="logo">
      <img src="https://cdn.logo.com/hotlink-ok/logo-social.png" alt="LOGO">
   </a>

   <nav class="navbar">
      <a href="">home</a>
      <a href="index.php?route=detailProduct">about</a>
      <a href="">menu</a>
      <a href="index.php?route=product">products</a>
      <a href="">contact</a>
      <a href="">blogs</a>
   </nav>

   <div class="icons">
      <form method="post">
         <input type="text" name="text-search" class="text-search" placeholder="search here">
         <button type="submit" name="btn-search"></button>
      </form>
      <button class="btn-search"><a class="fas fa-search"></a></button>
      <?php
         if(isset($_SESSION['username'])){
            $cartController->selectCount($_SESSION['username']);
            echo "
            <a href='#' class='fas fa-user btn-user'></a>
            <ul class='dropdown-user'>
               <li><a href='#'>
                  <i class='fas fa-user'></i>
                  user information
               </a></li>
               <hr>
               <li><a href='/user/view/content/signout.php'>
                  <i class='fa-solid fa-right-from-bracket'></i>
                  sign out
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