// menu btn
let navbar = document.querySelector('.navbar');
document.querySelector('#menu-btn').onclick = () =>{
  navbar.classList.toggle('active');
  searchForm.classList.remove('active');
  cartItem.classList.remove('active');
}

const mainImage = document.querySelector(".main-image img");
const thumbnails = document.querySelectorAll(".thumbnail img");

thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener("click", () => {
        mainImage.src = thumbnail.src;
    });
});

thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener("click", () => {
        thumbnails.forEach((t) => t.parentElement.classList.remove("selected-thumbnail"));
        thumbnail.parentElement.classList.add("selected-thumbnail");
        mainImage.src = thumbnail.src;
    });
});

const decrementButtons = document.querySelectorAll('.decrement');
const incrementButtons = document.querySelectorAll('.increment');
const countInputs = document.querySelectorAll('.count');
const priceElements = document.querySelectorAll('.price h1');
const totalElements = document.querySelectorAll('.sub-total span');
const prices = [];

function updateTotalPrice(index) {
  const qty = parseInt(countInputs[index].value, 10);
  const price = parseFloat(prices[index]);
  const total = qty * price;
  var fommatTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  totalElements[index].textContent = fommatTotal + "đ";
}

countInputs.forEach(function (countInput, index) {
  countInput.addEventListener('input', function () {
    var currentValue = parseInt(countInput.value, 10);
    var minValue = parseInt(countInput.getAttribute('min'), 10);
    var maxValue = parseInt(countInput.getAttribute('max'), 10);

    if (isNaN(currentValue) || currentValue < minValue) {
      countInput.value = minValue;
    } else if (currentValue > maxValue) {
      countInput.value = maxValue;
    }
  })
});

decrementButtons.forEach(function (decrementButton, index) {
  decrementButton.addEventListener('click', function () {
    var currentValue = parseInt(countInputs[index].value, 10);
    var minValue = parseInt(countInputs[index].getAttribute('min'), 10);

    if (!isNaN(currentValue) && currentValue > minValue) {
      countInputs[index].value = currentValue - 1;
      updateTotalPrice(index);
    }
  });
});

incrementButtons.forEach(function (incrementButton, index) {
  incrementButton.addEventListener('click', function () {
    var currentValue = parseInt(countInputs[index].value, 10);
    var maxValue = parseInt(countInputs[index].getAttribute('max'), 10);

    if (!isNaN(currentValue) && currentValue < maxValue) {
      countInputs[index].value = currentValue + 1;
      updateTotalPrice(index);
    }
  });
});

countInputs.forEach(function (countInput, index) {
  countInput.addEventListener('change', function () {
    updateTotalPrice(index);
  });
});

priceElements.forEach(function (priceElement, index) {
  var priceText = priceElement.textContent;
  var price = parseInt(priceText.replace(/[^\d.]/g, ''), 10);
  prices.push(price);
  var fommatPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  priceElement.textContent = fommatPrice + "đ";
});


totalElements.forEach(function (totalElement, index) {
  updateTotalPrice(index);
});

//link nút mua
$('.btn_buy').on('click', function(){
  var idsp = $(this).data('idsp');
  var iduser = $(this).data('iduser');
  var idtsp = $(this).data('idtsp');
  var thisButton = $(this);
  if(iduser <= 0){
    thisButton.attr('href', 'user/view/content/signin.php');
  }else{
    countInputs.forEach(function(countInput) {
      thisButton.attr('href', 'index.php?route=payment&idsp='+idsp+'&idtsp='+idtsp+'&iduser='+iduser+'&count='+countInput.value);
    });
  }
});

var counters = document.querySelectorAll('.star-counter');
var bars = document.querySelectorAll('.progress-bar');
const totalStar = document.querySelector('#total-star');
// Đảo ngược mảng bars


counters.forEach(function(counter, index) {
  var count = parseFloat(counter.textContent);
  var total = parseFloat(totalStar.textContent); // Sử dụng giá trị PHP $count

  if (total > 0 && count != 0) {
    var percentage = (count / total) * 100;
    bars[index].style.width = percentage + '%';
  }else{
    bars[index].style.width = 0 + '%'; 
  }
});

