<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>
<div class="col-md-9 col-lg-9">
    <br>
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb bg-pink ">
            <li class="breadcrumb-item"><a class="text-light">ขั้นตอนที่ 1 ข้อมูลลูกค้า</a></li>
            <li class="breadcrumb-item"><a class="text-secondary">ขั้นตอนที่ 2 การจัดส่ง</a></li>
            <li class="breadcrumb-item"><a class="text-secondary">ขั้นตอนที่ 3 การสั่งซื้อเสร็จสิ้น</a></li>
        </ol>
    </nav>
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
                for ($i = 0; $i <= (int) $_SESSION['intline']; $i++) {
                    if ($_SESSION['proID'][$i] != "") {
                        $sql = " select * from tbl_product where proID = '" . $_SESSION['proID'][$i] . "' ";
                        $query = $pdo->query($sql);
                        $rs_product = $query->fetch(PDO::FETCH_OBJ);
                        $total = $rs_product->proPrice * $_SESSION['qty'][$i];
                        $prototal += $total;
                        $tax = ($prototal * 7) / 100;
                        $sumtotal = $prototal + $tax;
                        $sql2 = $pdo->query("SELECT SUM(qty) AS sumqty,payoption
                                FROM tbl_order_detail left join tbl_order
                                ON (tbl_order_detail.orderID=tbl_order.orderID)
                                WHERE proID = '" . $rs_product->proID . "' AND status = 'no'
                                AND showOrder <> 'no'
                                GROUP BY proID; ");
                        $rsqty = $sql2->fetch(PDO::FETCH_OBJ);
                ?>
                        <tr>
                            <td width="50%">
                                <?php echo $rs_product->proName; ?>
                                <br><img src="image/<?php echo $rs_product->proPic; ?>" style="width:40%;height:auto" class="rounded" alt="">
                                <a href="action.php?cart=remove&line=<?php echo $i; ?>" onclick="return chkfirm('ต้องการลบสินค้าออกจากรถเข็นใช่หรือไม่');" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                            </td>
                            <td width="15%"><?php echo number_format($rs_product->proPrice, 2); ?> บาท </td>
                            <td width="20%">
                                <input type="number" min="1" max="<?php echo $rs_product->proQty - $rsqty->sumqty; ?>" class="form-control" name="qty<?php echo $i; ?>" value="<?php echo $_SESSION['qty'][$i]; ?>">
                                คงเหลือ : <?php echo $rs_product->proQty; ?><br>
                                (จอง : <?php echo $rsqty->sumqty; ?>)
                            </td>
                            <td width="15%">
                                <?php echo number_format($total, 2); ?>
                            </td>
                        </tr>

                <?php
                    }
                }
                if (!isset($_SESSION['proID']) || $_SESSION['proID'] == NULL) {
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
                    <td class="bg-light text-light" valign="middle" align="center" rowspan="3" colspan="2">
                        <button class="btn-outline-primary btn" type="submit">อัพเดท</button>
                    </td>
                    <td align="right">ราคาสินค้ารวม</td>
                    <td><?php echo number_format($prototal, 2); ?></td>
                </tr>
                <tr>
                    <td align="right">ภาษี 7 %</td>
                    <td><?php echo number_format($tax, 2); ?></td>
                </tr>
                <tr>
                    <td align="right">ราคารวมสุทธิ</td>
                    <td><?php echo number_format($sumtotal, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </form>

    <?php if ($rs_member->username) { ?>
        <div class="card border-pink">
            <div class="card-header bg-pink text-light">
                <span class="fa fa-user"></span> ข้อมูลลูกค้า
            </div>
            <div class="card-body">
                <form action="checkout.php?step=2" method="post">

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">ชื่อ</label>
                            </div>
                            <input value="<?php echo $rs_member->name; ?>" type="text" class="form-control" required name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">นามสกุล</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->surname; ?>" class="form-control" required name="surname">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">อีเมล์</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->email; ?>" class="form-control" required name="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">เบอร์โทร</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->tel; ?>" class="form-control" required name="tel">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">ที่อยู่</label>
                            </div>
                            <textarea rows="5" class="form-control" required name="addr"><?php echo $rs_member->addr; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">ตำบล</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->locality; ?>" rows="5" class="form-control" required name="locality">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">อำเภอ</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->district; ?>" rows="5" class="form-control" required name="district">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">จังหวัด</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->province; ?>" rows="5" class="form-control" required name="province">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">รหัสไปรษณีย์</label>
                            </div>
                            <input type="text" value="<?php echo $rs_member->zipcode; ?>" rows="5" class="form-control" required name="zipcode">
                        </div>
                    </div>


                    <center>

                        <button type="submit" class="btn btn-primary">ขั้นตอนถัดไป</button>

                    </center>

                </form>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger"><strong>ขออภัย!!!</strong> กรุณาเข้าสู่ระบบก่อนค่ะ <a href="formlogin.php">[เข้าสู่ระบบ]</a></div>
    <?php } ?>
</div>
<?php require_once 'footer.php' ?>