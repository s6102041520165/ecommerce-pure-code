
<?php require_once 'header.php' ?>
<?php 
if($_GET['action']=='save'){
    $ext = pathinfo($_FILES['slipe']['name'],PATHINFO_EXTENSION);
    $name = "slipe_".$_POST['orderID']."order.".$ext;
    $tmp = $_FILES['slipe']['tmp_name'];
    if(!$tmp){
        $name = $_POST['noselect'];
    } else {
        @unlink("image/".$_POST['noselect']);
    }
    
    move_uploaded_file($tmp,"image/".$name);
    $datepay = $_POST['datepay']." ".$_POST['timepay'];
    $sql = $pdo->query("REPLACE INTO tbl_payment (orderID,bank,location,amount,datepay,status,slipe)
            VALUES ('".$_POST['orderID']."',
            '".htmlspecialchars($_POST['bank'])."',
            '".htmlspecialchars($_POST['location'])."',
            '".htmlspecialchars($_POST['amount'])."',
            '".$datepay."',
            'no',
            '".$name."' ) ") or die (mysqli_error($conn));
    echo "<script>window.history.go(-2);</script>";
}
?>
<?php require_once 'sidebar.php' ?>


<div class="col-md-9 col-lg-9">
<br>
    <div class="card border-pink">
        <div class="card-header bg-pink text-light">
            <span class="fa fa-credit-card"></span> แจ้งชำระเงิน
        </div>
        <div class="card-body">
            <?php if($rs_member->username && $_GET['orderID']){ ?>
                <?php                  
                    $sql = $pdo->query(" SELECT *,DATE_FORMAT(datepay,'%Y-%m-%d') as datepaytext,DATE_FORMAT(datepay,'%H:%i:%s') as timepay FROM tbl_payment WHERE orderID = '".$_GET['orderID']."' ");
                    $rs_order = $sql->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="payment.php?action=save" onsubmit="return chkfirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่!!!')" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        ธนาคาร
                        <input type="hidden" name="orderID" value="<?php echo $_GET['orderID']; ?>">
                        <input name="bank" required type="text" value="<?php echo $rs_order['bank'] ?>" placeholder="ธนาคาร" class="form-control">
                    </div>

                    <div class="form-group">
                        สาขา/สถานที่โอน
                        <input name="location" required type="text" value="<?php echo $rs_order['location'] ?>" placeholder="สาขา/สถานที่โอน" class="form-control">
                    </div>

                    <div class="form-group">
                        จำนวนเงิน
                        <input name="amount" required type="number" value="<?php echo $rs_order['amount'] ?>" placeholder="จำนวนเงิน" class="form-control">
                    </div>

                    <div class="form-group">
                        วันที่โอน
                        <input name="datepay" required type="date" value="<?php echo $rs_order['datepaytext'] ?>" placeholder="วันที่โอน" class="form-control">
                    </div>

                    <div class="form-group">
                        เวลาที่โอนโดยประมาณ
                        <input name="timepay" required type="time" value="<?php echo $rs_order['timepay'] ?>" placeholder="เวลาที่โอน" class="form-control">
                    </div>

                    <div class="form-group">
                        แนบหลักฐาน
                        <input name="slipe" <?php if(!$rs_order){ echo "required"; } ?> type="file" class="form-control">
                        <input type="hidden" name="noselect" value="<?php echo $rs_order['slipe'] ?>">
                    </div>

                    <div class="from-group">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> บันทึกข้อมูล</button>
                    </div>
                </form>
            <?php } else { ?>
                <div class="alert alert-danger"><strong>ขออภัย!!!</strong> ไม่สามารถดูประวัติการสั่งซื้อสินค้าได้ค่ะ กรุณาเข้าสู่ระบบก่อน <a href="formlogin.php">[เข้าสู่ระบบ]</a></div>
            <?php } ?>
        </div>
    </div> 
</div>
<?php require_once 'footer.php' ?>