$('.comment-wrap').on('click', '.likes', function(){
  var clickedElement = $(this);
  var idcmt = clickedElement.closest('.likes').data('idcmt');
  var idUser = clickedElement.closest('.likes').data('iduser');
  var idsp = clickedElement.closest('.likes').data('idsp');
  var idUserOfCmt = clickedElement.closest('.likes').data('iduserofcmt');
  var likes = clickedElement.closest('.likes').find('i');
  var likeCount = clickedElement.closest('.likes').find('.like-count');
  var totalLikes = clickedElement.closest('.box').find('.total-likes');
  var newLikeCount = parseInt(likeCount.text()); // Chuyển đổi thành số
  var newTotalLikes = parseInt(totalLikes.text());
  if (idcmt && idUser > 0 && idsp && idUserOfCmt) {
    $.ajax({
      method: "get",
      url: "../../../index.php?route=detailProduct",
      data: {sign: "likes", idcmt: idcmt, idUser: idUser, idsp: idsp, idUserOfCmt:idUserOfCmt},
      success: function(response) {
        console.log(response);
        if (response.includes('thêm thành công')) {
          likes.css("color", "blue");
          newLikeCount++;
          newTotalLikes++;
          likeCount.text(newLikeCount);
          totalLikes.text(newTotalLikes);
        } else if(response.includes('xóa thành công')){
          likes.css("color", "");
          newLikeCount--;
          newTotalLikes--;
          likeCount.text(newLikeCount);
          totalLikes.text(newTotalLikes);
        }
      },
      error: function(error) {
        console.error(error);
      }
    });
  } else {
    Swal.fire({
      title: "Bạn cần đăng nhập để thực hiện được chức năng này!",
      icon: "warning",
      customClass: {
          popup: "custom-size"
      }
    });
  }
});

$('.comment-wrap').on('click', '.comments', function(){
  var idUser = $(this).data('iduser');
  var idsp = $(this).data('idsp');
  var idcmt = $(this).data('idcmt');
  var idsub = $(this).data('idsub');
  var commentBox = $(this).closest('.react').find('.comment-box');
  var textComment = $(this).closest('.react').find('.comment-box').find('.text-comment');
  var btnSubmit = $(this).closest('.react').find('.comment-box').find('.btn-submit');
  var totalSubReact = $(this).closest('.react').find('.total-sub-react');
  var firstSubReact = totalSubReact.find('.sub-react:first-child p').text();
  if(idUser > 0){
    if(commentBox.css('display') == "none"){
      commentBox.css("display", "block");
      if(idsub != 0){
        totalSubReact.children(':first-child').css("display", "none");
        textComment.val(firstSubReact);
      }
    }else{
      commentBox.css("display", "none");
      if(idsub != 0){
        totalSubReact.children(':first-child').css("display", "block");
      }
    }
    $(btnSubmit).click(function(){
      var content = commentBox.find('.text-comment').val();

      if(content != ''){
        sendData(idsp,content,idcmt,totalSubReact,idsub);
        commentBox.css("display", "none");
      }
    })
  }else{
    Swal.fire({
      title: "Bạn cần đăng nhập để thực hiện được chức năng này!",
      icon: "warning",
      customClass: {
          popup: "custom-size"
      }
    });
  }
});

// Sử dụng sự kiện input để theo dõi thay đổi trong textarea
$('.comment-wrap').on('input', '.text-comment', function() {
  autoExpandTextarea(this);
  console.log($(this).val());
});

