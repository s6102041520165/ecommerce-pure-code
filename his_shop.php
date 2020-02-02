<?php require_once 'header.php' ?>
<?php require_once 'sidebar.php' ?>
<?php
$trackingArr = [];
$rawObj = "";
?>


<div class="col-md-9 col-lg-9">
    <br>
    <div class="card border-pink">
        <div class="card-header bg-pink text-light">
            <span class="fa fa-shopping-cart"></span> ประวัติการสั่งซื้อ
        </div>
        <div class="card-body">
            <?php if ($rs_member->username) { ?>
                <form name="frmselect" class="float-right form-group col-lg-6 col-md-6 col-sm-12 " action="his_shop.php" method="get">
                    <select required class="form-control" name="orderID" onchange="document.frmselect.submit();">
                        <option value="">--- กรุณาเลือกรหัสใบสั่งซื้อค่ะ ---</option>
                        <?php
                        $sql_option = $pdo->query("SELECT * FROM tbl_order 
                                WHERE showOrder = 'yes' 
                                AND username = '" . $rs_member->username . "' 
                                ORDER BY orderID DESC ");

                        while ($rsoption = $sql_option->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?php echo $rsoption['orderID'] ?>" <?php if ($_GET['orderID'] == $rsoption['orderID']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $rsoption['orderID'] ?></option>
                        <?php } ?>
                    </select>
                </form>
                <?php
                if ($_GET['orderID']) {
                    $sql = $pdo->query(" SELECT * FROM tbl_order 
                                WHERE showOrder = 'yes' 
                                AND username = '" . $rs_member->username . "' 
                                AND orderID = '" . $_GET['orderID'] . "' 
                                ORDER BY orderID DESC LIMIT 1 ");
                } else {
                    $sql = $pdo->query(" SELECT * FROM tbl_order 
                                WHERE showOrder = 'yes' 
                                AND username = '" . $rs_member->username . "' 
                                ORDER BY orderID DESC LIMIT 1 ");
                }
                while ($rs_order = $sql->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td class="bg-pink text-light" colspan="4">
                                    <center>รหัสใบสั่งซื้อ : <?php echo $rs_order['orderID'] . " (" . $rs_order['dateOrder'] . ")"; ?>
                                        <a href="removeorder.php?orderID=<?php echo $rs_order['orderID']; ?>" onclick="return chkfirm('คุณต้องการลบรายการนี้ใช่หรือไม่')" class="btn btn-danger"><span class="fa fa-trash"></span></a></center>
                                </td>
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
                            //Check for Push Array Object
                            if (!empty($rs_order['tracking'])) {
                                array_push($trackingArr, $rs_order['tracking']);
                            }
                            $rawObj = json_encode($trackingArr);

                            $sql2 = $pdo->query(" SELECT tbl_order_detail.*,tbl_product.* 
                                FROM tbl_order_detail 
                                INNER JOIN tbl_product
                                ON (tbl_order_detail.proID=tbl_product.proID) 
                                WHERE orderID='" . $rs_order['orderID'] . "' ") or die(mysqli_error($conn));


                            while ($rs_order_detail = $sql2->fetch(PDO::FETCH_ASSOC)) {
                                $total = $rs_order_detail['qty'] * $rs_order_detail['proPrice'];
                                $prototal += $total;
                                $tax = ($prototal * 7) / 100;
                                $sumtotal = $prototal + $tax;

                            ?>
                                <tr>
                                    <td width="50%">
                                        <?php echo $rs_order_detail['proName']; ?>
                                        <br><img src="image/<?php echo $rs_order_detail['proPic']; ?>" style="width:30%;height:auto" class="rounded" alt="">
                                    </td>
                                    <td width="15%"><?php echo number_format($rs_order_detail['proPrice'], 2); ?> บาท </td>
                                    <td width="20%">
                                        <?php echo $rs_order_detail['qty']; ?>
                                        / <?php echo $rs_order_detail['proQty']; ?><br>
                                    </td>
                                    <td width="15%">
                                        <?php echo number_format($total, 2); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td class="bg-light" valign="middle" align="center" rowspan="3" colspan="2">
                                    <a href="showbill.php?orderID=<?php echo $rs_order['orderID']; ?>">พิมพ์ใบสั่งซื้อ</a>
                                    <?php if ($rs_order['status'] == "no") {
                                        echo "<br><a>กรุณาชำระเงินภายใน 3 วัน</a>";
                                    } ?>
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
                            <tr>
                                <td class="bg-warning text-center " colspan="4">พัสดุ :
                                    <a target="_blank" href="http://emsbot.com/#/?s=<?php echo $rs_order['tracking']; ?>"><?php echo $rs_order['tracking']; ?></a>
                                    <div id="<?php echo $rs_order['tracking'] ?>"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    if ($rs_order['payoption'] == 'bank') {
                    ?>
                        <?php
                        $sqlbank = $pdo->query(" SELECT * from tbl_payment WHERE orderID = '" . $rs_order['orderID'] . "' ");
                        $rsbank = $sqlbank->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <?php if ($rsbank == NULL) { ?>
                            <center><button onclick="window.location='payment.php?orderID=<?php echo $rs_order['orderID']; ?>'" class="btn btn-warning">แจ้งชำระเงิน</button></center>
                        <?php } else { ?>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="bg-pink text-light">
                                            <center>รายละเอียดการชำระเงิน (ผ่านธนาคาร)</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        <td width="70%"><?php echo number_format($rsbank['amount'], 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="text-right"><strong>วันที่ชำระเงิน :</strong></td>
                                        <td width="70%"><?php echo $rsbank['datepay']; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="text-right"><strong>สถานะ :</strong></td>
                                        <td width="70%"><?php if ($rsbank['status'] == "yes") {
                                                            echo "ตรวจสอบแล้ว";
                                                        } else {
                                                            echo "ยังไม่ตรวจสอบ";
                                                        }; ?></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" class="text-right"><strong>หลักฐานการแจ้งชำระเงิน :</strong></td>
                                        <td width="70%">
                                            <a target="_blank" href="image/<?php echo $rsbank['slipe']; ?>"><img src="image/<?php echo $rsbank['slipe']; ?>" width="400px" height="auto" alt=""></a>
                                            <br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                    <?php } elseif ($rs_order['payoption'] == 'card') { ?>
                        <br>
                        <?php
                        $sqlcradit = $pdo->query(" SELECT * from tbl_card WHERE orderID = '" . $rs_order['orderID'] . "' ");
                        $rscradit = $sqlcradit->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="bg-pink text-light">
                                        <center>รายละเอียดการชำระเงิน (บัตรเครดิต/เดบิต)</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="30%" class="text-right"><strong>ยอดเงินที่ชำระ :</strong></td>
                                    <td width="70%"><?php echo number_format($rscradit['amount'], 2); ?></td>
                                </tr>
                                <tr>
                                    <td width="30%" class="text-right"><strong>วันที่ชำระเงิน :</strong></td>
                                    <td width="70%"><?php echo $rscradit['datepay']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-danger"><strong>ขออภัย!!!</strong> ไม่สามารถดูประวัติการสั่งซื้อสินค้าได้ค่ะ กรุณาเข้าสู่ระบบก่อน <a href="formlogin.php">[เข้าสู่ระบบ]</a></div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    const SetUpVal = params => {
        axios({
            method: 'post',
            url: 'https://trackapi.thailandpost.co.th/post/api/v1/authenticate/token',
            data: {},
            headers: {
                Authorization: "Token V/ZjMgReGHF8WgG!IMEIQpVCZzWIXST+ROBcYoJrZ/LDJ-I!K@Y=ViF/Z0B:A|VFZ0IsTD.EzZHA;C!J2MPYEQ~ZeO#UTYSRNWv"
            }
        }).then((response) => {
            try {
                if (response.status === 200) {
                    console.log("Successful.")
                    let AccessToken = `Token ${response.data.token}`;
                    showData(AccessToken);
                }
            } catch (err) {
                console.log(err);
            }
        })
    }

    const showData = (AccessToken) => {
        let bodies = JSON.stringify({
            status: "all",
            language: "TH",
            barcode: <?php echo $rawObj; ?>
        });
        axios({
            method: 'post',
            url: 'https://trackapi.thailandpost.co.th/post/api/v1/track',
            data: bodies,
            headers: {
                Authorization: AccessToken,
                "Content-Type": "application/json"
            }
        }).then((response) => {
            let dataItem = response.data.response.items;
            let data = Object.values(dataItem);

            data[0].forEach(res => {

                ($(`#${res.barcode}`)).html('<span class="badge badge-primary">'+res.status_description+'<span>');
            })

            


            /*response.data.response.items.forEach(fetchData => {
                console.log(fetchData)
            });*/
        });
        //console.log(bodies)
    }

    setTimeout(SetUpVal, 1000)
</script>

<?php require_once 'footer.php' ?>