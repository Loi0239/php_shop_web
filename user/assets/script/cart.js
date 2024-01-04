const decrementButtons = document.querySelectorAll('.decrement');
const incrementButtons = document.querySelectorAll('.increment');
const countInputs = document.querySelectorAll('.count');
const hiddentCountInputs = document.querySelectorAll('.hidden_count');
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
      // Giảm giá trị hidden_count
      const currentHiddenValue = hiddentCountInputs[index].value;
      const [currentQty, I_id_pro, I_id_type_pro] = currentHiddenValue.split('-');
      const newQty = parseInt(currentQty) - 1;

      // Cập nhật giá trị mới
      hiddentCountInputs[index].value = `${newQty}-${I_id_pro}-${I_id_type_pro}`;
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
    }
    // Tăng giá trị hidden_count
    const currentHiddenValue = hiddentCountInputs[index].value;
    const [currentQty, I_id_pro, I_id_type_pro] = currentHiddenValue.split('-');
    const newQty = parseInt(currentQty) + 1;

    // Cập nhật giá trị mới
    hiddentCountInputs[index].value = `${newQty}-${I_id_pro}-${I_id_type_pro}`;
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
  var idtsp = $(this).closest('.show_item').data('idtsp');
  var showItem = $(this).closest('.show_item');
  console.log(idtsp);
  if (idcart && idsp) {
    $.ajax({
      method: "post",
      url: "../../../index.php?route=cart", // Thay đổi đường dẫn tới tệp controller của bạn
      data: {delete: "delete", idcart: idcart, idsp: idsp, idtsp: idtsp},
      success: function(response) {
        // Xử lý phản hồi từ server (nếu cần)
        console.log(response);
        showItem.fadeOut(500, function() {
          $(this).remove(); // Xóa hoặc ẩn .show_item sau khi fadeOut
        });
      },
      error: function(error) {
        // Xử lý lỗi (nếu có)
        console.error(error);
      }
    });
  } else {
  console.log("Không có giá trị idcart hoặc idsp");
  }
});

// xử lý nút mua
$('.btn_buy').on('click', function () {
  var idsps = [];
  var idtsps = [];
  var counts = [];
  var iduser = $('.show_item').data('iduser');

  $('.show_item').each(function () {
      var checkbox = $(this).find('input[name="check"]');
      
      if (checkbox.is(':checked')) {
          idsps.push($(this).data('idsp'));
          idtsps.push($(this).data('idtsp'));
          counts.push($(this).find('.count').val());
      }
  });

  console.log(iduser, idsps, idtsps, counts);
  $(this).attr('href', 'index.php?route=payment&idsp='+idsps+'&idtsp='+idtsps+'&iduser='+iduser+'&count='+ counts + '&sign=cart');
});
