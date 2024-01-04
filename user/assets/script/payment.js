// Sự kiện khi chọn tỉnh/thành phố
$('#province').change(function () {
    // Lấy giá trị tỉnh/thành phố được chọn
    var selectedProvince = $(this).find('option:selected').data('district');
    var selectedDistrict = $('#district');
    var selectedWard = $('#ward');
    if(selectedProvince === 0){
        selectedDistrict.empty();
        selectedWard.empty();
        selectedDistrict.append("<option value='' data-district='0'>--Chọn quận huyện--</option>");
        selectedWard.append("<option value='' data-ward='0'>--Chọn phường/xã--</option>");
    }
    else{
        // Gửi yêu cầu Ajax để lấy danh sách quận/huyện của tỉnh/thành phố được chọn
        $.ajax({
            url: "https://provinces.open-api.vn/api/p/"+ selectedProvince +"?depth=2",
            method: "GET",
            success: function(data) {
                console.log(data);
                // Update the #district dropdown
                var districtDropdown = $("#district");
                districtDropdown.empty(); // Clear existing options
                districtDropdown.append("<option value='' data-ward='0'>--Chọn quận huyện--</option>");
                
                var wardDropdown = $("#ward");
                wardDropdown.empty(); // Clear existing options
                wardDropdown.append("<option value='' data-ward='0'>--Chọn phường/xã--</option>");
                // Populate options with districts
                $.each(data.districts, function(index, district) {
                    districtDropdown.append("<option value='" + district.name + "' data-ward='" + district.code + "'>" + district.name + "</option>");
                });

                // Enable the #district dropdown
                districtDropdown.prop("disabled", false);
            },
            error: function() {
                console.log("Error fetching districts");
            }
        });
    }
});

//Sự kiện khi chọn quận/huyện
$('#district').change(function () {
    // Lấy giá trị quận/huyện được chọn
    var selectedDistrict= $(this).find('option:selected').data('ward');
    var selectedWard = $('#ward');
    if(selectedDistrict === 0){
        selectedWard.empty();
        selectedWard.append("<option value='' data-ward='0'>--Chọn phường/xã--</option>");
    }else{
        // Gửi yêu cầu Ajax để lấy danh sách quận/huyện của tỉnh/thành phố được chọn
        $.ajax({
            url: "https://provinces.open-api.vn/api/d/"+ selectedDistrict +"?depth=2",
            method: "GET",
            success: function(data) {
                console.log(data);
                // Update the #ward dropdown
                var wardDropdown = $("#ward");
                wardDropdown.empty(); // Clear existing options
                wardDropdown.append("<option value='' data-ward='0'>--Chọn phường/xã--</option>");
                // Populate options with wards
                $.each(data.wards, function(index, ward) {
                    wardDropdown.append("<option value='" + ward.name + "'>" + ward.name + "</option>");
                });

                // Enable the #ward dropdown
                wardDropdown.prop("disabled", false);
            },
            error: function() {
                console.log("Error fetching wards");
            }
        });
    }
});

// hiện giá trị tiền
var total = 0;
$('.price').each(function(){
    var price = $(this).text();
    var priceValue = parseInt(price, 10) || 0;
    var fommatPrice = price.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $(this).text(fommatPrice + "đ");
    total += priceValue;
});

var formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
$('.price-total').text(formattedTotal + "đ");