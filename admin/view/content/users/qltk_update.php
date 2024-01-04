<?php
    $qlkh = new QlkhController($conn);
    $result = $qlkh->selectData1();
    $row = mysqli_fetch_array($result);
    
    $qlkh->updateData();
?>
<div class="container mt-4">
    <form action="" method="post">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Sửa Người Dùng</h5>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="ten" class="col-sm-2 col-form-label">Họ Tên:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ten" name="ten" value="<?php echo $row['T_name']?>" placeholder='Vd: Nguyễn Văn A' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sdt" class="col-sm-2 col-form-label">Số Điện Thoại:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="sdt" name="sdt" value="<?php echo $row['T_number_phone']?>" placeholder='Vd: 0123456789' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="diachi" class="col-sm-2 col-form-label">Địa Chỉ:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="diachi" name="diachi" value="<?php echo $row['T_address']?>" placeholder='Vd: Đường..., Quận..., Thành phố..., Quốc gia...' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['T_email']?>" placeholder='Vd: abc@gmail.com' required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Ngày sinh:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="email" name="ngaysinh" value="<?php echo $row['D_day_of_birth']?>" placeholder='Vd: 1995-05-21' required>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" name="btn">Sửa</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col mt-3">
            <a href="main.php?ql=qltk" style="text-decoration:none; color: black; margin-top:50%;">
                <i class="fa-solid fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>

    