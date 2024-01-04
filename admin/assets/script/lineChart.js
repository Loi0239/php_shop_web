$(document).ready(function(){
    // Gửi Ajax request khi trang tải
    $.ajax({
        url: 'api.php?sign=line', // Tên file xử lý dữ liệu
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            createChart(data);
        },
        error: function(error) {
            console.log('Error:', error);
        }
    });

    // Hàm tạo biểu đồ
    function createChart(data) {
        // Mảng chứa nhãn tháng và giá trị tương ứng
        var monthsData = Array.from({ length: 12 }, (_, index) => ({
            label: `Tháng ${index + 1}`,
            value: 0
        }));

        // Cập nhật giá trị từ dữ liệu thực
        data.forEach(item => {
            var monthIndex = parseInt(item.Thang) - 1;
            monthsData[monthIndex].value = parseInt(item.So_luong_da_ban);
        });

        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line', // Thay đổi type thành 'line'
            data: {
                labels: monthsData.map(item => item.label),
                datasets: [{
                    label: 'Số lượng đã bán',
                    data: monthsData.map(item => item.value),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false // Thêm fill: false để hiển thị đường
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});