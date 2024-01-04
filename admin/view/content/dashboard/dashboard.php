<div class="row mt-3">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-9 text-right ml-5">
                        <?php
                            $qlkh = new QlkhController($conn);
                            $sql = $qlkh->selectData();
                            $rs = mysqli_num_rows($sql);
                        ?>
                        <div class="huge"><?php echo $rs; ?></div>
                        <div>Người dùng hiện tại</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-3">
                        <i class="fa fa-shopping-bag fa-5x"></i>
                    </div>
                    <div class="col-9 text-right ml-5">
                        <?php
                            $pro = new productController($conn);
                            $sql1= $pro->sumProductType();
                            $rs = mysqli_fetch_array($sql1);
                        ?>
                        <div class="huge"><?php echo $rs['Tong_so_luong_con_lai']; ?></div>
                        <div>Sản phẩm còn lại</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-orange">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-9 text-right ml-5">
                        <?php
                            $sanpham = new productController($conn);
                            $sql2= $sanpham->sumProductSale();
                            $rs = mysqli_fetch_array($sql2);
                        ?>
                        <div class="huge"><?php echo $rs['Tong_so_luong_da_ban']; ?></div>
                        <div>Sản phẩm đã bán</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.panel {
    border: 1px solid transparent;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    margin-bottom: 20px;
}

.panel:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.panel-primary>.panel-heading {
    padding: 15px;
    border-radius: 8px;
    color: #fff;
    background-color: #337ab7;
    border-color: #337ab7;
}

.panel-orange .panel-heading {
    padding: 15px;
    border-radius: 8px;
    border-color: #f0ad4e;
    color: #fff;
    background-color: #f0ad4e;
}

.panel-green .panel-heading {
    padding: 15px;
    border-radius: 8px;
    border-color: #5cb85c;
    color: #fff;
    background-color: #5cb85c;
}

.panel-heading i {
    font-size: 4em;
    padding-left: 15px;
}

.panel-body {
    padding: 20px;
}

.text-right{
    text-align:right;
}

.huge {
    font-size: 3em;
    font-weight: bold;
    margin-bottom: 5px;
}
</style>
<!-- 
<link rel="stylesheet" href="../assets/css/dashboard.css"> -->


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="row mt-5">
        <div class="col px-5">
            <canvas id="lineChart" width="400" height="200"></canvas>
            <p class="text-center"><b>Biểu đồ đường thống kê số lượng sản phẩm đã bán năm 2023</b></p>
        </div>
    </div>
    <style>
        /* Áp dụng font chung cho trang web */
        body {
            font-family: 'Arial', sans-serif;
        }

        /* Căn giữa nội dung của col */
        .col {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Tạo đường viền cho canvas */
        #myChart {
            border: 1px solid #ddd; /* Màu đường viền */
            border-radius: 8px; /* Bo tròn góc */
        }

        /* Định dạng văn bản trong thẻ p */
        p.text-center {
            margin-top: 10px; /* Khoảng cách từ canvas lên đến văn bản */
            font-size: 16px; /* Kích thước font chữ */
            color: #333; /* Màu chữ */
        }
    </style>
    <script src="../assets/script/lineChart.js"></script>
    