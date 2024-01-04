<?php
    include_once('user/model/invoiceModel.php');

    class InvoiceController{
        private $invoice_sign;

        public function __construct($conn) {
            $this->invoice_sign = new InvoiceModel($conn);
        }

        public function selectData($invoice){
            if(isset($_SESSION['username'])){
                $iduser = $this->invoice_sign->getIdUser($_SESSION['username']);
            }
            $result = $this->invoice_sign->selectData($invoice,$iduser);
            $count = 0;
            while($row=mysqli_fetch_assoc($result)){
                $status = "";
                switch ($row['I_status']) {
                case 0:
                    $status = "Đơn hàng mới";
                    break;
                case 1:
                    $status = "Đã duyệt";
                    break;
                case 2:
                    $status = "Đang vận chuyển";
                    break;
                case 3:
                    $status = "Đã giao";
                    break;
                case 4:
                    $status = "Đã mua";
                    break;
                case 5:
                    $status = "Đã hủy";
                    break;
                }
                $count++;
                if($row['I_status'] == "0" || $row['I_status'] == "1" ){
                    $deleteOrder = '<td><a href="index.php?route=invoice&idOrder='.$row['I_id_orders'].'&sign=delete" class="btn-delete">Hủy</a></td>';
                }else{
                    $deleteOrder = "";
                }
                if($row['I_status'] == "3"){
                    $detailOrder = '<td><a href="index.php?route=invoice&idOrder='.$row['I_id_orders'].'&sign=confirm" class="btn-confirm">Đã nhận hàng</a></td>';
                }else if($row['I_status'] == "5"){
                    $detailOrder = '<td><a href="index.php?route=invoice&idOrder='.$row['I_id_orders'].'&sign=restore" class="btn-restore">khôi phục đơn hàng</a></td>';
                }else{
                    $detailOrder = '<td><a href="index.php?route=detailOrder&idOrder='.$row['I_id_orders'].'" class="btn-detail">Xem chi tiết</a></td>';
                }
                echo'
                    <tr>
                        <td>'.$count.'</td>
                        <td>'.$row['T_code_orders'].'</td>
                        <td>'.$row['T_order_date'].'</td>
                        <td>'.$status.'</td>
                        '.$detailOrder.'
                        '.$deleteOrder.'
                    </tr>
                ';
            }
        }

        public function deleteInvoice($idOrder){
            $result = $this->invoice_sign->deleteInvoice($idOrder);
        }

        public function confirmInvoice($idOrder){
            $result = $this->invoice_sign->confirmInvoice($idOrder);
        }

        public function restoreInvoice($idOrder){
            $result = $this->invoice_sign->restoreInvoice($idOrder);
        }
    }
?>