// Trong hàm toggleReview(number)

function toggleReview(number) {
    var reviewId = "review" + number;
    var reviewDiv = document.getElementById(reviewId);

    if (window.getComputedStyle(reviewDiv).display === 'none') {
        reviewDiv.style.display = 'block';
    } else {
        reviewDiv.style.display = 'none';
    }

    var stars = reviewDiv.querySelector('.stars');
    var starIcons = stars.querySelectorAll('i');
    var ratingSpan = stars.querySelector('span'); // Thêm dòng này để lấy thẻ span
    var beginStar = stars.querySelector('span').textContent;

    var clicked = false; // Biến để kiểm tra xem có đang ở chế độ click không

    // Thêm sự kiện cho từng icon sao
    starIcons.forEach(function(star, index) {
        star.addEventListener('mouseover', function() {
        if (!clicked) {
            // Chuyển màu của các icon sao từ 0 đến index thành màu vàng
            for (var i = 0; i <= index; i++) {
            starIcons[i].style.color = 'gold';
            }

            // Cập nhật số trong thẻ span với 1 chữ số thập phân
            ratingSpan.textContent = (index + 1);

            // Đặt lại màu và số của những sao không được chọn
            for (var i = index + 1; i < starIcons.length; i++) {
            starIcons[i].style.color = 'gray';
            }
        }
        });

        star.addEventListener('mouseout', function() {
        if (!clicked) {
            // Chuyển màu của tất cả icon sao về màu xám khi rê chuột ra khỏi sao
            starIcons.forEach(function(singleStar) {
            singleStar.style.color = 'gray';
            });

            // Đặt lại số trong thẻ span khi rê chuột ra khỏi sao
            ratingSpan.textContent = beginStar; // Số của sao được chọn trước đó
        }
        });

        star.addEventListener('click', function() {
        clicked = true; // Chuyển sang chế độ click
        $('#countStar'+number).val(index + 1);
        console.log(index + 1); // Log số của sao khi bấm vào
        });
    });

    // Thêm sự kiện cho `.stars` để thoát chế độ click khi rê chuột ra khỏi nó
    stars.addEventListener('mouseout', function() {
        clicked = false; // Trở lại chế độ rê chuột
    });
}

$('.submitComment').click(function(){
    var star = $(this).closest('.review').find('.countStar').val();
    var content = $(this).closest('.review').find('.text-comment').val();
    var idUser = $(this).closest('.review').data('iduser');
    var idPro = $(this).closest('.review').data('idpro');
    var idTypePro = $(this).closest('.review').data('idtypepro');
    var idCmt = $(this).closest('.review').data('idcmt');
    if(content != '' && star != 0){
      sendData(star,content,idUser,idPro,idTypePro,idCmt);
    }else{
        Swal.fire({
            title: "Vui lòng đánh giá số sao và có nội dung đánh giá!<br>Xin cảm ơn",
            icon: "warning",
            customClass: {
                popup: "custom-size"
            }
          });
    }
})

// Sử dụng sự kiện input để theo dõi thay đổi trong textarea
$('.text-comment').on('input', function() {
    autoExpandTextarea(this);
});

// Sử dụng sự kiện keyup để theo dõi khi người dùng xóa nội dung
$('.text-comment').on('keyup', function(e) {
    if (e.keyCode == 8 || e.keyCode == 46) { // Backspace or Delete key
        autoExpandTextarea(this);
    }
});

function autoExpandTextarea(textarea) {
    // Tính toán số hàng của textarea
    var rows = textarea.value.split('\n').length + 1;

    // Đặt chiều cao của textarea dựa vào số hàng
    var lineHeight = parseInt($(textarea).css('line-height'), 10);
    var newHeight = rows * lineHeight + 'px';

    $(textarea).css('height', newHeight);
}

$('.text-comment').on('keydown', function (e) {
    var star = $(this).closest('.review').find('.countStar').val();
    var content = $(this).val();
    var idUser = $(this).closest('.review').data('iduser');
    var idPro = $(this).closest('.review').data('idpro');
    var idTypePro = $(this).closest('.review').data('idtypepro');
    var idCmt = $(this).closest('.review').data('idcmt');
    // Kiểm tra nếu phím Enter được nhấn (mã ASCII: 13) và không nhấn Shift
    if (e.which === 13 && !e.shiftKey) {
        // Ngăn chặn hành động mặc định của phím Enter (ngăn không cho xuống dòng)
        e.preventDefault();

        if(content != '' && star != 0){
            sendData(star,content,idUser,idPro,idTypePro,idCmt);
        }else{
            Swal.fire({
                title: "Vui lòng đánh giá số sao và có nội dung đánh giá!<br>Xin cảm ơn",
                icon: "warning",
                customClass: {
                    popup: "custom-size"
                }
            });
        }
    }
});

function sendData(star,content,idUser,idPro,idTypePro,idCmt){
    var commentText = content.replace(/\n/g, "<br>");
    var sign;
    if(idCmt != 0){
        sign = "updateComment";
    }else{
        sign = "addComment";
    }
    $.ajax({
        method: "get",
        url: "../../../index.php?route=detailOrder",
        data: {sign: sign, star: star, content: commentText, idUser: idUser, idsp: idPro, idtsp:idTypePro, idcmt: idCmt},
        success: function(response) {
        console.log(response);
        if (response.includes('success')) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Cảm ơn bạn đã dành thời gian đánh giá",
                showConfirmButton: false,
                timer: 1500
              })
        }
        },
        error: function(error) {
        console.error(error);
        }
    });
}