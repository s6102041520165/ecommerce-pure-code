<?php require_once 'header.php' ?>
<?php 
if(isset($_GET['step']) && $_GET['step']==2){
    $update = $pdo->query(" UPDATE tbl_user set 
             name = '".$_POST['name']."',surname = '".$_POST['surname']."',email = '".$_POST['email']."',tel = '".$_POST['tel']."',addr = '".$_POST['addr']."',locality = '".$_POST['locality']."',district = '".$_POST['district']."',province = '".$_POST['province']."',zipcode = '".$_POST['zipcode']."' 
             WHERE username = '".$rs_member->username."' ");
    echo "<script>window.location='checkout.php';</script>";
}
?>
<style>
    .omise-checkout-button{
        background:blue;
        border:blue;
        line-height:30px;
        padding:10px;
        border-radius:5px;
        color:white;
    }
</style>
<?php require_once 'sidebar.php' ?>

<div class="col-md-9 col-lg-9">
    <br>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-info ">
            <li class="breadcrumb-item"><a class="text-white">ขั้นตอนที่ 1 ข้อมูลลูกค้า</a></li>
            <li class="breadcrumb-item"><a class="text-white" >ขั้นตอนที่ 2 การจัดส่ง</a></li>
            <li class="breadcrumb-item"><a class="text-secondary" >ขั้นตอนที่ 3 การสั่งซื้อเสร็จสิ้น</a></li>
        </ol>
    </nav>

    <?php if($_GET['load']=='failed'){ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>เกิดข้อผิดพลาด!</strong> ไม่สามารถชำระเงินได้กรุณาตรวจสอบข้อมูลบัตรของคุณอีกครั้งค่ะ
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <form action="action.php?cart=update" method="post">
        <table class="table table-striped">
            <thead>
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
                for($i=0;$i<=(int)$_SESSION['intline'];$i++){
                    if($_SESSION['proID'][$i]!=""){
                        $sql = " select * from tbl_product where proID = '".$_SESSION['proID'][$i]."' ";
                        $query = $pdo->query($sql);
                        $rs_product = $query->fetch(PDO::FETCH_ASSOC);
                        $total = $rs_product['proPrice']*$_SESSION['qty'][$i];
                        $prototal += $total;
                        $tax = ($prototal*7)/100;
                        $sumtotal = $prototal + $tax;
                        $sql2 = $pdo->query("SELECT SUM(qty) AS sumqty,payoption
                                FROM tbl_order_detail left join tbl_order
                                ON (tbl_order_detail.orderID=tbl_order.orderID)
                                WHERE proID = '".$rs_product['proID']."' 
                                AND status = 'no'
                                AND showOrder <> 'no'
                                GROUP BY proID; ");
                        $rsqty=$sql2->fetch(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <td width="50%">
                    <?php echo $rs_product['proName']; ?>
                    <br><img src="image/<?php echo $rs_product['proPic']; ?>" style="width:40%;height:auto" class="rounded" alt="">
                    <a href="action.php?cart=remove&line=<?php echo $i; ?>" onclick="return chkfirm('ต้องการลบสินค้าออกจากรถเข็นใช่หรือไม่');" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                </td>
                <td width="15%"><?php echo number_format($rs_product['proPrice'],2); ?> บาท </td>
                <td width="20%">
                    <input type="number" min="1" max="<?php echo $rs_product['proQty']; ?>" class="form-control" name="qty<?php echo $i; ?>" value="<?php echo $_SESSION['qty'][$i]; ?>" > 
                    คงเหลือ : <?php echo $rs_product['proQty']; ?><br>
                    (จอง : <?php echo $rsqty['sumqty']; ?>)
                </td>
                <td width="15%">
                    <?php echo number_format($total,2); ?>
                </td>
            </tr>
            
            <?php 
                    } 
                }
                if(!isset($_SESSION['proID']) || $_SESSION['proID']==NULL) {
                    echo "<tr>
                        <td colspan=\"4\">
                            <div class=\"alert alert-danger\" role=\"alert\">
                                ไม่พบสินค้า
                            </div>
                        </td>
                    </tr>";
                }
            ?>
            <tr>
                <td class="bg-light text-white" valign="middle" align="center" rowspan="3" colspan="2">
                    <button class="btn-outline-primary btn" type="submit">อัพเดท</button>
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
            </tbody>
        </table>
    </form> 
    <?php if($rs_member->username) { ?>

    <div class="card border-primary">
        <div class="card-header bg-primary text-white">
            <span class="fa fa-user"></span> ตรวจสอบข้อมูลลูกค้า
        </div>
        <div class="card-body">
            <form action="checkout.php" method="post">

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">ชื่อ</label>
                    </div>
                    <input disabled value="<?php echo $rs_member->name; ?>" type="text" class="form-control" required name="name">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">นามสกุล</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->surname; ?>" class="form-control" required name="surname">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">อีเมล์</label>
                    </div>
                    <input type="text" disabled value="<?php echo $rs_member->email; ?>" class="form-control" required name="email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">เบอร์โทร</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->tel; ?>" class="form-control" required name="tel">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">ที่อยู่</label>
                        </div>
                        <textarea disabled rows="5"  class="form-control" required name="addr"><?php echo $rs_member->addr; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">ตำบล</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->locality; ?>" rows="5" class="form-control" required name="locality">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">อำเภอ</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->district; ?>" rows="5" class="form-control" required name="district">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">จังหวัด</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->province; ?>" rows="5" class="form-control" required name="province">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">รหัสไปรษณีย์</label>
                    </div>
                    <input disabled type="text" value="<?php echo $rs_member->zipcode; ?>" rows="5" class="form-control" required name="zipcode">
                    </div>
                </div>


                <center>
                    <button type="button" onclick="window.location='cart.php'" class="btn btn-warning">< แก้ไขข้อมูลลูกค้า</button>
                </center>
               
            </form>

        </div>
    </div> 
    <br>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <span class="fa fa-credit-card"></span> ชำระเงินด้วยบัตรเครดิต/เดบิต
                </div>
                <div class="card-body">
                <div class="alert alert-info">คุณสามารถชำระเงินผ่านช่องทางนี้ได้ในกรณีที่คุณมีบัตรเครดิต/เดบิต</div>
                    <form name="checkoutForm" method="POST" action="savecheckout.php">
                        <input type="hidden" name="description" value="Product order ฿<?php echo $sumtotal; ?>" />
                        <input type="hidden" name="sumtotal" value="<?php echo $sumtotal; ?>">
                        <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                        <input type="hidden" name="prototal" value="<?php echo $prototal; ?>">
                        <input type="hidden" name="username" value="<?php echo $rs_member->username; ?>">
                        <script type="text/javascript" src="https://cdn.omise.co/card.js"
                        data-key="pkey_test_5eavs1d5xv4lfvr0jhv"
                        data-image="http://localhost/ecommerce/image/logo.jpg"
                        data-frame-label="ร้านฟาร์มสวย"
                        data-button-label="ชำระเงิน"
                        data-submit-label="Submit"
                        data-amount="<?php echo $sumtotal*100; ?>"
                        data-currency="thb"
                        >
                        </script>
                        <!--
                            data-image หมายถึง path ที่เก็บรูปภาพโลโกเว็บไว้
                            data-frame-label ชื่อร้าน
                            data-button-label ข้อความที่ปุ่ม
                            data-submit-label หมายถึง ชนิดปุ่ม
                        -->
                        <!--the script will render <input type="hidden" name="omiseToken"> for you automatically-->               
                    </form>

                </div>
            </div> 
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <span class="fa fa-credit-card"></span> ชำระเงินกับธนาคาร
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">กรุณาอัพโหลดหลักฐานเพื่อยืนยันการชำระเงินภายใน 3 วัน นับตั้งแต่วันที่สั่งซื้อ</div>
                    <form name="checkoutForm" method="POST" action="savecheckout.php?pay=skip">
                        <input type="hidden" name="sumtotal" value="<?php echo $sumtotal; ?>">
                        <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                        <input type="hidden" name="prototal" value="<?php echo $prototal; ?>">
                        <input type="hidden" name="username" value="<?php echo $rs_member->username; ?>">
                        <button class="btn btn-primary">ยืนยันการสั่งซื้อ</button>
                    </form>

                </div>
            </div> 
        </div>
    </div>
    <?php } else { ?>
        <div class="alert alert-danger"><strong>ขออภัย!!!</strong> กรุณาเข้าสู่ระบบก่อนค่ะ <a href="formlogin.php">[เข้าสู่ระบบ]</a></div>
    <?php } ?>
</div>
<?php require_once 'footer.php' ?>