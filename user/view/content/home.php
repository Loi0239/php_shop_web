<?php
  include("database/connect.php");
  include("user/controller/productsController.php");

  $productsController = new ProductsController($conn);

  if(isset($_GET['addCart'])){
    if(!strcmp($_GET['addCart'],'true')){
        $msg = $productsController->addCart($_GET['idsp'], $_SESSION['username']);
    }else{
        $msg = "warning_cart";
    }
    header("location:index.php?route=home&&msg_add_cart=$msg");
}

if(isset($_GET['msg_add_cart'])){
    $msg_add_cart = $_GET['msg_add_cart'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./user/assets/css/home.css">

</head>
<body>
  <!-- slider section starts -->
<div class="slider-banner container">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="./user/assets/img/slider_1.jpg" class="d-block w-100" alt="...">
            </div>

            <div class="carousel-item">
            <img src="./user/assets/img/slider_2.jpg" class="d-block w-100" alt="...">   
            </div>

            <div class="carousel-item">
            <img src="./user/assets/img/slider_3.jpg" class="d-block w-100" alt="...">
            </div>

            <div class="carousel-item">
            <img src="user/assets/img/slide_4.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>
  <!-- slider section ends -->

  <!-- icons section starts -->
  <div class="container box-category">
    <h2>Danh mục</h2>
    <div class="icons-container">
      <?php
        $productsController->select_category_parent();
      ?>
    </div>
  </div>

    <button class="next-button">></button>
    <button class="prev-button"><</button>
  </div>
  <!-- icons section ends -->

  <!-- products section starts -->
  <section class="products container" id="products">
    <h1 class="heading"><span>sản phẩm</span> mới nhất </h1>
    <div class="box-container">
      <?php
        $productsController->newSelect();
      ?>
    </div>
  </section>
  <!-- products section ends -->
</body>
</html>