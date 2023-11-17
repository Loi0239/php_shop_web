<?php
    // cart
    if(isset($msg_add_cart)){
        if(!strcmp($msg_add_cart,"success_cart")){
            echo '<script>Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Bạn đã thêm sản phẩm vào giỏ hàng thành công !",
                showConfirmButton: false,
                timer: 1500
              })</script>';
        }else if (!strcmp($msg_add_cart,"fail_cart")){
            echo '<script>Swal.fire(
                "Bạn đã thất bại trong việc thêm sản phẩm vào giỏ hàng của bạn
                <br>Vui lòng thử lại sau ", "",
                "error");</script>';
        }else if (!strcmp($msg_add_cart,"warning_cart")){
            echo '<script>Swal.fire({
                title: "Bạn cần đăng nhập để có thể thêm sản phẩm vào giỏ hàng",
                icon: "warning",
                customClass: {
                    popup: "custom-size"
                }
            });</script>';
            
            
        }
     }
?>