// Sử dụng sự kiện keyup để theo dõi khi người dùng xóa nội dung
$('.comment-wrap').on('keyup', '.text-comment', function(e) {
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

$('.comment-wrap').on('keydown', '.text-comment', function (e) {
  var idsp = $(this).closest('.react').find('.comments').data('idsp');
  var idcmt = $(this).closest('.react').find('.comments').data('idcmt');
  var idsub = $(this).closest('.react').find('.comments').data('idsub');
  var commentBox = $(this).closest('.comment-box');
  var totalSubReact = $(this).closest('.react').find('.total-sub-react');
  var content = $(this).val();
  // Kiểm tra nếu phím Enter được nhấn (mã ASCII: 13) và không nhấn Shift
  if (e.which === 13 && !e.shiftKey) {
      // Ngăn chặn hành động mặc định của phím Enter (ngăn không cho xuống dòng)
      e.preventDefault();
      commentBox.css("display", "none");

      // Gửi dữ liệu thông qua Ajax ở đây
      sendData(idsp,content,idcmt,totalSubReact,idsub);
  }
});

function sendData(idsp,content,idcmt,totalSubReact,idsub){
  var idUser = $('.likes').data('iduser');
  var commentText = content.replace(/\n/g, "<br>");
  var sign;
  var tempid;
  if(idsub != 0){
    sign = "updateComment";
    tempid = idsub;
  }else{
    sign = "addComment";
    tempid = idcmt;
  }
  $.ajax({
    method: "get",
    url: "../../../index.php?route=detailProduct",
    data: {sign: sign, idsp: idsp, idUser: idUser, idcmt: tempid, content: commentText},
    success: function(response) {
      console.log(response);
      if (response.includes('thành công')) {
        // var commentText = content.replace(/\n/g, "<br>");
        var username = $("#username").val();
        var words = username.split(" ");
        var wordCount = words.length;
        var resultWord = '';

        // Xử lý nếu tên chỉ có một chữ
        if (wordCount === 1) {
            resultWord = words[0].charAt(0).toUpperCase();
        } else {
            // Tên có nhiều hơn một chữ
            resultWord += words[wordCount - 2].charAt(0).toUpperCase();
            resultWord += words[wordCount - 1].charAt(0).toUpperCase();
        }
        console.log(totalSubReact);
        var firstSubReact = totalSubReact.find('.sub-react:first-child').remove();
        $(totalSubReact).prepend('<div class="sub-react"><div class="heading"><div class="logo">'
        + resultWord +'</div><h4>'+username+'</h4></div><p>' + commentText + '</p></div>');
        $(".text-comment").val("");
      } else if(response.includes('thất bại')){
        console.log("thêm thất bại");
      }
    },
    error: function(error) {
      console.error(error);
    }
  });
}

//hiện nhiều comment con
// Ẩn tất cả các .sub-react trừ phần tử đầu tiên
$('.sub-react:not(:first-child)').hide();

// Xử lý sự kiện khi người dùng nhấn vào .total-comment
  $('.comment-wrap').on('click','.total-comment', function () {
  var idsub = $(this).closest('.react').find('.comments').data('idsub');
  // Hiển thị tất cả các .sub-react
  console.log(idsub);
  if(idsub != 0){
    $(this).closest('.react').find('.sub-react:not(:first-child)').show();
  }else{
    $(this).closest('.react').find('.sub-react').show();
  }
  $(this).hide();
  });

//phân trang comment 
$('.page-number').on('click', '.prev, .next, .pages', function(){
  var idsp = $(this).data('idsp');
  var page = $(this).data('page');
  pages(idsp,page);
});

function pages(idsp,page){
  var wrap = $('.comment-wrap');
  var pageNumber = $('.page-number');
  $.ajax({
    method: "get",
    url: "../../../index.php?route=detailProduct",
    data: {idsp: idsp, page: page},
    success: function(response) {
      console.log(response);
      var responseData = $(response);
      var wrapContent = responseData.find('.comment-wrap').html();
      wrap.html(wrapContent);

      var pageNumberContent = responseData.find('.page-number').html();
      pageNumber.html(pageNumberContent);

      // Scroll đến phần tử comment-wrap
      var commentWrapOffset = wrap.offset().top - 100;
      console.log(commentWrapOffset);
      $('html, body').animate({ scrollTop: commentWrapOffset }, 10);
    },
    error: function(error) {
      console.error(error);
    }
  })
}
