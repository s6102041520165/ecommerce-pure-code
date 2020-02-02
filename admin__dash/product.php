<?php require_once 'header.php' ?>

<?php if($_GET['form']=='add') { ?>
    <p><button onclick="window.history.back()" class="btn btn-warning"><span class="fa fa-undo-alt" ></span> Back</button></p>
    <form enctype="multipart/form-data" name="frmadd" action="ac_product.php?action=add" onsubmit="return checkpass();" method="post">
        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อสินค้า</label>
            </div>
            <input type="text" class="form-control" required name="proName">
            <input type="hidden" name="proID" value="<?php echo $rs_product['proID']; ?>">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รูปโปรไฟล์สินค้า</label>
            </div>
            <input type="file" class="form-control" required name="proPic">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รูปภาพสินค้า</label>
            </div>
            <input type="file" class="form-control" name="proPicName[]" multiple="multiple">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รายละเอียดสินค้า</label>
            </div>
            <textarea rows="5" class="form-control" required name="proDetails"></textarea>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">จำนวนคงเหลือ</label>
            </div>
            <input type="number" class="form-control" name="proQty" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อหน่วยสินค้า</label>
            </div>
            <input type="text" class="form-control" name="UnitName" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ราคาสินค้า</label>
            </div>
            <input type="number" class="form-control" name="proPrice" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ประเภทสินค้า</label>
            </div>
            <select name="catgID" id="" class="form-control" required>
                <option value="">--กรุณาเลือกประเภทสินค้า--</option>
                <?php 
                $sql_catg = $pdo->query(" select * from tbl_categories ");
                while($rs_catg = $sql_catg->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?php echo $rs_catg['catgID']; ?>"><?php echo $rs_catg['catgName']; ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>
    </form>
<?php } elseif($_GET['form']=='edit') { ?>
    <?php 
    $sql = " select * from tbl_product where proID = '".$_GET['proID']."' ";
    $query = $pdo->query( $sql);
    $rs_product = $query->fetch(PDO::FETCH_ASSOC);
    ?>
    <form enctype="multipart/form-data" name="frmedit" action="ac_product.php?action=edit" onsubmit="return checkpass();" method="post">
    <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อสินค้า</label>
            </div>
            <input type="hidden" name="proID" value="<?php echo $rs_product['proID'] ?>">
            <input type="text" class="form-control" value="<?php echo $rs_product['proName'] ?>" required name="proName">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รูปโปรไฟล์สินค้า</label>
            </div>
            <input type="file" class="form-control" name="proPic">
            <input type="hidden" name="noselect" value="<?php echo $rs_product['proPic'] ?>">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รูปภาพสินค้า</label>
            </div>
            <input type="file" class="form-control" name="proPicName[]" multiple="multiple">
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">รายละเอียดสินค้า</label>
            </div>
            <textarea rows="5" class="form-control" required name="proDetails"><?php echo $rs_product['proDetails'] ?></textarea>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">จำนวนคงเหลือ</label>
            </div>
            <input type="number" class="form-control" name="proQty" value="<?php echo $rs_product['proQty'] ?>" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ชื่อหน่วยสินค้า</label>
            </div>
            <input type="text" class="form-control" name="UnitName" value="<?php echo $rs_product['UnitName'] ?>" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ราคาสินค้า</label>
            </div>
            <input type="number" class="form-control" value="<?php echo $rs_product['proPrice'] ?>" name="proPrice" required>
        </div>

        <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">ประเภทสินค้า</label>
            </div>
            <select name="catgID" id="" class="form-control" required>
                <option value="">--กรุณาเลือกประเภทสินค้า--</option>
                <?php 
                $sql_catg = $pdo->query(" select * from tbl_categories ");
                while($rs_catg = $sql_catg->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?php echo $rs_catg['catgID']; ?>" <?php if($rs_product['catgID']==$rs_catg['catgID']){ echo "selected"; } ?>><?php echo $rs_catg['catgName']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">บันทึก</button>
    </form>
<?php } else { ?>
    <?php
    if(isset($_GET['keyword'])){
        $sql = " SELECT * from tbl_product WHERE proName LIKE '%".$_GET['keyword']."%' ";
        $query = $pdo->query( $sql);
    } else {
        $sql = " select * from tbl_product ";
        $query = $pdo->query( $sql);
    }
    $Num_Rows = $query->rowCount();
    $Per_Page = 5;   // Per Page
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
        $Num_Pages =1;
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
    $sql .=" order by proName ASC LIMIT $Page_Start , $Per_Page";
    $query  = $pdo->query($sql);
    $number = 1;
    ?>
    <p><button onclick="window.location='<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=add'" class="btn btn-primary"><span class="fa fa-plus"></span> เพิ่มสินค้า</button></p>
    <div class="table-responsive-sm table-responsive-md table-responsive-lg">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ลำดับ</td>
                    <td>ชื่อสินค้า</td>
                    <td>ราคา</td>
                    <td>คงเหลือ</td>
                    <td>การจัดการ</td>
                </tr>
            </thead>
            <tbody>
            <?php 
                while($rs_product=$query->fetch(PDO::FETCH_ASSOC)){
            ?>
                <tr>
                    <td width="10%"><?php echo $number; ?></td>
                    <td width="40%">
                        <?php echo $rs_product['proName']; ?><br>
                        <?php 
                        $sql_pic = $pdo->query(" select * from tbl_pic_product where proID = '".$rs_product['proID']."' ");
                        while($rs_pic = $sql_pic->fetch(PDO::FETCH_ASSOC)){
                            echo "<p><img class=\"img-thumbnail\" src=\"../image/".$rs_pic['proPicName']."\" width=\"30%\" height=\"auto\" /> <a href=\"ac_product.php?action=remove_pic&proPicID=$rs_pic[proPicID]&proPicName=$rs_pic[proPicName]\" class=\"btn btn-danger\"><span class=\"fa fa-trash\"></span></a></p> ";
                        }
                        ?>

                    </td>
                    <td width="20%"><?php echo $rs_product['proPrice']; ?></td>
                    <td width="20%"><?php echo $rs_product['proQty']." ".$rs_product['UnitName']; ?></td>

                    <td width="10%">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?form=edit&proID=<?php echo $rs_product['proID'] ?>" class="btn btn-outline-primary btn-sm "><span class="fa fa-edit"></span></a>
                            <a href="ac_product.php?action=remove&proID=<?php echo $rs_product['proID'] ?>" onclick="return chkfirm('คุณต้องการลบข้อมูลใช่หรือไม่')" class="btn btn-outline-danger btn-sm "><span class="fa fa-trash-alt"></span></a>
                        </div>
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
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $Prev_Page; ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        <?php } ?>
            <?php for($i=1; $i<=$Num_Pages; $i++){ ?>
                <?php if($i != $Page){ ?>
                    <li class="page-item">
                        <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a>
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
                <a class="page-link"  href="<?php echo $_SERVER['SCRIP_NAME'] ?>?page=<?php echo $Next_Page;?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
<?php require_once 'footer.php' ?>