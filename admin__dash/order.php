<?php require_once 'header.php' ?>

<?php if($_GET['form']=='add') { ?>
   
<?php } else { ?>
    <?php
    if($_GET['status']==1){
        $sql = " SELECT tbl_order.*,tbl_user.* FROM tbl_order INNER JOIN tbl_user ON (tbl_order.username=tbl_user.username) WHERE showOrder = 'yes' AND status = 'no' ";
        $query = $pdo->query( $sql);
    } elseif($_GET['status']==2) {
        $sql = " SELECT tbl_order.*,tbl_user.* FROM tbl_order INNER JOIN tbl_user ON (tbl_order.username=tbl_user.username) WHERE showOrder = 'yes' AND status = 'yes' ";
        $query = $pdo->query( $sql);
    }
    $Num_Rows = $query->rowCount();
    $Per_Page = 12;   // Per Page
    $Page = $_GET["page"];
    if(!$_GET["page"])
    {
        $Page=1;
    }
    $Prev_Page = $Page-1;
    $Next_Page = $Page+1;
    $Page_Start = (($Per_Page*$Page)-$Per_Page);
    if($Num_Rows<=$Per_Page)
    {
        $Num_Pages = 1;
    }
    else if(($Num_Rows % $Per_Page)==0)
    {
        $Num_Pages =($Num_Rows/$Per_Page) ;
    }
    else
    {
        $Num_Pages =($Num_Rows/$Per_Page)+1;
        $Num_Pages = (int)$Num_Pages;
    }
    $sql .=" order by orderID ASC LIMIT $Page_Start , $Per_Page";
    $query  = $pdo->query($sql) or die(mysqli_error($conn));
    $number = 1;
    ?>
    <div class="table-responsive-sm table-responsive-md table-responsive-lg">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>รหัสใบสั่งซื้อ</td>
                    <td>ชื่อ - สกุล</td>
                    <td>ช่องทางการชำระเงิน</td>
                    <td>จำนวนเงิน</td>
                    <td>สถานะ</td>
                    <td><center>การจัดการ</center></td>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rs_order=$query->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr>
                    <td width="15%"><?php echo $rs_order['orderID']; ?></td>
                    <td width="25%"><?php echo $rs_order['name']." ".$rs_order['surname']; ?></td>
                    <td width="20%"><?php if($rs_order['payoption'] == 'card'){ echo "ชำระด้วยบัตรเครดิต / เดบิต"; } else { echo "ชำระเงินกับธนาคาร"; }; ?></td>
                    <td width="15%"><?php echo number_format($rs_order['sumtotal'],2); ?></td>
                    <td width="15%"><?php if($rs_order['status'] == 'no'){ echo "ยังไม่ชำระเงิน"; } else { echo "ชำระเงินแล้ว"; }; ?></td>
                    <td>
                        <center>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-outline-info btn-sm" onclick="window.location='order_detail.php?orderID=<?php echo $rs_order['orderID'] ?>&status=<?php echo $_GET['status'] ?>'"><span class="fa fa-search-plus"></span></button>
                                <a target="_blank" class="btn btn-outline-primary btn-sm" href="bill.php?orderID=<?php echo $rs_order['orderID'] ?>"><span class="fa fa-print"></span></a>
                                <?php if(isset($_GET['status']) && $_GET['status']==1 || $_GET['status']==2) { ?>
                                    <a href="removeorder.php?orderID=<?php echo $rs_order['orderID']; ?>" onclick="return chkfirm('คุณต้องการลบข้อมูลใช่หรือไม่')" class="btn btn-outline-danger btn-sm "><span class="fa fa-trash-alt"></span></a>
                                <?php } ?>
                            </div>
                        </center>
                    </td>
                </tr>
            <?php $number+=1; } ?>
            </tbody>
        </table>
    </div>
    <span class="badge badge-primary ">หน้า : <?php echo $Page."/".$Num_Pages; ?></span>
    <nav aria-label="Page navigation example">
        <br>
        <ul class="pagination">
        <?php if($Prev_Page){ ?>
            <li class="page-item">
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?status=<?php echo $_GET['status']; ?>&page=<?php echo $Prev_Page; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
            <?php for($i=1; $i<=$Num_Pages; $i++){ ?>
                <?php if($i != $Page){ ?>
                    <li class="page-item">
                        <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?status=<?php echo $_GET['status']; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } else { ?>
                    <li class="page-item active">
                        <a class="page-link" ><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            <?php } 
            if($Page!=$Num_Pages){
            ?>
            <li class="page-item">
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?status=<?php echo $_GET['status']; ?>&page=<?php echo $Next_Page;?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
<?php require_once 'footer.php' ?>