//header
try {
  const btnSearch = document.querySelector(".btn-search");
  const textSearch = document.querySelector(".text-search");
  const navbar = document.querySelector(".navbar");
  const btnBar = document.querySelector("#menu-btn");

  btnSearch.addEventListener("click", () => {
    if (textSearch.classList.contains("show-search")) {
      textSearch.classList.remove("show-search");
    } else {
      textSearch.classList.add("show-search");
    }
  });

  btnBar.addEventListener("click", () => {
    if (navbar.classList.contains("active")) {
      navbar.classList.remove("active");
    } else {
      navbar.classList.add("active");
    }
  }); 
} catch (error) {
}

//kiểm tra đăng nhập thành công
try {
  const btnUser = document.querySelector(".btn-user");
  const dropdownUser = document.querySelector(".dropdown-user");
  
  btnUser.addEventListener("click", () => {
    if (dropdownUser.classList.contains("show-dropdown-user")) {
      dropdownUser.classList.remove("show-dropdown-user");
    } else {
      dropdownUser.classList.add("show-dropdown-user");
    }
  });
} catch (error) {
}

// home
try {
  const container = document.querySelector('.icons-container');
  const nextButton = document.querySelector('.next-button');
  const prevButton = document.querySelector('.prev-button');
  
  nextButton.addEventListener('click', function() {
    container.scrollLeft += container.clientWidth;
    setTimeout(checkButtonsVisibility, 800); // Gọi hàm sau một khoảng thời gian rất ngắn
  });
  
  prevButton.addEventListener('click', function() {
    container.scrollLeft -= container.clientWidth;
    setTimeout(checkButtonsVisibility, 800); // Gọi hàm sau một khoảng thời gian rất ngắn
  });
  
  function checkButtonsVisibility() {
    const canScrollRight = container.scrollLeft + container.clientWidth < container.scrollWidth -1;
    const canScrollLeft = container.scrollLeft > 0;
    console.log(canScrollRight + "  " + canScrollLeft + "  "  + container.scrollLeft + container.clientWidth + " " + container.scrollWidth);
  
    if (canScrollRight) {
      nextButton.style.display = 'block';
    } else {
      nextButton.style.display = 'none';
    }
  
    if (canScrollLeft) {
      prevButton.style.display = 'block';
    } else {
      prevButton.style.display = 'none';
    }
  }
  
  checkButtonsVisibility();
  
  // Tự động kiểm tra lại khi cửa sổ thay đổi kích thước
  window.addEventListener('resize', checkButtonsVisibility);
} catch (error) {
}

//products
try {
  const btnCategory = document.querySelector(".parent_category");
  const subCategory = document.querySelector(".sub_category");

  function addHeight(){
    var liHeight = parseInt(getComputedStyle(subCategory.querySelector('li')).height);
    var hightSubCategory = liHeight * subCategory.children.length + 35;
    document.documentElement.style.setProperty('--ul-height', hightSubCategory + 'px');
  }

  btnCategory.addEventListener("click", () => {
    addHeight();
    if (subCategory.classList.contains("show")) {
      subCategory.classList.remove("show");
    } else {
      subCategory.classList.add("show");
    }
  }); 

  const priceElements = document.querySelectorAll(".price");
  for(var priceElement of priceElements ){
    var priceText = priceElement.textContent;
    var price = parseInt(priceText, 10);
    var fommatPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    priceElement.textContent = fommatPrice + "đ";
  }
  
} catch (error) {
}

//detaiProduct + cart
try {
  document.addEventListener('DOMContentLoaded', function() {
    const decrementButtons = document.querySelectorAll('.decrement');
    const incrementButtons = document.querySelectorAll('.increment');
    const countInputs = document.querySelectorAll('.count');
    const priceElements = document.querySelectorAll('.price_cart span');
    const totalElements = document.querySelectorAll('.total_price_cart span');
    const parentCheckbox = document.getElementById('parent_check');
    const childCheckboxes = document.querySelectorAll('input[name="check"]');
    const prices = [];
    const printTotalPrices = [];
    const productTotals = [];

    function updateTotalPrice(index) {
      const qty = parseInt(countInputs[index].value, 10);
      const price = parseFloat(prices[index]);
      const total = qty * price;
      var fommatTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      totalElements[index].textContent = fommatTotal + "đ";

      // Store the total value in the productTotals array
      productTotals[index] = total;

      // Recalculate total price when a checkbox is checked or unchecked
      recalculateTotalPrice();
    }

    function recalculateTotalPrice() {
      totalPrice = 0;
      printTotalPrices.length = 0; // Clear the array

      productTotals.forEach(function (total, index) {
        if (childCheckboxes[index].checked) {
          totalPrice += total;
          printTotalPrices.push(total);
        }
      });

      // Update the displayed total price
      var fommatTotalPrice = totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      document.querySelector('.total_price').textContent = fommatTotalPrice + "Đ";
      document.querySelector('.price').textContent = fommatTotalPrice + "Đ";
    }

    decrementButtons.forEach(function (decrementButton, index) {
      decrementButton.addEventListener('click', function () {
        if (countInputs[index].value > 1) {
          countInputs[index].value--;
          updateTotalPrice(index);
        }
      });
    });

    incrementButtons.forEach(function (incrementButton, index) {
      incrementButton.addEventListener('click', function () {
        countInputs[index].value++;
        updateTotalPrice(index);
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

    parentCheckbox.addEventListener('change', function () {
      childCheckboxes.forEach(function (checkbox) {
        checkbox.checked = parentCheckbox.checked;
      });

      // Recalculate total price when the parent checkbox is changed
      recalculateTotalPrice();
    });

    childCheckboxes.forEach(function (checkbox, index) {
      checkbox.addEventListener('change', function () {
        updateTotalPrice(index);
      });
    });

    $('.delete').click(function(){
      var idcart = $(this).closest('.show_item').data('idcart');
      var idsp = $(this).closest('.show_item').data('idsp');
      var showItem = $(this).closest('.show_item');

     if (idcart && idsp) {
      $.ajax({
        method: "post",
        url: "../../../index.php?route=cart", // Thay đổi đường dẫn tới tệp controller của bạn
        data: {delete: "delete", idcart: idcart, idsp: idsp },
        success: function(response) {
          // Xử lý phản hồi từ server (nếu cần)
          console.log(response);
          showItem.fadeOut(500, function() {
            $(this).remove(); // Xóa hoặc ẩn .show_item sau khi fadeOut
          });
        },
        error: function(xhr, status, error) {
          // Xử lý lỗi (nếu có)
          console.error(error);
        }
      });
    } else {
    console.log("Không có giá trị idcart hoặc idsp");
  }
    })
  });
} catch (error) {
}

// xử lý checkbox
try {
} catch (error) {
}
