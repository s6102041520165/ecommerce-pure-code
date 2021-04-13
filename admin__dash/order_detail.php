<?php require_once 'header.php' ?>
<?php 
if($_GET['action']=='trackingsave' && isset($_POST['tracking']) && isset($_POST['orderID'])){
    $update = $pdo->query("UPDATE tbl_order SET tracking = '".$_POST['tracking']."' WHERE orderID='".$_POST['orderID']."' ");
    echo "<script>window.history.back();</script>";
} elseif($_GET['action']=='statusyes' && isset($_GET['orderID'])){
    $update1 = $pdo->query(" UPDATE tbl_order SET status='yes' WHERE orderID='".$_GET['orderID']."' ");
    $update2 = $pdo->query(" UPDATE tbl_payment SET status='yes' WHERE orderID='".$_GET['orderID']."' ");
    $sql = $pdo->query("SELECT * FROM tbl_order_detail WHERE orderID = '".$_GET['orderID']."' ");
    while ($rs_update = $sql->fetch(PDO::FETCH_ASSOC)) {
       $update3=$pdo->query(" UPDATE tbl_product 
                SET proQty = proQty - '".$rs_update['qty']."' 
                WHERE proID='".$rs_update['proID']."' LIMIT 1 ") ;
    }
    echo "<script>window.history.back();</script>";
} elseif($_GET['action']=='statusno' && isset($_GET['orderID'])){
    $update1 = $pdo->query(" UPDATE tbl_order SET status='no' WHERE orderID='".$_GET['orderID']."' ");
    $update2 = $pdo->query(" UPDATE tbl_payment SET status='no' WHERE orderID='".$_GET['orderID']."' ");
    $sql = $pdo->query("SELECT * FROM tbl_order_detail WHERE orderID = '".$_GET['orderID']."' ");
    while ($rs_update = $sql->fetch(PDO::FETCH_ASSOC)) {
       $update3=$pdo->query(" UPDATE tbl_product 
                SET proQty = proQty + '".$rs_update['qty']."' 
                WHERE proID='".$rs_update['proID']."' LIMIT 1 ") ;
    }  
    echo "<script>window.history.back();</script>";
}
?>
    <?php 
    if($_GET['orderID']){
        $sql = $pdo->query(" SELECT * FROM tbl_order INNER JOIN tbl_user ON (tbl_order.username=tbl_user.username) WHERE showOrder = 'yes' AND orderID = '".$_GET['orderID']."' ORDER BY orderID DESC LIMIT 1 ") ;
    } else {
        $sql = $pdo->query(" SELECT * FROM tbl_order INNER JOIN tbl_user ON (tbl_order.username=tbl_user.username) WHERE showOrder = 'yes' ORDER BY orderID DESC LIMIT 1 ") ;
    }
        $rs_order = $sql->fetch(PDO::FETCH_ASSOC);
    ?>

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            ข้อมูลลูกค้า
        </div>
        <div class="card-body">
            คุณ <?php echo $rs_order['name']." ".$rs_order['surname']; ?><br>
            อีเมล์ : <?php echo $rs_order['email']." <br>เบอร์โทร : ".$rs_order['tel']; ?><br>
            ที่อยู่ <?php echo $rs_order['addr']." ตำบล".$rs_order['locality']." อำเภอ".$rs_order['district']." จังหวัด".$rs_order['province']." รหัสไปรษณีย์ ".$rs_order['zipcode']; ?>
        </div>
    </div>
    <br>

    <table class="table table-striped">
        <thead>
            <tr>
                <td class="bg-primary text-white" colspan="4"><center>รหัสใบสั่งซื้อ : <?php echo $rs_order['orderID']." (".$rs_order['dateOrder'].")"; ?></td>
            </tr>
            <tr>
                <th>สินค้า</th>
                <th>ราคา /1 หน่วย</th>
                <th>จำนวน / คงเหลือ</th>
                <th>ราคารวม</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $sumtotal = 0; 
                $prototal = 0;
                $tax = 0;
                $sql2 = $pdo->query(" SELECT tbl_order_detail.*,tbl_product.* 
                FROM tbl_order_detail 
                INNER JOIN tbl_product
                ON (tbl_order_detail.proID=tbl_product.proID) 
                WHERE orderID='".$rs_order['orderID']."' ") or die(mysqli_error($conn));
                while($rs_order_detail = mysqli_fetch_assoc($sql2)){
                    $total = $rs_order_detail['qty']*$rs_order_detail['proPrice'];
                    $prototal += $total;
                    $tax = ($prototal*7)/100;
                    $sumtotal = $prototal + $tax;
            ?>
            <tr>
                <td width="50%">
                    <?php echo $rs_order_detail['proName']; ?>
                    <br><img src="../image/<?php echo $rs_order_detail['proPic']; ?>" style="width:30%;height:auto" class="rounded" alt="">
                </td>
                <td width="15%"><?php echo number_format($rs_order_detail['proPrice'],2); ?> บาท </td>
                <td width="20%">
                <?php echo $rs_order_detail['qty']; ?> 
                    / <?php echo $rs_order_detail['proQty']; ?><br>
                </td>
                <td width="15%">
                    <?php echo number_format($total,2); ?>
                </td>
            </tr>
            <?php } ?>
            <tr>
                <td class="bg-light" valign="middle" align="center" rowspan="3" colspan="2">
                    <a href="showbill.php?orderID=<?php echo $rs_order['orderID']; ?>">พิมพ์ใบสั่งซื้อ</a>
                    <?php if($rs_order['status'] == "no" ){ echo "<br><a>กรุณาชำระเงินภายใน 3 วัน</a>"; } ?>
                </td>
                <td align="right">ราคาสินค้ารวม</td>
                <td><?php echo number_format($prototal,2); ?></td>
            </tr>
            <tr>
                <td align="right">ภาษี 7 %</td>
                <td><?php echo number_format($tax,2); ?></td>
            </tr>
            <tr>
                <td align="right">ราคารวมสุทธิ</td>
                <td><?php echo number_format($sumtotal,2); ?></td>
            </tr>
            <tr>
                <td colspan="4">
                    <form action="order_detail.php?action=trackingsave" onsubmit="return chkfirm('คุณต้องการดำเนินการต่อหรือไม่!!!')" method="post">
                        <div class="form-group">พัสดุ : 
                            <input maxlength="13" type="text" class="form-control" name="tracking" required value="<?php echo $rs_order['tracking']; ?>" id="">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="orderID" value="<?php echo $rs_order['orderID']; ?>">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <?php 
        if($rs_order['payoption']=='bank'){
    ?>
        <?php 
        $sqlbank = $pdo->query(" SELECT * from tbl_payment WHERE orderID = '".$rs_order['orderID']."' ");
        $rsbank = mysqli_fetch_assoc($sqlbank);
        ?>
        <?php if($rsbank==NULL){ ?>
            <center><button onclick="window.location='payment.php?orderID=<?php echo $rs_order['orderID']; ?>'" class="btn btn-warning">แจ้งชำระเงิน</button></center>
        <?php } else { ?>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2" class="bg-primary text-white"><center>รายละเอียดการชำระเงิน (ผ่านธนาคาร)</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="30%" class="text-right"><strong>การจัดการ :</strong></td>
                        <td width="70%">
                            <p> คลิกปุ่มนี้หาก <button type="button" onclick="if(chkfirm('คุณต้องการดำเนินการต่อหรือไม่')==true){window.location='order_detail.php?action=statusyes&orderID=<?php echo $rs_order['orderID'] ?>'}" <?php if($rs_order['status']=='yes') { echo "disabled"; } ?> class="btn btn-primary">ชำระเงินแล้ว</button></p>
                            <p> คลิกปุ่มนี้หาก <button type="button" onclick="if(chkfirm('คุณต้องการดำเนินการต่อหรือไม่')==true){window.location='order_detail.php?action=statusno&orderID=<?php echo $rs_order['orderID'] ?>'}" <?php if($rs_order['status']=='no') { echo "disabled"; } ?> class="btn btn-danger">ยังไม่ชำระเงิน</button></p>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>ธนาคาร :</strong></td>
                        <td width="70%"><?php echo $rsbank['bank']; ?> <a href="payment.php?orderID=<?php echo $rs_order['orderID'] ?>">[แก้ไขข้อมูล]</a></td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>สาขา/สถานที่โอน :</strong></td>
                        <td width="70%"><?php echo $rsbank['location']; ?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>ยอดเงินที่ชำระ :</strong></td>
                        <td width="70%"><?php echo number_format($rsbank['amount'],2); ?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>วันที่ชำระเงิน :</strong></td>
                        <td width="70%"><?php echo $rsbank['datepay']; ?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>สถานะ :</strong></td>
                        <td width="70%"><?php if($rsbank['status']=="yes"){ echo "ตรวจสอบแล้ว"; } else { echo "ยังไม่ตรวจสอบ";}; ?></td>
                    </tr>
                    <tr>
                        <td width="30%" class="text-right"><strong>หลักฐานการแจ้งชำระเงิน :</strong></td>
                        <td width="70%">
                            <a target="_blank" href="../image/<?php echo $rsbank['slipe']; ?>"><img src="../image/<?php echo $rsbank['slipe']; ?>" width="400px" height="auto" alt=""></a>
                            <br>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        <?php } ?>
    <?php } elseif($rs_order['payoption']=='card'){ ?>
    <br>
        <?php 
        $sqlcradit = $pdo->query(" SELECT * from tbl_card WHERE orderID = '".$rs_order['orderID']."' ");
        $rscradit = mysqli_fetch_assoc($sqlcradit);
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="2" class="bg-primary text-white"><center>รายละเอียดการชำระเงิน (บัตรเครดิต/เดบิต)</center></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <td width="30%" class="text-right"><strong>ยอดเงินที่ชำระ :</strong></td>
                    <td width="70%"><?php echo number_format($rscradit['amount'],2); ?></td>
                </tr>
                <tr>
                    <td width="30%" class="text-right"><strong>วันที่ชำระเงิน :</strong></td>
                    <td width="70%"><?php echo $rscradit['datepay']; ?></td>
                </tr>
            </tbody>
        </table>
    <?php } ?>

<?php require_once 'footer.php' ?>